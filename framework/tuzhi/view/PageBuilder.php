<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 16:26
 */

namespace tuzhi\view;


use tuzhi\helper\Html;
use tuzhi\view\widget\ContentWidget;
use tuzhi\view\widget\ReadyJsWidget;

class PageBuilder
{
    /**
     * 位置
     */
    const POS_HEAT  = 0;
    const POS_BEGIN = 1;
    const POS_END   = 2;
    const POS_READY = 3;
    //const POS_LOAD  = 4;

    /**
     * 占位
     */
    const HTML_HEAD = '<![CDATA[TZ-HEAD]]>';
    const HTML_BODY_BEGIN = '<![CDATA[TZ-BODY-BEGIN]]>';
    const HTML_BODY_END ='<![CDATA[TZ-BODY-END]]>';

    /**
     * @var
     */
    public $meteTag;

    /**
     * @var
     */
    public $css;
    public $cssFile;

    /**
     * @var
     */
    public $js;
    public $jsFile;

    /**
     * @var 网页标题
     */
    public $title;

    /**
     * @var array
     */
    protected $assets = [];

    /**
     * @var mixed|null
     */
    protected $assetManage = null;

    /**
     * @var
     */
    public $theme;

    /**
     * @var array
     */
    public $param;

    /**
     * PageBuilder constructor.
     * @param $theme
     */
    public function __construct( $theme ,$param = [])
    {
        $this->theme = $theme;
        $this->param = $param;

        $this->assetManage = \Tuzhi::make(
            'tuzhi\view\AssetManage',
            [$this]
        );
    }

    /**
     *  头部标记
     */
    public function headTag()
    {
        echo self::HTML_HEAD;
    }

    /**
     * 开始标记
     */
    public function bodyBeginTag()
    {
        echo self::HTML_BODY_BEGIN;
    }

    /**
     *  结束标志
     */
    public function bodyEndTag()
    {
        echo self::HTML_BODY_END;
    }

    /**
     * 渲染头部输出
     *
     * @return mixed
     */
    public function renderHeadHtml()
    {
        $headHtml = [];

        if( $this->meteTag ){
            //TODO:: mete 标签
        }

        if( isset($this->cssFile[ PageBuilder::POS_HEAT ] ) ) {
            foreach( $this->cssFile[ PageBuilder::POS_HEAT ] as $css ){
                $headHtml[] = Html::link( $css );
            }
        }

        if( isset( $this->jsFile[ PageBuilder::POS_HEAT ] ) ){
            foreach( $this->jsFile[ PageBuilder::POS_HEAT ] as $js ){
                $headHtml[] = Html::script($js);
            }
        }

        return implode("\n",$headHtml);
    }

    /**
     * 渲染开始输出
     *
     * @return mixed
     */
    public function renderBodyBeginHtml()
    {
        $bodyBeginHtml = [];

        if( isset( $this->css[ PageBuilder::POS_BEGIN ] ) ){
            $cssArr = array_values( $this->css[ PageBuilder::POS_BEGIN ] );
            $bodyBeginHtml[] = Html::style( implode("\n" ,$cssArr) );
        }

        if( isset( $this->jsFile[ PageBuilder::POS_BEGIN  ] ) ){
            foreach( $this->jsFile[ PageBuilder::POS_BEGIN  ] as $js ){
                $bodyBeginHtml[] = Html::script($js);
            }
        }

        if( isset( $this->js[ PageBuilder::POS_BEGIN  ]) ){
            $jsArr = array_values( $this->js[ PageBuilder::POS_BEGIN  ] );
            $bodyBeginHtml[] = Html::script(null,implode("\n",$jsArr ) );
        }


        return implode("\n",$bodyBeginHtml);
    }

