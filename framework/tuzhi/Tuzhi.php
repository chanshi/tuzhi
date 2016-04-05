<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:27
 */


defined('TUZHI_PATH') or define('TUZHI_PATH',__DIR__);

/**
 *
 *
 * Class Tuzhi
 */
class Tuzhi {


    /**
     * @var
     */
    protected static $container;


    protected static $alias = 
        [
            '&tuzhi'=> __DIR__
        ];


    public static function setAlias( $aliasName ,$aliasValue ){

    }

    public static function getAlias( $aliasName ){
        $aliasName = '&'.ltrim($aliasName,'&');
        if(array_key_exists($aliasName,Tuzhi::$alias)){
            return Tuzhi::$alias[$aliasName];
        }
        return null;
    }

    public static function createObject( $name ,array $parameters = [] ){

    }

    public static function autoload( $className ){
        if($className){
            $className = ltrim($className,'\\');
            if( strpos($className,'\\') !==false ){
                $alias = array_shift(explode('\\',$className));
            }
            return false;
        }
        return false;
    }

    public static function config($object , $properties ){
        foreach( $properties as $name=>$value ){
            $object->$name = $value;
        }
        return $object;
    }


    public static function frameName(){
        return '土制框架';
    }

    public static function frameAuthor(){
        return "吾色禅师<wuse@chanshi.me>";
    }

}
