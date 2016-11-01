<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/31
 * Time: 16:52
 */

namespace tuzhi\base\exception;

/**
 * Class NotFoundServersException
 * @package tuzhi\base\exception
 */
class NotFoundServersException extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Not Found Servers';
    }
}