<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 10:29
 */

namespace tuzhi\base;


/**
 * APP 对应的服务
 *
 * Class Serve
 * @package tuzhi\base
 */
class Server extends BObject
{
    /**
     *
     */
    const STATUS_RUNNING = 1;

    /**
     *
     */
    const STATUS_STOP = 0;

    /**
     * @var
     */
    public $serveName;

    /**
     * @var
     */
    protected $status;

    

    /**
     * 启动
     */
    public function start()
    {
        $this->status = Server::STATUS_RUNNING;
    }

    /**
     * 停止
     */
    public function stop()
    {
        $this->status = Server::STATUS_STOP;
    }

    /**
     * @return mixed
     */
    public function getServeName()
    {
        return $this->serveName;
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        return $this->status == Server::STATUS_RUNNING ;
    }

}