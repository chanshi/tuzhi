<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/23
 * Time: 11:29
 */

/**
 * Class App
 */
class App extends \tuzhi\support\facades\Facades
{
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
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        if( method_exists(static::$app,$name) ){
            return call_user_func_array([static::$app,$name],$arguments);
        }

        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In App ,Method Name Is '.$name.'!');
    }

}