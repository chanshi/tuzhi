<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:43
 */

namespace tuzhi\web;


use tuzhi\base\Server;
use tuzhi\contracts\web\IResponse;

class Response extends Server implements IResponse {

    protected $header;

    protected $content;
    

    public function sendHeader()
    {

    }


    public function setContent( $content )
    {
        $this->content = $content;
    }

    public function sendContent()
    {
        if( $this->content ){
            echo $this->content;
        }
        return;
    }

    public function send()
    {
        $this->sendHeader();
        $this->sendContent();
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
}