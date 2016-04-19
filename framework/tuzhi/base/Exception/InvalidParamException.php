<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 23:32
 */

namespace tuzhi\base\exception;

class InvalidParamException extends Exception
{
    public function getName()
    {
        return 'Invalid Param';
    }
}