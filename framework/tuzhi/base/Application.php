<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:43
 */

namespace tuzhi\base;

use Tuzhi;
use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\exception\NotFoundServersException;
use tuzhi\contracts\base\IApplication;
use tuzhi\helper\Arr;

/**
 * Class Application
 * @package tuzhi\base
 */
abstract class Application extends Object  implements IApplication
{
    /**
     * @var
     */
    const EVENT_BEFORE_RUN = 'event_before_application_run';

    /**
     * @var
     */
    const EVENT_AFTER_RUN = 'event_after_application_run';

    /**
     *
     */
    const EVENT_APP_END = 'event_application_end';

    /**
      * @var
      */
    public $charset;

     /**
      * @var
      */
    public $timezone;

     /**
      * @var
      */
    public $appPath;

     /**
      * @var
      */
    public $environment;

     /**
      * @var array
      */
    public $bootstrap = [];

    /**
     * @var
     */
    public $service;

    /**
     * @var
     */
    protected  $locator = null;


    /**
     * Init
     */
    public function init()
    {

        Tuzhi::$app = $this;

        /**
         * service
         */
        $this->locator = Tuzhi::make(
            'tuzhi\di\ServiceLocator',
            [$this->serviceCore()]
        );

        /**
         * boot
         */
        Arr::each( $this->bootCore(),function($key,$value)  {
            Tuzhi::$app->bootstrap($value);
        });
    }

    /**
     * @param $boot
     */
    public function bootstrap( $boot )
    {
        call_user_func( [ \Tuzhi::make( $boot )  ,'boot'] ,$this);
    }

    /**
     * @param $service
     * @return mixed
     */
    public function has( $service )
    {
        return $this->locator->has($service);
    }

    /**
     * @param $service
     * @return mixed
     * @throws NotFoundServersException
     */
    public function get( $service )
    {
        $service = $this->locator->get($service);
        if($service){
            return $service;
        }
        throw new NotFoundServersException('Not Found Service '.$service.'!');
    }

    /**
     * @param $serviceName
     * @param $definition
     * @return $this
     */
    public function register( $serviceName , $definition )
    {
        $this->locator->set($serviceName, $definition );
    }

    /**
     * @return array
     */
    protected function bootCore()
    {
        return Arr::marge(
            [
                'tuzhi\base\bootstrap\ApplicationBoot',
                'tuzhi\base\bootstrap\FacadeBoot'
            ], $this->bootstrap
        );
    }

    /**
     * @return array
     */
    protected function serviceCore()
    {
        return Arr::marge(
            [
                'request'=>'tuzhi\web\Request',
                'response'=>'tuzhi\web\Response',
                'router'=>'tuzhi\route\Router',
                'errorHandler'=>'tuzhi\web\ErrorHandler',
                'log'=>'tuzhi\log\Log',
            ],$this->service
        );
    }

//    /**
//     * @param $method
//     * @param $arguments
//     * @return mixed
//     * @throws NotFoundMethodException
//     */
//    public static function __callStatic($method, $arguments)
//    {
//        return Tuzhi::$app->magicCall($method);
//    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
       return $this->get(strtolower($method));
    }

//    /**
//     * @param $method
//     * @return mixed
//     * @throws NotFoundMethodException
//     */
//    public function magicCall( $method )
//    {
//        $method = strtolower( $method );
//        if( ($server =  Tuzhi::$app->get($method) ) ){
//            return $server;
//        }else{
//            throw new NotFoundMethodException( 'Not Found Services '.$method.' ' );
//        }
//    }

    /**
     * @return bool
     */
    public function isDevelopment()
    {
        return strtolower( $this->environment ) == 'development';
    }

    /**
     * @return bool
     */
    public function isTesting()
    {
        return strtolower( $this->environment ) == 'testing';
    }

    /**
     * @return bool
     */
    public function isProduction()
    {
        return strtolower( $this->environment ) == 'production';
    }

    /**
     * @abstract
     */
    abstract public function run();

}