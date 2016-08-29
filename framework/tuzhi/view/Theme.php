<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 11:04
 */

namespace tuzhi\view;

use Tuzhi;
use tuzhi\base\Object;

/**
 * 模板
 * Class Theme
 * @package tuzhi\view
 */
class Theme extends Object
{

    /**
     * @var
     */
    public $webPath = '&web';

    /**
     * @var
     */
    public $webUrl = '/';

    /**
     * @var  风格目录
     */
    public $basePath = '&resource/';

    /**
     * @var string
     */
    public $defaultLayout = 'main';



    /**
     * 初始化
     */
    public function init()
    {
        $this->webPath  = Tuzhi::alias( $this->webPath );
        $this->basePath = Tuzhi::alias( $this->basePath );
    }

    /**
     * @return 风格目录
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return string 视图目录
     */
    public function getViewPath()
    {
        return $this->getBasePath().'view/';
    }

    /**
     * @return string 层目录
     */
    public function getLayoutPath()
    {
        return $this->getBasePath().'layout/';
    }

    /**
     * @param null $layout
     * @return string
     */
    public function getLayoutFile( $layout = null )
    {
        $layoutFile = $layout === null
            ? $this->defaultLayout
            : $layout;

        return $this->getLayoutPath().'/'. rtrim( ltrim($layoutFile ,'/') ,'.php' ).'.php';
    }

    /**
     * @return string
     */
    public function getAssetPath()
    {
        return $this->getBasePath().'asset/';
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }

    /**
     * @return string
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }
}