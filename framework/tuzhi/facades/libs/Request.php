<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/23
 * Time: 17:32
 */


class Request
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        $Server = Tuzhi::App()->get('request');
        if( method_exists( $Server,$name ) ){
            return call_user_func_array([$Server,$name],$arguments);
        }
        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In Request, method is '.$name.'!');
    }
}