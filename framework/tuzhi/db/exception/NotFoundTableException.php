<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/9
 * Time: 10:02
 */

namespace tuzhi\db\exception;

use tuzhi\base\exception\Exception;

class NotFoundTableException extends Exception
{
    public function getName()
    {
        return 'Not Found Table';
    }
}