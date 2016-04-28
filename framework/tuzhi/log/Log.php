<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:15
 */

namespace tuzhi\log;

use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\Server;

/**
 * Class Log
 *
 * Log::Notice()
 *
 * Log::error()
 *
 * Log::Debug()
 *
 *
 * @package tuzhi\log
 */
class Log extends Server
{
    /**
     * 类型
     */
    const LOG_NOTICE  = 1;

    const LOG_WARNING = 2;

    const LOG_ERROR   = 4;

    const LOG_DEBUG   = 8;

    const LOG_PROFILE = 16;

    const LOG_ALL     = 31;

    /**
     * @var array 类型别名
     */
    public static $Type=
        [
            1 => 'notice',
            2 => 'warning',
            4 => 'error' ,
            8 => 'debug',
            16 => 'profile'
        ];

    /**
     * @var int
     */
    public $allow = 31;

    /**
     * @var
     */
    public static $instance;

    /**
     * @var array
     */
    protected static $logs = [];

    /**
     * @var null
     */
    public $storage = null;


    /**
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function init()
    {
        static::$instance = $this;
        $this->storage = \Tuzhi::make($this->storage);
    }


    /**
     * @param $message
     * @param $type
     */
    public function record( $message  , $type )
    {
        if( $type & $this->allow )
        {
            $content = $this->normalizeMessage( $message );
            static::$logs[ $type ] = $content;
        }
    }

    /**
     * @param $message
     * @return string
     */
    protected function normalizeMessage( $message )
    {
        return "[".date('H:i:s')."] [{$message}]";
    }

    /**
     * @param $name
     * @param $arguments
     * @throws NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        if( static::$instance == null ){
            \Tuzhi::App()->log();
        }
        $method = strtolower($name);
        $type = array_flip(static::$Type);
        if( isset($type[$method]) ){
            //print_r($arguments);exit;
            $arguments[1] = $type[$method];
            return call_user_func_array([static::$instance ,'record'] ,$arguments);
        }
        throw new NotFoundMethodException( 'Not Found Method In Log ,Method is '.$name );
    }

    /**
     * @return bool
     */
    public function save()
    {
        foreach (static::$logs as $type =>$value){
            $this->storage->record( $value , static::$Type[$type] );
        }
        return true;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->save();
        $this->stop();
    }
}