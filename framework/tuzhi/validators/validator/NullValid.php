<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/12
 * Time: 11:12
 */

namespace tuzhi\validators\validator;


use tuzhi\validators\Valid;

class NullValid extends Valid
{

    /**
     * @param $value
     * @return bool
     */
    public function valid($value)
    {
        if( empty($value) ){
            $this->sendError();
            return false;
        }else{
            return true;
        }
    }

    /**
     * 错误信息
     */
    public function sendError(){
        $message = $this->attribute.'不允许为空';
        $this->addError($message);
    }
}