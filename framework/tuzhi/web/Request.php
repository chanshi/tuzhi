<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:42
 */

namespace tuzhi\web;

class Request {

    protected $header;

    protected $cookie;

    protected $session;

    protected $params;

    public function __construct()
    {

    }

    public function getSchema()
    {

    }

    public function getHost()
    {

    }

    public function getDomain()
    {

    }

    public function getBaseUrl()
    {

    }

    public function getBasePath()
    {

    }

    public function getQueryPath(){

    }


    public function isCli(){
        return php_sapi_name() == 'cli';
    }
    
    public function isAjax()
    {

    }

    public function isJsonp()
    {

    }

    public function getClientIp()
    {

    }

}