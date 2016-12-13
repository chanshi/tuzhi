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
class Router
{

    /**
     * @param $name
     * @param $arguments
     * @throws NotFoundMethodException
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {

        $service = Tuzhi::App()->get('router');
        if( $service ){
            $method = $service->getRouteAllowMethod();

            if( in_array( strtoupper($name), $method ) ){
                array_unshift($arguments ,$name);
                return call_user_func_array( [$service,'addRoute'] ,$arguments);
            }else{
                throw new NotFoundMethodException('Not Found Static Method '.$name.' in Router ');
            }
        }
        throw new NotFoundMethodException('Not Found Server Router In App !');
    }

}