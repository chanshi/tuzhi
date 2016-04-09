<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:42
 */

namespace tuzhi\web;

class Request {


    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PURGE = 'PURGE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_TRACE = 'TRACE';
    const METHOD_CONNECT = 'CONNECT';


    protected $header;

    protected $cookie;

    protected $session;

    protected $post;

    protected $get;

    protected $raw;


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

    public function  getMethod()
    {
        if( isset($_POST[$this->viaParam]) ){
            return strtoupper(  $_POST[$this->viaParam]  );
        }else if( isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) ){
            return strtoupper( $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']  );
        }else {
            return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }
    }

    public function isCli(){
        return php_sapi_name() == 'cli';
    }
    
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function isJsonp()
    {
        return $this->isAjax() && ! empty($_SERVER['HTTP_X_PJAX']);
    }

    public function getClientIp()
    {

    }

    public function post( $field ,$default = null)
    {

    }

    public function get( $field , $default = null )
    {

    }

    public function cookie($key ,$value = null)
    {

    }

    public function session( $key , $value = null )
    {

    }

    /**
     * Returns the raw HTTP request body.
     * @return string the request body
     */
    public function getRawBody()
    {
        if ($this->raw === null) {
            $this->raw = file_get_contents('php://input');
        }

        return $this->raw;
    }

}