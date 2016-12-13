<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 15:40
 */


/**
 * Class Config
 */
class Config
{
    /**
     * @param $name
     * @return mixed
     */
    public static function get( $name )
    {
        return Tuzhi::config($name);
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public static function set( $name , $value  )
    {
        return Tuzhi::config($name ,$value);
    }
}