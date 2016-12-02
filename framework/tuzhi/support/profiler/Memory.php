<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 00:16
 */

namespace tuzhi\support\profiler;

use tuzhi\base\Object;

/**
 * Class Memory
 * @package tuzhi\support\profiles
 */
class Memory extends Object
{
    protected static $memoryMarker;


    /**
     * @param $tagName
     * @return $this
     */
    public static function mark( $tagName )
    {
        return self::$memoryMarker[ strtolower($tagName)] = memory_get_usage();
    }

    /**
     * @param $tagName
     * @return float
     */
    public static function slice($tagName)
    {
        $endTagName = strtolower($tagName).'.end';
        $startTagName = strtolower($tagName).'.start';
        if( self::$memoryMarker[$endTagName] && self::$memoryMarker[$startTagName] ){
            $memory = (self::$memoryMarker[$endTagName] - self::$memoryMarker[$startTagName]) ;
            return self::byteConvert($memory);
        }else{
            return 0;
        }
    }

    /**
     * @param $bytes
     * @return string
     */
    protected static function byteConvert( $bytes )
    {
        $s = ['B', 'Kb', 'MB', 'GB', 'TB', 'PB'];
        $e = floor(log($bytes)/log(1024));

        return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
    }

}