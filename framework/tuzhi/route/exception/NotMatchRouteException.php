<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 15:28
 */

namespace tuzhi\route\exception;


use tuzhi\base\exception\Exception;

/**
 * Class NotMatchRouteException
 * @package tuzhi\route\exception
 */
class NotMatchRouteException extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Not Match Route';
    }
}