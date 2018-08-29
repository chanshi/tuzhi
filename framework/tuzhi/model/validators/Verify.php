<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 18:01
 */

namespace tuzhi\model\validators;

use tuzhi\base\BObject;

abstract class Verify extends BObject
{
    /**
     * @var Validator;
     */
    public $validator;

    /**
     * @var
     */
    public $attribute;

    /**
     * @var
     */
    public $error = '属性 {label} 验证错误';

    /**
     * @var
     */
    public $success = 'success';


    /**
     * @param null $attribute
     * @return mixed
     */
    protected function getAttribute( $attribute = null )
    {
        $attribute = $attribute
            ? $attribute
            : $this->attribute;
        return $this->validator->model->getAttribute( $attribute );
    }

    /**
     * @param null $attribute
     * @return mixed
     */
    protected function getLabel( $attribute = null)
    {
        $attribute = $attribute
            ? $attribute
            : $this->attribute;
        return $this->validator->model->getLabel($attribute);
    }

    /**
     *
     * @param $message
     * @return mixed
     */
    protected function reservedMessage($message)
    {
        $format =
            [
                '#{label}#'=>$this->getLabel()
            ];
        return preg_replace(array_keys($format),array_values($format),$message);
    }

    /**
     * @param null $message
     * @return bool
     */
    public function addError( $message = null )
    {
        $message = $message ? $message : $this->error;
        $this->validator->setError($this->attribute,$this->reservedMessage($message));
        return true;
    }

    /**
     * @return mixed
     */
    abstract public function verify();
}