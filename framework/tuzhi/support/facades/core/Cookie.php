<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 15:34
 */



/**
 * Class Cookie
 */
class Cookie
{
    /**
     * @var array
     */
    protected static $config = [];

    /**
     * @return array
     */
    protected static function getConfig()
    {
        if( empty(  static::$config )  ){
            $config = Config::get('cookie');
            static::$config = $config ? $config : [];
        }
        return static::$config;
    }
    /**
     * @param $name
     * @return mixed
     */
    public static function get( $name )
    {
        return Request::cookie()->get($name);
    }

    /**
     * @param array $config
     * @return \tuzhi\web\cookie\Cookie
     */
    public static function getInstance( $config = [] )
    {
        return new \tuzhi\web\cookie\Cookie($config);
    }

    /**
     * @param $name
     * @param $value
     * @param array $config
     */
    public static function set( $name ,$value ,$config = [])
    {
        //TODO:: 不处理业务逻辑
        $config = array_merge(static::getConfig(),$config);
        $cookie = static::getInstance( $config );
        $cookie->name = $name;
        $cookie->value = $value;
        Response::cookie()->set($name , $cookie );
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function rm( $name )
    {
        $cookie = static::getInstance( static::getConfig() );
        $cookie->name = $name;
        return Response::cookie()->rm($cookie);
    }

}