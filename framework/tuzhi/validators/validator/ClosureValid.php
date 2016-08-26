<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 17:49
 */

namespace tuzhi\validators\validator;


use tuzhi\validators\Valid;

class ClosureValid extends Valid
{

    public $closure;


    public function valid( $value )
    {
        return call_user_func_array($this->closure,[$this->validator,$this->attributeValue]);

    }
}