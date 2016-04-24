<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:38
 */

namespace app\control;


use tuzhi\route\Controller;


use tuzhi\web\Application;

/**
 * Class Test
 * @package app\control
 */
class Test extends Controller
{

    /**
     * 测试视图
     * @return mixed|void
     */
    public function  ViewAction()
    {

        return \Tuzhi::$app->view()->renderPage('index/index');
    }
}