<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 16:52
 */

namespace tuzhi\view;

use tuzhi\base\exception\InvalidParamException;
use tuzhi\helper\File;


//TODO:: 需要重构规则

/**
 * Class AssetManage
 * @package tuzhi\view
 */
class AssetManage
{
    /**
     * @var
     */
    protected $asset;


    /**
     * @var
     */
    protected $pageBuilder;

    protected $theme;


    protected $fileMode = 0777;


    /**
     * AssetManage constructor.
     * @param $pageBuilder
     */
    public function __construct( $pageBuilder )
    {
        $this->pageBuilder = $pageBuilder;
        $this->theme  = $this->pageBuilder->theme;
    }


    /**
     * @param $asset
     * @throws InvalidParamException
     */
    public function registerAsset( $asset )
    {
        if( is_string($asset) ){
            if( ! isset( $this->asset[$asset] )  ){
                $this->asset[$asset] = \Tuzhi::make( $asset );
                $this->registerDepend($this->asset[$asset]);
                $this->asset[$asset]->publish($this);
            }
        }else if( $asset instanceof Asset) {
            //TODO::
        }else{
            throw new InvalidParamException( 'Invalid Param Asset '.$asset.' ');
        }

    }

    /**
     * 注册依赖
     * @param $Asset
     * @return bool
     */
    public function registerDepend( $Asset )
    {
        foreach( $Asset->depends as $asset ){
            $this->registerAsset($asset);
        }
        return true;
    }

    /**
     * @param $path
     * @return array
     * @throws InvalidParamException
     */
    public function publishPath( $path )
    {
        $dir = $this->hash($path);
        $path = $this->theme->getWebPath();
        $path = rtrim( $path ,'/' ).'/'.$dir;

        if( ! is_dir( $path ) ){
            File::createDir( $path ,$this->fileMode);
        }

        return [ $path , $this->theme->getWebUrl().$dir ];
    }

    /**
     * @param $sourceFile
     * @param $targetFile
     * @throws InvalidParamException
     */
    public function publishFile( $sourceFile ,$targetFile )
    {
        if(  file_exists($sourceFile)   ){
            if( ! file_exists( $targetFile )  || ( @filemtime( $sourceFile ) > @filemtime($targetFile) ) ){
                copy( $sourceFile ,$targetFile );
            }
        }else {
            throw new InvalidParamException( 'File Not Found '.$sourceFile.' Or '.$targetFile );
        }
    }

    /**
     * @param $asset
     * @param $cssFile
     * @throws InvalidParamException
     */
    public function registerCssFile( $asset ,$cssFile)
    {
        $asset->webUrl = $asset->webUrl ? $asset->webUrl : $this->theme->getWebUrl();

        $asset->webUrl = rtrim($asset->webUrl,'/').'/';

        $this->pageBuilder->registerCssFile( $asset->webUrl . $cssFile);
    }

    /**
     * @param $asset
     * @param $jsFile
     * @throws InvalidParamException
     */
    public function registerJsFile( $asset ,$jsFile )
    {

        $asset->webUrl = $asset->webUrl ? $asset->webUrl : $this->theme->getWebUrl();

        $asset->webUrl = rtrim($asset->webUrl,'/').'/';

        $this->pageBuilder->registerJsFile( $asset->webUrl . $jsFile);
    }

    /**
     * @param $path
     * @return mixed
     */
    protected function hash( $path )
    {
        return substr( sha1($path) ,0 , 15 );
    }

}