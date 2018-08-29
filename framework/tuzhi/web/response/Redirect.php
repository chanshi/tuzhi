<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 15:08
 */

namespace tuzhi\web\response;


use tuzhi\base\BObject;
use tuzhi\contracts\web\IResponse;

/**
 * Class Redirect
 * @package tuzhi\web\response
 */
class Redirect extends BObject implements IResponse
{

    /**
     * @var
     */
    public $response;

    /**
     * @var
     */
    public $content;

    /**
     * @var int
     */
    public $httpStatsCode = 302;

    /**
     * @return mixed
     */
    public function sendHeader()
    {
        $this->response->sendStatsCode( $this->httpStatsCode );  //send 302
        $this->response->sendCookie();
    }

    /**
     * @return mixed
     */
    public function send()
    {
        $this->sendHeader();
        header("Location: {$this->content}");
        exit(0);
    }
}