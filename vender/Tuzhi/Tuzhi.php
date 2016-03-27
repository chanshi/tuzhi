<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:27
 */


defined('TUZHI_PATH') or define('TUZHI_PATH',__DIR__);


class Tuzhi {


    /**
     * @var
     */
    protected static $container;


    public static function createObject( $name ,array $parameters = [] ){

    }

    public static function autoload( $className ){

    }

    public static function config($object , $properties ){
        foreach( $properties as $name=>$value ){
            $object->$name = $value;
        }
        return $object;
    }

}
