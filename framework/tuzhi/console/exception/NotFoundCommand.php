<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/2
 * Time: 14:24
 */

namespace tuzhi\console\exception;


use tuzhi\base\exception\Exception;

class NotFoundCommand extends Exception
{
    public function getName()
    {
        return 'Not Found Command';
    }
}