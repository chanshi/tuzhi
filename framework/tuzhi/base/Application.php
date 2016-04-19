<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:43
 */

namespace tuzhi\base;


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
    public $server;

    /**
     * @var 服务定位
     */
    protected static $locator = null;


     /**
      * Application constructor.
      * @param array $config
      */
    protected function __construct( $config = [] )
    {
        parent::__configure($config);

        \Tuzhi::$app = $this;

        $this->init();
    }

    public function init()
    {
        static::$locator = \Tuzhi::make(
            'tuzhi\di\ServiceLocator',
            [$this->server]
        );

        /**
         * boot
         */
        Arr::each( $this->bootCore(),function($key ,$value) {
            \Tuzhi::$app->bootstrap($value);
        });
    }

    /**
     * @return mixed
     */
    public function session()
    {
        return static::$locator->get('session');
    }

    /**
     * @return mixed
     */
    public function request()
    {
        return static::$locator->get('request');
    }

    /**
     * @return mixed
     */
    public function errorHandler()
    {
        return static::$locator->get('errorHandler');
    }

    /**
     * @return mixed
     */
    public function router()
    {
        return static::$locator->get('router');
    }

    /**
     * @return mixed
     */
    public function response()
    {
        return static::$locator->get('response');
    }

    /**
     * @return mixed
     */
    public function log()
    {
        return static::$locator->get('log');
    }


    public function registerServer( $name , $params )
    {
        static::$locator->set( $name ,$params );
    }

    /**
     *
     */
     abstract public function run();

    /**
     * @return array
     */
    protected function bootCore()
    {
        return array_merge(
            [
                'tuzhi\base\bootstrap\ApplicationBoot'
            ],
            $this->bootstrap
        );
    }

    /**
     * @param $boot
     */
    public function bootstrap( $boot )
    {
        call_user_func([  \Tuzhi::make( $boot )  ,'boot'] ,$this);
    }
    

    /**
     * @return array
     */
    protected function serverCore()
    {
        return
            [
                'log'=>'',
                'session'=>'',
                'request'=>'',
                'response'=>'',
                'router'=>'',
                'errorHandler'=>''
            ];
    }

}