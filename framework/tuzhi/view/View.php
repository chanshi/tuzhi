<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 10:58
 */

namespace tuzhi\view;

use Tuzhi;
use tuzhi\base\exception\NotFoundFilesException;
use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\Server;
use tuzhi\contracts\view\IView;
use tuzhi\web\Application;

/**
 *
 * Class View
 * @package tuzhi\view
 */
class View  extends Server implements IView
{

    /**
     * @var 引擎
     */
    protected $engine;

    /**
     * @var 风格
     */
    public $theme;


    /**
     *
     */
    public function init()
    {
        $this->engine = Tuzhi::make(
            'tuzhi\view\engine\PhpEngine'
        );
        $this->theme = Tuzhi::make($this->theme);
    }

    /**
     * @param $view
     * @param array $param
     * @return mixed
     * @throws NotFoundFilesException
     */
    public function render($view, $param = [])
    {
        //TODO:: 可以根据文件后缀 选择解析引擎
        $viewFile = rtrim( $this->theme->getViewPath().$view ,'.php').'.php';
        return $this->renderFile($viewFile, $param );
    }

    /**
     * @param $file
     * @param array $param
     * @return mixed
     * @throws NotFoundFilesException
     */
    public function renderFile( $file ,$param = [] )
    {
        if( file_exists( $file ) ){
            return $this->engine->render( $file ,$param );
        }else{
            throw new NotFoundFilesException( 'Not Found View Files '.$file.' ' );
        }
    }

    /**
     * @param $viewFile
     * @param array $param
     * @return mixed
     * @throws NotFoundFilesException
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function renderPage( $viewFile , $param = [] )
    {
        $param['view']= Tuzhi::make(
            'tuzhi\view\PageBuilder',
            [
                $this->theme,
                $param
            ]
        );
        return $this->render( $viewFile ,$param );
    }

}