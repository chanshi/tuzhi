<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:11
 */


namespace tuzhi\route;

class Router
{
    public static $route;

    public static $via = ['GET','POST'];

    /**
     *
     * @param $via
     * @param $args
     */
    public static function __callStatic( $via , $args ){

    }

    public static function addRule( $rule = [] )
    {

    }
}