<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/30
 * Time: 17:00
 */

namespace tuzhi\base;

/**
 * Class Event
 * @package tuzhi\base
 */
class Event extends Object
{
    /**
     * @var
     */
    protected static $events;

    /**
     * @param $class
     * @param $eventName
     * @param $eventClosure
     * @param null $data
     * @param bool $append
     * @return bool
     */
    public static function on( $class , $eventName, $eventClosure , $data = null, $append = true)
    {
        $class = ltrim($class,'\\');
        if($append || empty(self::$events[$eventName][$class])){
            self::$events[$eventName][$class][] =[$eventClosure,$data];
        }else{
            array_unshift(self::$events[$eventName][$class],[$eventClosure,$data]);
        }
        return true;
    }

    /**
     * @param $class
     * @param $eventName
     * @param null $eventClosure
     * @return bool
     */
    public static function off($class,$eventName,$eventClosure =null)
    {
        $class = ltrim($class,'\\');
        if(empty(self::$events[$eventName][$class])){
            return false;
        }
        if($eventClosure === null){
            unset( self::$events[$eventName][$class]);
            return true;
        }else{
            $removed = false;
            foreach (self::$events[$eventName][$class] as $index=>$event){
                if($event[0] === $eventClosure){
                    unset(self::$events[$eventName][$class][$index]);
                    $removed = true;
                }
            }
            if($removed){
                self::$events[$eventName][$class] = array_values(self::$events[$eventName][$class]);
            }
            return $removed;
        }
    }

    /**
     * @param $class
     * @param $eventName
     * @param $data
     * @return bool
     */
    public static function trigger($class,$eventName,$data = null)
    {
        if( empty(self::$events[$eventName]) ){
            return false;
        }

        if(is_object($class)){
            $class = get_class($class);
        }else{
            $class = ltrim($class,'\\');
        }

        $classAll = array_merge(
            [$class],
            class_parents($class,true),
            class_implements($class,true)
        );

        foreach ($classAll as $class){
            if(!empty(self::$events[$eventName][$class])){
                foreach (self::$events[$eventName][$class] as $handler){
                  //  call_user_func($handler[0],$handler[1],$data);
                    call_user_func_array($handler[0],[$data]);
                }
            }
        }
        return true;
    }
}