    /**
     * 渲染结束输出
     *
     * @return mixed
     */
    public function renderBodyEndHtml()
    {
        $bodyEndHtml = [];

        if( isset( $this->css[ PageBuilder::POS_END ] ) ){
            $cssArr = array_values(  $this->css[ PageBuilder::POS_END ] );
            $bodyEndHtml[] = Html::style( implode("\n",$cssArr ) );
        }

        if( isset( $this->jsFile[ PageBuilder::POS_END ] ) ){
            foreach( $this->jsFile[ $this->jsFile[ PageBuilder::POS_END ] ] as $js ){
                $bodyEndHtml[] = Html::script($js);
            }
        }

        if( isset( $this->js[ PageBuilder::POS_END ] ) ){
            $jsArr = array_values( $this->js[ PageBuilder::POS_END ] );
            $bodyEndHtml[] = Html::script(null , implode("\n",$jsArr));
        }

        if( isset( $this->js[ PageBuilder::POS_READY ] ) ){
            $jsArr = array_values( $this->js[ PageBuilder::POS_READY ] );
            $bodyEndHtml[] = implode("\n",$jsArr);
            //$bodyEndHtml[] = Html::script(null , implode("\n",$jsArr));
        }

        return implode("\n",$bodyEndHtml);
    }

    /**
     * 页面开始
     */
    public function pageBegin()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * 页面结束
     * @return mixed
     */
    public function pageEnd()
    {
        $content = ob_get_clean();


        echo strtr($content,[
            PageBuilder::HTML_HEAD => $this->renderHeadHtml(),
            PageBuilder::HTML_BODY_BEGIN => $this->renderBodyBeginHtml(),
            PageBuilder::HTML_BODY_END => $this->renderBodyEndHtml()
        ]);
    }

    /**
     * @param null $layout
     */
    public function contentBegin( $layout = null )
    {
        ContentWidget::begin([
            'builder'=> $this,
            'layout' => $this->theme->getLayoutFile($layout)
        ]);
    }

    /**
     * 内容结束
     */
    public function contentEnd()
    {
       echo ContentWidget::end();
    }

    /**
     *
     */
    public function jsBegin()
    {
        ReadyJsWidget::begin(['view'=>$this]);
    }

    /**
     *
     */
    public function jsEnd()
    {
        ReadyJsWidget::end();
    }

    /**
     * @param $asset
     * @return mixed
     */
    public function registerAsset( $asset )
    {
        return $this->assetManage->registerAsset( $asset );
    }



    /**
     * 注册样式文件
     *
     * @param $file
     * @param int $pos
     */
    public function registerCssFile($file , $pos = PageBuilder::POS_HEAT)
    {
        if( ! isset( $this->cssFile[$pos] ) ){
            $this->cssFile[$pos] = [];
        }

        if( ! isset( $this->cssFile[$pos][$file] ) ){
            $this->cssFile[$pos][$file] = $file;
        }
    }

    /**
     * 注册样式
     *
     * @param $body
     * @param int $pos
     * @return $this
     */
    public function registerCss($body ,$pos = PageBuilder::POS_BEGIN )
    {
        if( ! isset( $this->css[$pos] ) ){
            $this->css[$pos] = [];
        }

        $this->css[$pos][] = $body;
        return $this;
    }

    /**
     * 注册脚本文件
     *
     * @param $file
     * @param int $pos
     * @return $this
     */
    public function registerJsFile( $file ,$pos = PageBuilder::POS_HEAT )
    {
        if( ! isset($this->jsFile[$pos] ) ){
            $this->jsFile[$pos] = [];
        }

        if( ! isset( $this->jsFile[$pos][$file] ) ){
            $this->jsFile[$pos][$file] = $file;
        }
        return $this;
    }

    /**
     * 注册脚本
     * @param $body
     * @param int $pos
     * @return $this
     */
    public function registerJs( $body ,$pos =  PageBuilder::POS_READY )
    {
        if( ! isset( $this->js[$pos] ) ){
            $this->js[$pos] = [];
        }

        $this->js[$pos][] = $body;

        return $this;
    }


}