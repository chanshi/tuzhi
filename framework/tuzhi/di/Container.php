<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:32
 */

namespace tuzhi\di;

/**
 * Class Container
 * @package tuzhi\di
 */
class Container
{
    private static $instance = null;


    public static function getInstance()
    {
        if( static::$instance == null ){
            static::$instance = new static();
        }
        return static::$instance;
    }

}