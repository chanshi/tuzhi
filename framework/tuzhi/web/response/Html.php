<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 10:56
 */

namespace tuzhi\web\response;

use tuzhi\base\BObject;
use tuzhi\contracts\web\IResponse;

class Html extends BObject implements IResponse
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
     *
     */
    public function send()
    {
        $this->sendHeader();
        return $this->content;
    }

    /**
     *
     */
    protected function sendHeader()
    {
        $this->response->sendStatsCode();  //send 200
        header("Content-type: text/html; charset=utf-8");
        $this->response->sendCookie();
    }
}