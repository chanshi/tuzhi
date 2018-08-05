<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 17:24
 */

namespace tuzhi\nosql\redis;

use tuzhi\base\Struct;

/**
 * Class Server
 * @package tuzhi\nosql\redis
 */
class Server extends Struct
{
    /**
     * @var string
     */
    public $host = '127.0.0.1';

    /**
     * @var int
     */
    public $port = 6379;

    /**
     * @var int
     */
    public $timeout = 0;

    /**
     * @var bool
     */
    public $pConnect = true;

    /**
     * @var int
     */
    public $dbIndex = 0;

    /**
     * @var string
     */
    public $auth = "";

}