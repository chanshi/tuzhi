<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/30
 * Time: 23:46
 */

namespace tuzhi\support\profiler;


use tuzhi\base\BObject;

/**
 * Class Timer
 * @package tuzhi\support\profiles
 */
class Timer extends BObject
{
    /**
     * @var array
     */
    protected static $timeMarker = [];

    
    /**
     * @param $tagName
     * @return $this
     */
    public static function mark( $tagName )
    {
        return self::$timeMarker[ strtolower($tagName)] = microtime(true);
    }

    /**
     * @param $tagName
     * @param int $decimals
     * @return int|string
     */
    public static function slice($tagName ,$decimals = 5)
    {
        $endTagName = strtolower($tagName).'.end';
        $startTagName = strtolower($tagName).'.start';

        if( isset(self::$timeMarker[$endTagName]) && isset(self::$timeMarker[$startTagName]) ){
            return number_format( self::$timeMarker[$endTagName] - self::$timeMarker[$startTagName] ,$decimals);
        }else{
            return 0;
        }
    }
}