<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 18:01
 */

namespace tuzhi\model\validators;

use tuzhi\base\Object;

abstract class Verify extends Object
{
    /**
     * @var Validator;
     */
    public $validator;

    /**
     * @var 验证的 字段
     */
    public $attribute;

    /**
     * @var
     */
    public $error;

    /**
     * @var
     */
    public $success;


    /**
     * @param $message
     * @return $this
     */
    public function addError( $message )
    {
        return $this->validator->addError( $this->attribute ,$message );
    }

    /**
     * @return mixed
     */
    abstract public function verify( );
}