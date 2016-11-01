<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:43
 */

namespace tuzhi\web;

use Tuzhi;
use tuzhi\base\Object;
use tuzhi\contracts\web\IResponse;
use Closure;
use tuzhi\web\cookie\CookieCollect;

/**
 * Class Response
 * @package tuzhi\web
 */
class Response extends Object implements IResponse
{

    /**
     * @var
     */
    protected $header;

    /**
     * @var
     */
    protected $version;

    /**
     * @var
     */
    protected $cookie;

    /**
     * @var array
     */
    protected static $responseClass  =
        [
            'html'=>'tuzhi\web\response\Html',
            'json'=>'tuzhi\web\response\Json',
            'closure'=>'tuzhi\web\response\Closure',
            'redirect'=> 'tuzhi\web\response\Redirect'
        ];

    /**
     * @var array
     */
    public static $httpStatuses = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        118 => 'Connection timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        210 => 'Content Different',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        310 => 'Too many Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested range unsatisfiable',
        417 => 'Expectation failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable entity',
        423 => 'Locked',
        424 => 'Method failure',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway or Proxy Error',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        507 => 'Insufficient storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    /**
     * @var
     */
    public $content;

    /**
     * @var
     */
    public $format;

    /**
     * init
     */
    public function init()
    {
        if ($this->version === null) {
            $this->version = (isset($_SERVER['SERVER_PROTOCOL']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.0')
                ? '1.0'
                : '1.1';
        }
    }

    /**
     * @param $content
     */
    public function setContent( $content )
    {
        if(is_string($content)){
            $this->content = Tuzhi::make(
                [
                    'class' => static::$responseClass['html'],
                    'response' => $this,
                    'content' => $content
                ]
            );
        }else if(is_array( $content )){
            $this->content = \Tuzhi::make(
                [
                    'class' => static::$responseClass['json'],
                    'response' => $this,
                    'content' => $content
                ]
            );
        }else if( $content instanceof Closure) {
            $this->content = \Tuzhi::make(
                [
                    'class'=> static::$responseClass['closure'],
                    'response' => $this,
                    'content' => $content
                ]
            );
        }else if ( $content instanceof  IResponse){
            $this->content = $content;
        }
    }

    public function getResponseClass( $className )
    {
        return static::$responseClass[$className];
    }

    /**
     *
     */
    public function send()
    {
        if( $this->content instanceof IResponse) {
            echo $this->content->send();
        }else{
            //TODO:: 这里需要完善
            echo 'Null';
        }
    }

    /**
     * @return bool
     */
    public function sendCookie()
    {
        if( $this->cookie == null ){
            return false;
        }

        foreach( $this->cookie as $name=>$cookie ) {
            setcookie(
                $cookie->name,
                $cookie->value,
                $cookie->expire,
                $cookie->path,
                $cookie->domain,
                $cookie->secure,
                $cookie->httpOnly
            );
        }
        return true;
    }


    /**
     * @param $url
     * @param int $statusCode
     */
    public function redirect($url,$statusCode = 302)
    {
        $this->sendStatsCode($statusCode);
        $this->sendCookie();
        header("Location: {$url}");
        //TODO::
        exit(0);
    }


    /**
     * @param int $statusCode
     */
    public function sendStatsCode( $statusCode = 200 )
    {
        $statusText = static::$httpStatuses[$statusCode];
        header("HTTP/{$this->version} {$statusCode} {$statusText}");
    }



    /**
     * Initializes HTTP request formats.
     * @see \Symfony\Component\HttpFoundation\Request
     */
    protected static function initializeFormats()
    {
        static::$formats = array(
            'html' => array('text/html', 'application/xhtml+xml'),
            'txt' => array('text/plain'),
            'js' => array('application/javascript', 'application/x-javascript', 'text/javascript'),
            'css' => array('text/css'),
            'json' => array('application/json', 'application/x-json'),
            'xml' => array('text/xml', 'application/xml', 'application/x-xml'),
            'rdf' => array('application/rdf+xml'),
            'atom' => array('application/atom+xml'),
            'rss' => array('application/rss+xml'),
            'form' => array('application/x-www-form-urlencoded'),
        );
    }

    /**
     * @return CookieCollect
     */
    public function cookie()
    {
        if($this->cookie == null){
            $this->cookie = new CookieCollect();
        }
        return $this->cookie;
    }

}