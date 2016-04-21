<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 16:26
 */

namespace tuzhi\view;


class PageBuilder
{
    /**
     * 位置
     */
    const POS_HEAT  = 0;
    const POS_BEGIN = 1;
    const POS_END   = 2;
    const POS_READY = 3;
    const POS_LOAD  = 4;

    /**
     * 占位
     */
    const HTML_HEAD = '<![CDATA[TZ-HEAD]]>';
    const HTML_BODY_BEGIN = '<![CDATA[TZ-BODY-BEGIN]]>';
    const HTML_BODY_END ='<![CDATA[TZ-BODY-END]]>';

    public $meteTag;
    public $linkTag;

    public $css;
    public $cssFile;

    public $js;
    public $jsFile;

    /**
     * @var 网页标题
     */
    public $title;

    protected $assets = [];

    /**
     *
     */
    public function headTag()
    {
        echo self::HTML_HEAD;
    }

    public function bodyBeginTag()
    {
        echo self::HTML_BODY_BEGIN;
    }

    public function bodyEndTag()
    {
        echo self::HTML_BODY_END;
    }

    public function renderHeadHtml()
    {

    }

    public function renderBodyBeginHtml()
    {

    }

    public function renderBodyEndHtml()
    {

    }

    /**
     * 页面开始
     */
    public function beginPage()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * 页面结束
     * @return mixed
     */
    public function endPage()
    {
        ob_end_flush();
    }

    /**
     * 内容开始
     */
    public function beginContent()
    {

    }

    /**
     * 内容结束
     */
    public function endContent()
    {

    }


    public function registerAsset( $asset )
    {
        $this->assets[] = $asset;
    }

}