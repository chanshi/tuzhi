<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:42
 */

namespace tuzhi\web;

use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Server;
use tuzhi\contracts\web\IRequest;
use tuzhi\support\files\FilesCollect;
use tuzhi\web\cookie\CookieCollect;
use tuzhi\web\cookie\Cookie;

/**
 * Class Request
 * @package tuzhi\web
 */
class Request extends Server implements IRequest
{

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

    protected $httpSecure;

    protected $httpDomain;

    protected $httpPort;

    protected $httpUri;

    protected $httpPath;

    protected $httpQueryString;

    protected $httpScript;

    protected $httpHost;

    protected $httpMethod;


    protected $header;

    protected $cookie;

    protected $session;

    protected $post;

    protected $get;

    /**
     * @var
     */
    protected $raw;

    /**
     * @var string
     */
    protected $viaParam = '__method';

    /**
     * @var string
     */
    protected $fileCollection = null;



    /**
     * @return bool
     */
    public function isSecure()
    {
        if($this->httpSecure == null ){
            $this->httpSecure = isset($_SERVER['HTTPS']) && (strcasecmp($_SERVER['HTTPS'],'on') === 0 || $_SERVER['HTTPS'] == 1 )
                || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'],'https') === 0;
        }
        return $this->httpSecure;
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->isSecure() ? 'https://' : 'http://';
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        if( $this->httpDomain == null ){
            if( isset($_SERVER['HTTP_HOST']) ){
                $this->httpDomain = $_SERVER['HTTP_HOST'];
            }else if( isset($_SERVER['SERVER_NAME']) ){
                $this->httpDomain = $_SERVER['SERVER_NAME'];
            }
        }
        return $this->httpDomain;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        if($this->httpPort == null){
            $this->httpPort = isset( $_SERVER['SERVER_PORT'] ) ? $_SERVER['SERVER_PORT'] : 80;
        }
        return $this->httpPort;
    }

    /**
     * www.xiaocao.com:239
     */
    public function getHost()
    {
        if( $this->httpHost == null ){
            $this->httpHost = $this->getDomain(); //.( $this->getPort() != 80 ? ':'.$this->getPort() : ''  );
        }
        return $this->httpHost;
    }

    /**
     *
     * @return mixed
     */
    public function getAbsoluteHost()
    {
        return rtrim(  $this->getSchema().$this->getHost() ,'/' );
    }


    /**
     * @return string
     * @throws InvalidParamException
     */
    public function getPath()
    {
        if( $this->httpPath == null ){
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
                throw new InvalidParamException('Cant Parse Uri Path');
            }

            if (substr($pathInfo, 0, 1) === '/') {
                $pathInfo = substr($pathInfo, 1);
            }
            $this->httpPath = $pathInfo;
        }

        return  $this->httpPath;
    }

    /**
     * @return mixed|string
     * @throws InvalidParamException
     */
    public function getUri()
    {
        if( $this->httpUri == null ){
            if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // IIS
                $this->httpUri = $_SERVER['HTTP_X_REWRITE_URL'];
            } elseif (isset($_SERVER['REQUEST_URI'])) {
                $this->httpUri = $_SERVER['REQUEST_URI'];
                if ($this->httpUri !== '' && $this->httpUri[0] !== '/') {
                    $this->httpUri = preg_replace('/^(http|https):\/\/[^\/]+/i', '', $this->httpUri);
                }
            } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0 CGI
                $this->httpUri = $_SERVER['ORIG_PATH_INFO'];
                if (!empty($_SERVER['QUERY_STRING'])) {
                    $this->httpUri .= '?' . $_SERVER['QUERY_STRING'];
                }
            } else {
                throw new InvalidParamException('Cant Found URI');
            }
        }
        return $this->httpUri;
    }

    /**
     * @return mixed|string
     */
    public function getAbsoluteUrl()
    {
        return $this->getAbsoluteHost().$this->getUri();
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        if($this->httpQueryString == null) {
            $this->httpQueryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        }
        return $this->httpQueryString;
    }


    /**
     * @return string
     */
    public function getScriptUrl()
    {
        if($this->httpScript == null){
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
            }
            $this->httpScript = $scriptUrl;
        }
        return $this->httpScript;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return rtrim(dirname($this->getScriptUrl()), '\\/');
    }


    /**
     *
     * @return string
     */
    public function  getMethod()
    {
        if( $this->httpMethod == null ){
            if( isset($_POST[$this->viaParam]) ){
                $this->httpMethod = strtoupper(  $_POST[$this->viaParam]  );
            }else if( isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) ){
                $this->httpMethod = strtoupper( $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']  );
            }else {
                $this->httpMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
            }
        }
        return $this->httpMethod;
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
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' );
    }

    /**
     * @return bool
     */
    public function isPjax()
    {
        return $this->isAjax() && ! empty($_SERVER['HTTP_X_PJAX']);
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
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

    /**
     * @param $field
     * @param string $type
     * @param null $default
     * @return mixed
     */
    public  function post($field , $type = 'string',$default = null )
    {
        $result = $default;
        if(array_key_exists( $field ,$_POST )){
            $result = $_POST[$field] ;
        }
        return  $this->forceField( $type ,$result);
    }

    /**
     * @param $field
     * @param string $type
     * @param null $default
     * @return mixed
     */
    public function get($field ,$type = 'string',$default = null )
    {
        $result = $default;
        if(array_key_exists( $field ,$_GET )){
            $result =  $_GET[$field] ;
        }
        return  $this->forceField( $type ,$result);
    }

    /**
     * @param $type
     * @param $value
     * @return mixed
     */
    protected  function forceField( $type,$value )
    {

        if( is_array($value) ) return $value;

        if( $value === null || $value === ''){
            return null;
        }

        switch ( strtolower($type) ){
            case 'int'    :  $value = intval( $value) ;
                break;
            case 'bool'   :  $value = boolval($value);
                break;
            //TODO:: XSS
            case 'string' :
                default   :  $value = strval( trim( $value ) );
        }
        return $value;
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function all( $type = 'post'  )
    {
        $result = strtolower($type) == 'post'
            ? $_POST
            : $_GET;
        return $result;
    }

    /**
     * @return mixed
     */
    public function cookie()
    {
        if( $this->cookie == null ) {
            $this->cookie = new CookieCollect(
                [
                    '_cookie' => $this->loadCookie(),
                    'readOnly'=>true
                ]);
        }
        return $this->cookie;
    }

    /**
     * @return array
     */
    protected function loadCookie()
    {
        $cookie = [];
        foreach( $_COOKIE as $key=>$value ) {
            $cookie[$key] = new Cookie(
                [
                    'name'=>$key,
                    'value'=>$value
                ]);
        }
        return $cookie;
    }

    /**
     * @return mixed
     */
    public function session()
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function files()
    {
        if(  $this->fileCollection == null  ){
            $this->fileCollection  = new FilesCollect();
        }
        return $this->fileCollection;
    }

}