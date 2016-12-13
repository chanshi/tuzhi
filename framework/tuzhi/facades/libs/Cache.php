<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:17
 */

use tuzhi\contracts\cache\ICache;
use tuzhi\base\exception\NotFoundMethodException;

/**
 * Class Cache
 */
class Cache
{

    /**
     * @var array 支持的方法
     */
    protected static $InterfaceMethod =
        [
            'set',
            'get',
            'delete',
            'flush',
            'decrement',
            'increment'
        ];

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($method, $arguments)
    {

        $Cache = Tuzhi::App()->get('cache');
        if( $Cache ){
            $method = strtolower($method);
            if( isset($Cache->support[$method]) ){
                return $Cache->getInstance($method);
            }

            $defaultCache = $Cache->getInstance();

            if( $defaultCache instanceof ICache && in_array($method ,Cache::$InterfaceMethod)){
                return call_user_func_array( [ $defaultCache , $method ] ,$arguments );
            }

            throw new NotFoundMethodException('Not Found Method '.$method.' In Cache ');
        }

        throw new NotFoundMethodException('Not Found Cache In App');
    }

}