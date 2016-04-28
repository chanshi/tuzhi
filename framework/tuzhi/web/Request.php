<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:42
 */

namespace tuzhi\web;

use tuzhi\base\ErrorException;
use tuzhi\base\Server;
use tuzhi\contracts\web\IRequest;

class Request extends Server implements IRequest{


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

    protected $viaParam = '__method';

    

    /**
     * @return bool
     */
    public function isSecure()
    {
        return isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'],'on') === 0 || $_SERVER['HTTPS'] == 1 )
        || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'],'https') === 0;
    }

    public function getSchema()
    {
        return $this->isSecure() ? 'https://' : 'http://';
    }

    /**
     * 只有域名
     */
    public function getDomain()
    {
        if( isset( $_SERVER['HTTP_HOST'] )){
            return $_SERVER['HTTP_HOST'];
        }
        if( isset( $_SERVER['SERVER_NAME'] ) ){
            return $_SERVER['SERVER_NAME'] ;
        }
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return isset( $_SERVER['SERVER_PORT'] ) ? $_SERVER['SERVER_PORT'] : 80;
    }

    /**
     * www.xiaocao.com:239
     */
    public function getHost()
    {
        return $this->getDomain().( $this->getPort() != 80 ? ':'.$this->getPort() : ''  );
    }

    /**
     * 绝对地址
     * @return mixed
     */
    public function getAbsoluteHost()
    {
        return rtrim(  $this->getSchema().$this->getHost() ,'/' );
    }

    /**
     * @return string
     * @throws ErrorException
     */
    public function getAbsoluteUrl()
    {
        return $this->getUri();
    }

    /**
     * @return string
     * @throws ErrorException
     */
    public function getPath()
    {
        $pathInfo = $this->getUri();

        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        $pathInfo = urldecode($pathInfo);

        // try to encode in UTF8 if not so
        // http://w3.org/International/questions/qa-forms-utf-8.html
        if (!preg_match('%^(?:
            [\x09\x0A\x0D\x20-\x7E]              # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
            )*$%xs', $pathInfo)
        ) {
            $pathInfo = utf8_encode($pathInfo);
        }

        $scriptUrl = $this->getScriptUrl();
        $baseUrl = $this->getBaseUrl();
        if (strpos($pathInfo, $scriptUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($scriptUrl));
        } elseif ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($baseUrl));
        } elseif (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
            $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
        } else {
            throw new ErrorException();
        }

        if (substr($pathInfo, 0, 1) === '/') {
            $pathInfo = substr($pathInfo, 1);
        }

        return (string) $pathInfo;
    }

    /**
     * @return string
     * @throws ErrorException
     */
    public function getUri()
    {
        if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // IIS
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            if ($requestUri !== '' && $requestUri[0] !== '/') {
                $requestUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $requestUri);
            }
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        } else {
            throw ErrorException('');
        }

        return $requestUri;
    }


    public function all()
    {

    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return rtrim(dirname($this->getScriptUrl()), '\\/');
    }

    /**
     * @return string
     */
    public function getScriptUrl()
    {
        $scriptUrl = '';
        $scriptFile = isset( $_SERVER['SCRIPT_FILENAME'] ) ? $_SERVER['SCRIPT_FILENAME'] : '';
        $scriptName = basename($scriptFile);
        if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
            $scriptUrl = $_SERVER['SCRIPT_NAME'];
        } elseif (isset($_SERVER['PHP_SELF']) && basename($_SERVER['PHP_SELF']) === $scriptName) {
            $scriptUrl = $_SERVER['PHP_SELF'];
        } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
            $scriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
        } elseif (isset($_SERVER['PHP_SELF']) && ($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
            $scriptUrl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
        } elseif (!empty($_SERVER['DOCUMENT_ROOT']) && strpos($scriptFile, $_SERVER['DOCUMENT_ROOT']) === 0) {
            $scriptUrl = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $scriptFile));
        } else {
           //TODO:: 异常
        }
        return $scriptUrl;
    }


    /**
     * 获取请求方法
     *
     * @return string
     */
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

    /**
     * @return bool
     */
    public function isCli(){
        return php_sapi_name() == 'cli';
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @return bool
     */
    public function isPjson()
    {
        return $this->isAjax() && ! empty($_SERVER['HTTP_X_PJAX']);
    }

    /**
     *
     */
    public function getClientIp()
    {

    }

    /**
     * @param $field
     * @param null $default
     */
    public function post( $field ,$default = null)
    {

    }

    /**
     * @param $field
     * @param null $default
     */
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