<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/19
 * Time: 14:43
 */

/**
 * Class Img
 */
class Img
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static  function __callStatic($name, $arguments)
    {
        $Server = Tuzhi::App()->get('images');
        if( method_exists( $Server,$name ) ){
            return call_user_func_array([$Server,$name],$arguments);
        }
        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In Images, method is '.$name.'!');
    }
}