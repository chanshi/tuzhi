<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 10:44
 */


namespace app\console;


/**
 * Class TestCtl
 * @package app\console
 */
class TestCtl extends \tuzhi\console\control\TestCtl
{

    public function indexAct($request)
    {

        $key = \App::Redis()->getDb()->allKeys();
        print_r($key);
    }
}