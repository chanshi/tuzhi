<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:18
 */


use tuzhi\base\exception\NotFoundMethodException;

/**
 * Class Router
 */
class Router extends \tuzhi\support\facades\Facades
{
    /**
     * @var string
     */
    protected static $serviceName = 'router';

    /**
     * @var
     */
    private static $method;

    /**
     * Init
     */
    public static function init()
    {
        parent::init();
        if( static::$service ){
            static::$method = static::$service->getRouteAllowMethod();
        }
    }

    /**
     * @param $name
     * @param $arguments
     * @throws NotFoundMethodException
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        static::init();
        if( static::$service ){

            if( in_array( strtoupper($name), static::$method ) ){
                array_unshift($arguments ,$name);
                return call_user_func_array( [static::$service,'addRoute'] ,$arguments);
            }else{
                throw new NotFoundMethodException('Not Found Static Method '.$name.' in Router ');
            }
        }
        throw new NotFoundMethodException('Not Found Server Router In App !');
    }

}