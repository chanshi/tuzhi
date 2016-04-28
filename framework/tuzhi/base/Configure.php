<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 15:18
 */

namespace tuzhi\base;

/**
 * 配置文件  注意  @分类
 *
 * Class Configure
 * @package tuzhi\base
 */
class Configure extends Object{

    /**
     * @var string
     */
    protected static $config = [];

    /**
     * @var string
     */
    public $path = '&config/';

    /**
     * @var array
     */
    public $files = [];


    /**
     * @throws \Exception
     */
    public function init()
    {
        $this->path =  rtrim( \Tuzhi::getAlias($this->path),'/' ).'/';
        foreach( $this->files  as $file ){
            $this->loadFileConfig( $this->path . $file);
        }
    }


    /**
     * 默认直接加载 PHP 文件  也可以是JSON
     * 有需求再完善
     *
     * @param $file
     * @return bool
     * @throws \Exception
     */
    public function loadFileConfig( $file )
    {
        if( file_exists( $file ) ){
            try{
                $config = include $file;
            }catch(\Exception $e){
                throw $e;
            }
            static::$config = array_merge(static::$config ,$config);
            return true;
        }
        return false;
    }

    /**
     * @param $key
     * @return null|string
     */
    public  function get( $key )
    {
        $key = ltrim($key,'@');
        $config = & static::$config ;
        if( strpos($key,'.') !==false ){
            foreach(explode('.',$key) as $item ){
                if( ! isset($config[$item]) ){
                    return NULL;
                }
                $config = $config[$item];
            }
            return $config;
        }else{
            return isset($config[$key])
                ? $config[$key]
                : NULL;
        }
    }

    /**
     *
     * server.goods.abcd
     *
     * value 如果含有 @ 则 获取信息
     * @param $key
     * @param null $value
     * @return $this
     */
    public function set($key,$value = null)
    {
        if( strpos($key,'.') != false ){
            $config = & static::$config;
            foreach( explode('.',$key) as $item ){
                if( ! isset($config[$item]) ){
                    $config[$item] =[];
                }
                $config = $config[$item];
            }
            $config = $value;
        }else{
            static::$config[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasKey( $key )
    {
        return $this->get( $key ) === NULL
            ? false
            : true;
    }

    /**
     * @return string
     */
    public function all()
    {
        return static::$config;
    }

    /**
     * 从缓存中读取
     */
    public function load()
    {

    }

    /**
     * 把配置写入缓存
     */
    public function save()
    {

    }

}