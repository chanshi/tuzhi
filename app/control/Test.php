<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:38
 */

namespace app\control;


use tuzhi\route\Controller;
use tuzhi\log\Log;
use tuzhi\cache\Cache;

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

        //Log::Notice('test');


        //Cache::File()->set('test',1);

        $db =\Tuzhi::App()->db();

        $result = $db->createCommand('select * from user')->queryAll();

        return json_encode($result);

        //return  Cache::File()->increment('test');

        //return \Tuzhi::$app->view()->renderPage('index/index');
    }

    public function infoAction()
    {
        return phpinfo();
    }
}