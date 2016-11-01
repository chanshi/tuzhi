<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 17:33
 */

namespace tuzhi\module\exception;


use tuzhi\base\exception\Exception;

/**
 * Class NotFoundModuleException
 * @package tuzhi\module\exception
 */
class NotFoundModuleException extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Not Found Module';
    }
}