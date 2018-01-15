<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/13
 * Time: 15:05
 */

namespace tuzhi\base\exception;

/**
 * Class RuntimeException
 * @package tuzhi\base\exception
 */
class RuntimeException extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Runtime';
    }
}