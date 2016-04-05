<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:27
 */


defined('TUZHI_PATH') or define('TUZHI_PATH',__DIR__);

/**
 * Class Tuzhi
 */
class Tuzhi {

    /**
     * @var
     */
    public static $app;

    /**
     * @var
     */
    protected static $container;

    /**
     * @var array
     */
    protected static $loadedClassFiles = [];

    /**
     * @var array
     */
    protected static $alias = 
        [
            '&tuzhi'=> __DIR__
        ];


    /**
     * 设置别名
     *
     * @param $aliasName
     * @param null $aliasValue
     */
    public static function setAlias( $aliasName ,$aliasValue = null  ){
        if( $aliasValue === null && file_exists($aliasName)){
            $alias  = require $aliasName;
            static::$alias = array_merge( static::$alias ,$alias['alias'] );
        }else if( is_string($aliasName) && ! empty( $aliasValue ) ){
            $field = '&'.ltrim($aliasName,'&');
            static::$alias[$field] = $aliasValue;
        }
    }

    /**
     * 获取
     * @param $aliasName
     * @return mixed|null
     */
    public static function getAlias( $aliasName ){
        $alias = '&'.ltrim($aliasName,'&');
        return isset( static::$alias[$alias] ) ? static::$alias[$alias] : null;
    }

    /**
     * @param $name
     * @param array $parameters
     */
    public static function createObject( $name ,array $parameters = [] ){
        if( ! static::$container instanceof  tuzhi\di\Container){
            static::$container = tuzhi\di\Container::getInstance();
        }
        if( is_string($name) ){

        }else if(is_callable( $name )){
            return call_user_func_array($name ,$parameters);
        }
    }

    /**
     * @param $className
     * @return bool
     */
    public static function autoload( $className ){
        //echo $className;
        if( isset( static::$loadedClassFiles[$className] ) ) return true;
        if(  ( $pos = strpos($className,'\\') ) > 0){
            $classFile = Tuzhi::getAlias('&'.substr($className,0,$pos)).'/'. substr( str_replace('\\','/',$className),$pos+1).'.php';

            if(file_exists( $classFile )){
                include $classFile;
                static::$loadedClassFiles[$className] = $classFile;
            }else{
                //TODO: 异常
            }
        }
        return true;
    }

    /**
     * 对象配置
     *
     * @param $object
     * @param $properties
     * @return mixed
     */
    public static function config( $object , $properties ){
        foreach( $properties as $name=>$value ){
            $object->$name = $value;
        }
        return $object;
    }

    /**
     * 框架名
     * @return string
     */
    public static function frameName(){
        return '土制框架';
    }

    /**
     * 框架作者
     * @return string
     */
    public static function frameAuthor(){
        return "吾色禅师<wuse@chanshi.me>";
    }
}

/**
 *  定义 autoload
 */
spl_autoload_register([ 'Tuzhi' , 'autoload'],true,true);
