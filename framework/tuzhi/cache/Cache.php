<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 11:43
 */

namespace tuzhi\cache;


use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\exception\NotSupportException;
use tuzhi\base\Object;
use tuzhi\contracts\cache\ICache;

/**
 * Class Cache
 * @package tuzhi\cache
 *
 *
 *
 * Cache::set()
 *
 * Cache::get()
 *
 * Cache::delete()
 *
 * Cache::flush()
 *
 * Cache::decrement()
 *
 * Cache::increment()
 *
 * Cache::Memcached()->set();
 *
 * Cache::Redis()->set();
 *
 * Cache::File()->set();
 *
 */

class Cache extends Object
{

    /**
     * @var
     */
    public $default = 'memcached';

    /**
     * @var array
     */
    public $support = [];

    /**
     * @var array
     */
    public static $map =
        [
            'file' => 'tuzhi\cache\support\File',
            'memcached' => 'tuzhi\cache\support\Memcached'
        ];

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
     * @var array
     */
    protected $instance =[];

    /**
     * @var
     */
    public static $cache;


    /**
     * 启动
     */
    public function init()
    {
        Cache::$cache = $this;
    }

    public static function initCache()
    {
        $config = \Tuzhi::config('cache');
        if( $config ){
            return  \Tuzhi::make( $config );
        }
        throw new NotSupportException('Not Found Cache Configure ');
    }

    /**
     * @param $support
     * @return mixed
     * @throws NotSupportException
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function createInstance( $support )
    {
        if( ! isset( $this->support[$support] )  ){
            throw new NotSupportException( 'Not Support This Method '.$support );
        }
        return \Tuzhi::make(
            Cache::$map[$support],
            [ $this->support[$support] ]
        );
    }

    /**
     * @param null $method
     * @return mixed
     * @throws NotSupportException
     */
    public function getInstance( $method = null )
    {
        $method = $method == null ? $this->default : $method;
        $method = strtolower($method);
        if( ! isset($this->instance[$method]) ){
            $this->instance[$method] = $this->createInstance($method);
        }
        return $this->instance[$method];
    }


    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public static function __callStatic($method, $arguments)
    {
        if( Cache::$cache == null )
        {
            Cache::initCache();
        }
        //首先使用
        $method = strtolower($method);
        if( Cache::$cache->support[$method] ){
            return Cache::$cache->getInstance($method);
        }
        //然后在
        $defaultCache = Cache::$cache->getInstance();

        if( $defaultCache instanceof ICache && in_array($method ,Cache::$InterfaceMethod)){
            return call_user_func_array( [ $defaultCache , $method ] ,$arguments );
        }


        throw new NotFoundMethodException('Not Found Method '.$method.' In Cache ');
    }
}