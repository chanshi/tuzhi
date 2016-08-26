<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 18:01
 */

namespace tuzhi\validators;

use tuzhi\base\Object;

abstract class Valid extends Object
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
    public $attributeLabel;


    /**
     * @param $message
     * @return $this
     */
    public function addError( $message )
    {
        return $this->validator->addError( $this->attribute ,$message );
    }

    /**
     * @param $value
     * @return mixed
     */
    abstract public function valid( $value );
}