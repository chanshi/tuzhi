<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/21
 * Time: 18:01
 */

namespace tuzhi\view\widget;

use tuzhi\view\Widget;

class ContentWidget extends Widget
{

    /**
     * @var 参数
     */
    public $builder;

    /**
     * @var 层
     */
    public $layout;


    /**
     *
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $content = ob_get_clean();
        $param = $this->builder->param;
        $param['view'] = $this->builder;
        $param['content'] = $content;

        //渲染输出
        return \Tuzhi::$app->get('view')->renderFile( $this->layout , $param );

    }
}