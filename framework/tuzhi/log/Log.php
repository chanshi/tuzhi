<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:15
 */

namespace tuzhi\log;


use tuzhi\base\Serve;

class Log extends Serve
{
    const LOG_NOTICE  = 1;

    const LOG_WARRING = 2;

    const LOG_ERROR   = 4;

    const LOG_ALL     = 7;

    public function __construct( $config = [] )
    {

    }

    public static function notice( $message )
    {

    }

    public static function warring( $message )
    {

    }

    public static function error( $message )
    {

    }
}