<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/12
 * Time: 16:36
 */

class Application
{
    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments=[])
    {
        if(method_exists(Tuzhi::$app,$name)){
            return call_user_func_array([Tuzhi::$app,$name],$arguments);
        }
        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In Application, method is '.$name.'!');
    }
}