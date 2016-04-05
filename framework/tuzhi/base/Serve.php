<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 10:29
 */

namespace tuzhi\base;

class Serve
{
    public $name;

    public $isRegister= false;


    /**
     * 注册入 app
     */
    public function registered()
    {
        $this->isRegister = true;
    }

    /**
     * 启动
     */
    public function start()
    {

    }

    public function restart()
    {}

    public function stop()
    {}

}