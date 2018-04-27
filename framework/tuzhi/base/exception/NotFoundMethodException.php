<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 15:02
 */

namespace tuzhi\base\exception;

/**
 * Class NotFoundMethodException
 * @package tuzhi\base\exception
 */
class NotFoundMethodException extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Not Found Method';
    }
}