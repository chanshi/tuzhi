<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:27
 */


defined('TUZHI_PATH') or define('TUZHI_PATH',__DIR__);

use tuzhi\di\Container;
use tuzhi\base\exception\NotFoundFilesException;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\support\profiler\Timer;
use tuzhi\support\profiler\Memory;


//todo::  &tz  这个逻辑需要独立出去

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
     * @var
     */
    protected static $configure;




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

    protected static $namespace =
        [
            'tuzhi'=> __DIR__
        ];

    /**
     * @param array $config
     * @throws InvalidParamException
     */
    public static function init( $config = [] )
    {
        /**
         * 添加对插件的支持
         */
        Tuzhi::$alias['&tz'] = dirname(__DIR__).'/tuzhi-';
        Tuzhi::$namespace['tz'] = Tuzhi::$alias['&tz'];

        /**
         *  定义 autoload
         */
        //spl_autoload_register([ 'Tuzhi' , 'autoload'],true,true);

        /**
         * 计算起点
         */
        Timer::mark('tuzhi.start');
        Memory::mark('tuzhi.start');

        /**
         *  获取容器
         */
        if( ! static::$container instanceof  Container){
            static::$container = Container::getInstance();
        }

        /**
         * 启用 Config
         */

        static::$configure = Tuzhi::make( $config );


        /**
         * 配置 别名
         */

        static::$alias  = array_merge(
            static::$alias ,
            ( Tuzhi::config( 'alias' )
                ? Tuzhi::config( 'alias' )
                : []
            )
        );

        /**
         *  配置 自动加载
         */
        static::$namespace  = array_merge(
            static::$namespace,
            ( Tuzhi::config( 'namespace' )
                ? Tuzhi::config( 'namespace' )
                : []
            )
        );


        /**
         * 启用 APP
         */

        if( Tuzhi::config('app')  ){
            Tuzhi::make( Tuzhi::config('app') );
        }

    }


    /**
     * 设置别名
     *
     * @param $aliasName
     * @param null $aliasValue
     */
    public static function setAlias( $aliasName ,$aliasValue = null )
    {
        if( is_string($aliasName) && is_dir( $aliasValue ) ){
            $aliasName = '&'.ltrim($aliasName,'&');
            $aliasValue = rtrim($aliasValue,'/').'/';
            Tuzhi::$alias[$aliasName] = $aliasValue;
        }
    }

    /**
     * 简单了
     *
     * @param $aliasName
     * @return mixed|null
     */
    public static function getAlias( $aliasName )
    {
        if( strpos($aliasName,'&') === 0 ){

            if( strpos($aliasName,'&tz/') === 0 ){
                return str_replace( '&tz/' ,static::$alias['&tz'] ,$aliasName );
            }else if( ($pos = strpos( $aliasName ,'/' ) ) > 0 ){
                $alias = substr($aliasName ,0 ,$pos);
                //todo
                return str_replace( $alias, static::$alias[$alias] ,$aliasName );
            }else{
                return isset( static::$alias[$aliasName] )
                    ? static::$alias[$aliasName]
                    : null;
            }
        }else{
            return $aliasName;
        }
    }

    /**
     * 简单处理
     * @param $aliasName
     * @param null $aliasPath
     * @return mixed|null
     */
    public static function alias( $aliasName ,$aliasPath = null )
    {
        if( $aliasPath == null ){
            return static::getAlias($aliasName);
        }else{
            return static::setAlias($aliasName,$aliasPath);
        }

    }

    /**
     * @param $namespace
     * @return mixed
     * @throws Exception
     */
    public static function getNamespace( $namespace )
    {
        if( isset( Tuzhi::$namespace[$namespace] ) ){
            return Tuzhi::$namespace[$namespace];
        }else{
            throw new \Exception('Not Found Namespace '.$namespace.'!');
        }
    }

    /**
     * @param $className
     * @return bool
     * @throws Exception
     * @throws NotFoundFilesException
     * @throws \tuzhi\base\exception\NotSupportException
     */
    public static function autoload( $className )
    {
        if( isset( static::$loadedClassFiles[$className] ) ) return true;

        if(  ( $pos = strpos($className,'\\') ) > 0){

            $class = str_replace('\\','/',$className);
            $namespace = substr($class,0,$pos);
            $path = Tuzhi::getNamespace($namespace);

            if( $namespace == 'tz' ){
                $classFile = rtrim($path,'/').substr($class, $pos+1 ).'.php';
            }else{
                $classFile = rtrim($path,'/').'/'.substr($class, $pos+1 ).'.php';
            }


            if(file_exists( $classFile )){
                try{

                    include $classFile;

                }catch(Exception $e){

                    throw new Exception( 'PHP ERROR in class File '.$classFile);
                }
                static::$loadedClassFiles[$className] = $classFile;
            }else{
                //TODO: 异常
                throw new NotFoundFilesException('Not Found File "'.$classFile.'" ');
            }
        }
        return true;
    }

    /**
     * @param $name
     * @param array $parameters
     * @param array $config
     * @return mixed
     * @throws InvalidParamException
     */
    public static function make( $name ,array $parameters = [] ,$config = [])
    {

        if( is_string($name) ){

            return Tuzhi::$container->get( $name ,$parameters ,$config);

        }else if( is_callable( $name ) ){

            return call_user_func_array($name ,$parameters);

        }else if( is_array( $name ) && isset( $name['class'] ) ){
            $class = $name['class'];
            unset($name['class']);
            return Tuzhi::$container->get( $class ,$parameters ,$name );

        }else {
            //TODO  抛出异常
            throw new InvalidParamException('Invalid Param '.$name.' in Tuzhi::make');
        }
    }


    /**
     * @param $key
     * @param $value
     */
    public static function config( $key , $value = NULL )
    {
        if( $value === NULL ){
            return static::$configure->get( $key );
        }else{
            return static::$configure->set( $key ,$value );
        }
    }

    /**
     * @return mixed
     */
    public static function App()
    {
        return static::$app;
    }

    /**
     * 框架名
     * @return string
     */
    public static function frameName()
    {
        return '土制框架';
    }

    /**
     * 框架作者
     * @return string
     */
    public static function frameAuthor()
    {
        return "吾色禅师<wuse@chanshi.me>";
    }

    /**
     * @return string 测试版
     */
    public static function frameVersion()
    {
        return '1.0101 - alpha';
    }

    public static function tu()
    {
        return static::$alias;
    }
}


