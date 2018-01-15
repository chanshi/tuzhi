<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:23
 */

namespace tuzhi\nosql\influxdb\http;

use tuzhi\base\Object;
use tuzhi\helper\Http;

/**
 * Class Http
 * @package tuzhi\nosql\influxdb
 */
class Request extends Object
{
    /**
     * @var string
     */
    protected $method ='GET';

    /**
     * @var string
     */
    protected $patten = '/ping';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var
     */
    protected $Server;

    /**
     * @return string
     */
    protected function getPatten()
    {
        return $this->Server->uri.'/'.ltrim($this->patten,'/');
    }

    /**
     * @return mixed
     */
    public function request()
    {
        $response = $this->method == 'GET'
            ? Http::curlGet($this->getPatten())
            : Http::curlPost($this->getPatten(),$this->data);
        return $response;
    }

}