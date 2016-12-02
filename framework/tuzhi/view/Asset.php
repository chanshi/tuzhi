<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 15:52
 */

namespace tuzhi\view;
use tuzhi\base\Object;

/**
 * Class Asset
 * @package tuzhi\view
 */
class Asset extends Object
{
    /**
     * @var
     */
    public $sourcePath;

    /**
     * @var bool 还否发布目录
     */
    public $publishPath = false;
    /**
     * @var
     */
    public $webPath;
    public $webUrl;

    /**
     * @var array
     */
    public $depends = [];

    /**
     * @var array
     */
    public $css = [];
    public $cssFile = [];

    /**
     * @var array
     */
    public $js = [];
    public $jsFile = [];

    

    public function init()
    {
        if( $this->sourcePath && strpos($this->sourcePath,'&') === 0 ){
            $this->sourcePath = \Tuzhi::alias( $this->sourcePath );
        }
        if( $this->webPath && strpos($this->webPath,'&') === 0 ){
            $this->webPath = \Tuzhi::alias($this->webPath);
        }
        // 发布目录？
        //TODO:: 有点绕了
        if($this->sourcePath && $this->publishPath) {

        }else if( $this->sourcePath ){
            // 发布文件
            $this->sourcePath = rtrim( $this->sourcePath,'/' ).'/';
            $cssFile = [];
            foreach( $this->cssFile as $css ){
                $cssFile[] = [ $css ,str_replace('/','-',$css) ];
            }
            $this->cssFile = $cssFile;

            $jsFile = [];
            foreach( $this->jsFile as $js ){
                $jsFile[] = [ $js ,str_replace('/','-',$js)];
            }
            $this->jsFile = $jsFile;
        }

    }

    /**
     * @param $View
     */
    public static function register( $View )
    {
        $View->registerAsset( get_called_class() );
    }

    /**
     * @param $manage
     */
    public function publish( $manage )
    {
        // 发布目录以及文件
        if( $this->sourcePath && $this->publishPath && $this->webPath && $this->webUrl ){
            $manage->publishDirection(
                $this->sourcePath ,
                rtrim($this->webPath,'/').'/'.ltrim($this->webUrl,'/')
            );
        }
        // 发布路径
        if( $this->sourcePath !== null && $this->publishPath == false && ! isset( $this->webPath ,$this->webUrl ) ){
            list( $this->webPath ,$this->webUrl ) = $manage->publishPath( $this->sourcePath );
        }

        $this->webPath = rtrim($this->webPath,'/').'/';

        foreach( $this->cssFile as  $file  ){
            if( is_array($file) ){
                $manage->publishFile( $this->sourcePath.$file[0] ,$this->webPath.$file[1] );
                $manage->registerCssFile( $this ,$file[1] );
            }else{
                $manage->registerCssFile( $this ,$file );
            }

        }

        foreach( $this->jsFile as $file ){
            if( is_array($file )){
                $manage->publishFile($this->sourcePath.$file[0] ,$this->webPath.$file[1]);
                $manage->registerJsFile($this ,$file[1]);
            }else{
                $manage->registerJsFile($this , $file);
            }
        }
    }

}