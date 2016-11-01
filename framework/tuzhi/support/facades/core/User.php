<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/7
 * Time: 13:54
 */

class User extends \tuzhi\support\facades\Facades
{
    protected static $serviceName = 'user';

    /**
     * @var
     */
    protected static $service;

    /**
     * @var bool
     */
    protected static $isInit = false;


    /**
     * @return mixed
     */
    public static function getModel()
    {
        //TODO:: 这个问题 。。

        static::init();
        return static::$service->getModel();
    }

    public static function __callStatic($name, $arguments)
    {
        static::init();
        return call_user_func([static::$service->getModel(),$name],$arguments);
    }
}