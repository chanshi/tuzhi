<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 17:29
 */

class Module extends \tuzhi\support\facades\Facades
{
    protected static $serviceName = 'module';

    /**
     * @var
     */
    protected static $service;

    /**
     * @var bool
     */
    protected static $isInit = false;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        static::init();
        $Module = call_user_func([static::$service,'getModule'],$name);

        return isset($arguments[0])
            ? $Module[$arguments[0]]
            : $Module ;
    }
}