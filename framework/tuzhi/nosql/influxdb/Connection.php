<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:38
 */

namespace tuzhi\nosql\influxdb;

use tuzhi\base\BObject;
use tuzhi\nosql\influxdb\http\Request;

/**
 * Class Connection
 * @package tuzhi\nosql\influxdb
 */
class Connection extends BObject
{
    /**
     * @var
     */
    public $server;

    /**
     *
     */
    public function init()
    {
        parent::init();
        $this->server = new Server($this->server);
    }

    /**
     * @return mixed
     */
    public function ping()
    {
        $Request = new Request(['Server'=>$this->server]);
        return $Request->request();
    }

}