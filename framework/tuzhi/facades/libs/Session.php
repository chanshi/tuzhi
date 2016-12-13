<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 17:23
 */

/**
 * Class Session
 */
class Session
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        $Server = Tuzhi::App()->get('session');
        if( method_exists( $Server,$name ) ){
            return call_user_func_array([$Server,$name],$arguments);
        }
        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In Session, method is '.$name.'!');
    }
}