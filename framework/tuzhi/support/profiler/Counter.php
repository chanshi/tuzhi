<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 20:34
 */

namespace tuzhi\support\profiler;

/**
 * Class Counter
 * @package tuzhi\support\profiler
 */
class Counter
{

    /**
     * @var array
     */
    protected static $count=[];


    /**
     * @param $tag
     * @param int $step
     * @return int
     */
    public static function increment( $tag ,$step = 1)
    {
        if( !isset( static::$count[$tag] ) ){
            static::$count[$tag] = 0;
        }
        return static::$count[$tag] += $step;
    }

    /**
     * @param $tag
     * @return int
     */
    public static function last($tag)
    {
        return isset(static::$count[$tag])
            ? static::$count[$tag]
            : 0;
    }
}