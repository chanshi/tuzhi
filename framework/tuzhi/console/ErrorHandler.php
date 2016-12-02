<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 21:57
 */

namespace tuzhi\console;


class ErrorHandler extends \tuzhi\base\ErrorHandler
{

    /**
     * @param $exception
     */
    protected function renderException($exception)
    {
        $message = $exception->getMessage();
        echo ''.$exception->getName().': '.$message."\n";
        echo 'File: '.$exception->getFile()."\n";
        echo 'Line: '.$exception->getLine()."\n";
    }
}