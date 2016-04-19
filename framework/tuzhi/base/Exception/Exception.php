<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 14:59
 */

namespace tuzhi\base\exception;

/**
 * Class Exception
 * @package tuzhi\base\exception
 */
class Exception extends \Exception
{
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'Exception';
    }
}