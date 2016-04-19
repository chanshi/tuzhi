<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 12:04
 */

namespace tuzhi\helper;

use Closure;

class Arr {

    public static function each( array $array ,Closure $closure )
    {
        //TODO  array_walk
        foreach( $array as $key=>$value){
            call_user_func_array( $closure,[$key,$value] );
        }
    }

    /**
     * 取数组头部
     *
     * @param array $array
     * @return mixed
     */
    public static function head( array $array )
    {
        $a = $array;
        return current(reset($a));
    }

    /**
     * 取数组尾部
     *
     * @param array $array
     * @return mixed
     */
    public static function last( array $array)
    {
        return end($array);
    }

    /**
     * @param array $array
     * @return mixed
     */
    public static function length( array $array )
    {
        return count($array);
    }

    /**
     * @param array $array
     * @return bool
     */
    public static function isAssoc( array $array)
    {
        $key = array_keys( $array );

        return array_keys($key) != $key;
    }
}