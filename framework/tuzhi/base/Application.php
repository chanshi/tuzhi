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
     */
    public function get( $service )
    {
        return $this->locator->get($service);
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

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public static function __callStatic($method, $arguments)
    {
        return Tuzhi::$app->magicCall($method);
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
       return $this->magicCall($method);
    }

    /**
     * @param $method
     * @return mixed
     * @throws NotFoundMethodException
     */
    public function magicCall( $method )
    {
        $method = strtolower( $method );
        if( ($server =  Tuzhi::$app->get($method) ) ){
            return $server;
        }else{
            throw new NotFoundMethodException( 'Not Found Services '.$method.' ' );
        }
    }

    /**
     * @abstract
     */
    abstract public function run();

}