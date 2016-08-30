<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 10:56
 */

namespace tuzhi\web\response;

use tuzhi\base\Object;
use tuzhi\contracts\web\IResponse;

class Json extends Object implements IResponse
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
    protected function sendHeader()
    {
        $this->response->sendStatsCode();  //send 200
        header("Content-type: application/json; charset=utf-8");
    }

    /**
     *
     */
    public function send()
    {
        $this->sendHeader();
        return json_encode( $this->content );
    }
}