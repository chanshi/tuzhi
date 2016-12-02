<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/3
 * Time: 13:34
 */
namespace tuzhi\route\exception;


use tuzhi\base\exception\Exception;

/**
 * Class NotMatchRouteException
 * @package tuzhi\route\exception
 */
class NotFoundPage extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Not Found Page';
    }
}