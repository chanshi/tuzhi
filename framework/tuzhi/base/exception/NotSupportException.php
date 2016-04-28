<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 16:58
 */

namespace tuzhi\base\exception;


class NotSupportException extends Exception
{
    public function getName()
    {
        return 'Not Support ';
    }
}