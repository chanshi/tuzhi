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

class Application extends Object  implements IApplication
{

    public $charset;

    public $timezone;

    public $appPath;

    public $environment;

    protected static $instance;

    /**
     * @var 服务
     */
    protected static $serves = [];


    protected function __construct( $config = [] )
    {
        parent::__configure($config);

        $this->init();
    }

    protected function init()
    {
        // regist serve

        // boot
    }

    /**
     * 获取实例
     * @return mixed
     */
    public static function getInstance()
    {
        if( ! static::$instance instanceof IApplication ){
            static::$instance = new static();
        }
        return static::$instance;
    }


    /**
     * @param Serve $serve
     */
    public function register( Serve $serve ){
        static::$serves[$serve->getServeName()] =  $serve ;
    }

    public function run(){}


    /**
     * @param $serve
     * @param $arguments
     * @return $this
     */
    public static function __callStatic ($serve ,$arguments)
    {
        if( array_key_exists( $serve ,static::$serves ) ){
            return static::$serves[$serve];
        }
        return self;
    }

    /**
     * 注册核心
     */
    protected function registerCore(){
        $core =
            [
                'config' => 'tuzhi\base\Configure',
                'log'    => ''
            ];
        Arr::each($core,function($key,$value) use ($this){
            $this->register($value);
        });
    }

    protected function boots()
    {
        $boot =
            [
                'tuzhi\base\bootstrap\BaseSetBoot',
                'tuzhi\base\bootstrap\ProductEnvBoot'
            ];
        
    }
}