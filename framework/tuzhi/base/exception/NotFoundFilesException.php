<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 23:28
 */

namespace tuzhi\base\exception;


class NotFoundFilesException extends Exception
{
    public function getName()
    {
        return 'Not Found Files';
    }
}