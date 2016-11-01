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
     * @var array
     */
    protected $instance =[];



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
     * @param $args
     * @return mixed
     */
    public function __call( $method ,$args )
    {
        return call_user_func_array([$this->getInstance(),$method],$args);
    }



}