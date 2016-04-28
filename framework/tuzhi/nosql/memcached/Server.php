<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 10:28
 */

namespace tuzhi\nosql\memcached;

use tuzhi\base\Object;

class Server extends Object
{
    /**
     * @var string
     */
    public $host = '127.0.0.1';

    /**
     * @var string
     */
    public $port = '11211';

    /**
     * @var
     */
    public $weight;

    /**
     * @var
     */
    protected $hashId;


    /**
     * 初始化
     */
    public function init()
    {
        $this->hashId = md5( $this->host .$this->port );
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $array = [];
        array_push($array,$this->host);
        array_push($array,$this->port);
        if(  $this->weight ){
            array_push($array,$this->weight);
        }
        return $array;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->hashId;
    }

}