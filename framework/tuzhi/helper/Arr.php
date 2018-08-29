<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 12:04
 */

namespace tuzhi\helper;

use \Closure;

class Arr {

    /**
     * @param array $array
     * @param Closure $closure
     */
    public static function each( array $array ,Closure $closure )
    {
        //TODO  array_walk
        foreach( $array as $key=>$value){
            $result = call_user_func_array( $closure,[$key,$value] );
            if( $result === false ){
                break;
            }
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
     * @param $key
     * @return bool
     */
    public static function has( array $array,$key )
    {
        if(empty($key)){
            return false;
        }

        if( is_array($key) ){
            $result = true;
            foreach($key as $item){
                $result  = $result && static::has($array,$item);
            }
            return $result;
        }else{
            return isset( $array[$key] ) ? true : false;
        }
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

    /**
     * @var
     */
    const FILTER_INCLUDE = 1;

    /**
     * @var
     */
    const FILTER_DIFF = 2;

    const FILTER_NULL = 3;

    /**
     * @param $array
     * @param $keys
     * @param int $filterType
     * @return array
     */
    public static function filter( $array , $keys , $filterType = Arr::FILTER_INCLUDE )
    {
        $result = [];
        foreach( $array as $key => $value ){

            switch ($filterType){
                case Arr::FILTER_INCLUDE :
                    in_array($key,$keys)
                        ? ($result[$key] = $value)
                        : null;
                    break;
                case Arr::FILTER_DIFF :
                    ! in_array($key,$keys)
                        ? ($result[$key] = $value)
                        : null;
                    break;
                case Arr::FILTER_NULL :
                    $value == null || $value == ''
                        ?
                        : ($result[$key] = $value);
                    break;
            }
        }
        return $result;
    }

    /**
     * @param $source
     * @param $array
     * @return mixed
     */
    public static function marge( $source ,$array )
    {
        foreach( $array as $key=>$value ){
            $source[$key] = $value;
        }
        return $source;
    }

    /**
     * @param $source
     * @param $array
     * @return mixed
     */
    public static function append( $source ,$array )
    {
        foreach ($array as $key=>$value){
            array_push($source,$value);
        }
        return $source;
    }
}