<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/29
 * Time: 14:26
 */

namespace tuzhi\web\response;

use tuzhi\base\Object;
use tuzhi\contracts\web\IResponse;

class Closure extends Object implements IResponse
{

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
        $this->response->sendStatsCode();
    }

    /**
     *
     */
    public function send()
    {
        $this->sendHeader();
        return call_user_func($this->content);
    }
}