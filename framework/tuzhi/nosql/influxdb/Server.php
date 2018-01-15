<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:43
 */

namespace tuzhi\nosql\influxdb;

use tuzhi\base\Object;

class Server extends Object
{

    /**
     * @var
     */
    public $uri = 'http://localhost:8086';

    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $database;

    /**
     * @return array
     */
    public function toQuery()
    {

        $param[] = $this->database ? ['db'=>$this->database] : [];
        $param[] = $this->username ? ['u'=>$this->username] : [];
        $param[] = $this->password ? ['p'=>$this->password] : [];
        return $param;
    }
}