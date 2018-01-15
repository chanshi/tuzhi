<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:36
 */

namespace tuzhi\nosql\influxdb\http;

use tuzhi\helper\Http;

class Querying extends Request
{

    protected $method = 'GET';
    /**
     * @var string
     */
    protected $patten = '/query';


    /**
     * @return string
     */
    public function getPatten()
    {
        return parent::getPatten();
    }
}