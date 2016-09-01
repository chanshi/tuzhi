<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 21:53
 */

namespace tuzhi\model;

use tuzhi\base\Object;
use tuzhi\model\validators\Validator;

/**
 * Class Model
 * @package tuzhi\model
 */
class Model extends Object implements \Countable ,\ArrayAccess, \IteratorAggregate
{

    /**
     * @var
     */
    protected $attributes = [];

    /**
     * @var
     */
    protected $attLabel = [];

    /**
     * @var array
     */
    protected $attAllow = [];

    /**
     * @var array
     */
    protected $attDeny = [];

    /**
     * @var array
     */
    protected $attFormat = [];

    /**
     * @var array
     */
    protected $attMaps = [];
    /**
     * @var null
     */
    protected $validator = null;

    /**
     * @var array 验证规则
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $validClass = 'tuzhi\model\validators\Validator';

    /**
     * @var array
     */
    private $errors =
        [
            'system' => '',
            'valid' =>[]
        ];


    public function init()
    {
        $this->attLabel = $this->initLabel();
        $this->rules = $this->initRules();
    }

    /**
     * @return array
     */
    protected function initLabel() { return [];}

    /**
     * @return array
     */
    protected function initRules() { return [];}

    /**
     * @param $attribute
     * @param $labelName
     */
    public function setLabel( $attribute , $labelName )
    {
        $this->attLabel[$attribute] = $labelName;
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getLabel( $attribute )
    {
        return isset( $this->attLabel[$attribute] )
            ? $this->attLabel[$attribute]
            : $attribute;
    }


    /**
     * @param $attributes
     */
    public function setAttributes( $attributes )
    {
        foreach( $attributes as $attribute =>$value ){
            $this->setAttribute($attribute ,$value);
        }
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function setAttribute( $attribute ,$value)
    {
        if( $this->isAllowAttr($attribute) == false ){
            return false;
        }

        if( $this->isDenyAttr($attribute) == true ){
            return false;
        }

        return $this->attributes[$attribute] = $value;
    }

    /**
     * @param $attribute
     * @return bool
     */
    protected function isAllowAttr( $attribute )
    {
        if( empty($this->attAllow) ){
            return true;
        }else{
            return in_array($attribute , $this->attAllow)
                ?  true
                : false;
        }
    }

    /**
     * @param $attribute
     * @return bool
     */
    protected function isDenyAttr( $attribute )
    {
        if( empty($this->attDeny) ) {
            return false;
        }else {
            return in_array($attribute,$this->attDeny )
                ? true
                : false;
        }
    }

    /**
     * @param $attribute
     * @return null
     */
    public function getAttribute( $attribute )
    {
        return isset($this->attributes[$attribute])
            ? $this->attributes[$attribute]
            : null;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     *
     * @param $attribute
     * @param null $format
     * @return mixed|null
     */
    public function format( $attribute , $format = null )
    {
        //TODO::  规则发生改变
        if( $format == null ){
            return isset( $this->attFormat[$attribute] )
                ? ( $this->attFormat[$attribute] instanceOf \Closure
                    ?   call_user_func($this->attFormat[$attribute],$this,$attribute)
                    :   $this->attFormat[$attribute]
                )
                : $this->getAttribute($attribute);
        }else{
            $this->attFormat[$attribute] = $format;
            return true;
        }
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function rmAttribute( $attribute )
    {
        if( isset($this->attributes[$attribute]) ){
            unset($this->attributes[$attribute]);
        }
        return true;
    }

    /**
     * @return bool
     */
    public function removeAll()
    {
        $this->attributes =[];
        return true;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function __set($attribute ,$value)
    {
        return $this->setAttribute($attribute,$value);
    }

    /**
     * 魔术方法
     * @param $attribute
     * @return null
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function __unset($attribute)
    {
        return $this->rmAttribute($attribute);
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count( $this->attributes );
    }

    /**
     * @param mixed $attribute
     * @return bool
     */
    public function offsetExists($attribute)
    {
        return isset($this->attributes[$attribute]) ;
    }

    /**
     * @param mixed $attribute
     * @param mixed $value
     * @return bool
     */
    public function offsetSet($attribute, $value)
    {
        return $this->setAttribute($attribute,$value);
    }

    /**
     * @param mixed $attribute
     * @return null
     */
    public function offsetGet($attribute)
    {
        return $this->getAttribute($attribute);
    }

    /**
     * @param mixed $attribute
     * @return bool
     */
    public function offsetUnset($attribute)
    {
        return $this->rmAttribute($attribute);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->attributes );
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->errors['system'] == ''
            ? false
            : true;
    }

    /**
     * @param $message
     */
    public function setErrorMessage( $message )
    {
        $this->errors['system'] = $message;
    }

    /**
     * @return array|string
     */
    public function getErrorMessage()
    {
        return $this->errors['system']
            ? $this->errors
            : '';
    }

    /**
     * @return mixed|null|Validator
     */
    public function getValidator()
    {
        if( !(  $this->validator instanceof  Validator ) ){
            $this->validator = \Tuzhi::make(
                $this->validator,
                [
                    'model'=>$this,
                    'rules'=>$this->rules
                ]
            );
        }
        return $this->validator;
    }

    /**
     * @param array $attributes
     */
    public function verify( $attributes = [] )
    {

    }

}