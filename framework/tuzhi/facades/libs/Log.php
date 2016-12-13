<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/24
 * Time: 10:01
 */

use tuzhi\base\exception\NotFoundMethodException;

/**
 *
 * Log::T_NOTICE
 * Class Log
 */
class Log
{

    /**
     * 类型
     */
    const LOG_NOTICE  = \tuzhi\log\Log::LOG_NOTICE;

    const LOG_WARNING = \tuzhi\log\Log::LOG_WARNING;

    const LOG_ERROR   = \tuzhi\log\Log::LOG_ERROR;

    const LOG_DEBUG   = \tuzhi\log\Log::LOG_DEBUG;

    const LOG_PROFILE = \tuzhi\log\Log::LOG_PROFILE;

    const LOG_ALL     = \tuzhi\log\Log::LOG_ALL;


    /**
     * @var
     */
    private static $allowType;

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        if( ! static::$allowType ){
            static::$allowType = array_flip( \tuzhi\log\Log::$Type );
        }
        $service = Tuzhi::App()->get('log');
        if( $service ){
            $method = strtolower($name);
            if ( isset(static::$allowType[$method]) ){
                $arguments[1] = static::$allowType[$method];
                return call_user_func_array([$service,'record'],$arguments);
            }
        }
        throw new NotFoundMethodException('Not Found Log In App !');
    }
}