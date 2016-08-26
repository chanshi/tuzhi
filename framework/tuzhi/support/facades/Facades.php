<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:16
 */

namespace  tuzhi\support\facades;


use tuzhi\base\exception\NotFoundMethodException;


/**
 * Class Facades
 * @package tuzhi\support\facades
 */
class Facades
{
    /**
     * @var
     */
    public static $app;

    /**
     * @var
     */
    protected static $serviceName;

    /**
     * @var
     */
    protected static $service;

    /**
     * @var bool
     */
    protected static $isInit = false;

    /**
     * Init
     */
    public static function init()
    {
        if( static::$isInit == false ){
            static::$app = \Tuzhi::$app;
            if( static::$serviceName  ){
                static::$service = static::$app->get(static::$serviceName);
            }
        }
        static::$isInit = true;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        static::init();
        if( static::$service ){
            if( method_exists( static::$service,$name ) ){
                return call_user_func_array([static::$service,$name ],$arguments);
            }
            throw new NotFoundMethodException('Not Found Method In '.static::$serviceName,' , Method Name Is '.$name.'!');
        }
        throw new NotFoundMethodException('Not Found Service In App , The Service Name is '.static::$serviceName);
    }
}