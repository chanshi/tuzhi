<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 21:53
 */

namespace tuzhi\model;
use tuzhi\base\Object;


/**
 * 数据模型 静态变量处理吧
 *
 * Class Model
 * @package tuzhi\model
 */
class Model extends Object implements \Countable ,\ArrayAccess
{


    /**
     * @var 字段
     */
    protected $attributes = [];
    protected $oldAttributes = [];

    protected $onlyRead = [];
    /**
     * @var
     */
    protected $attributeLabel=[];

    /**
     * @var array 验证规则
     */
    protected $rules = [];

    /**
     * @var string
     */
    protected $validClass = 'tuzhi\validators\Validator';

    /**
     * @var null
     */
    protected $validator = null;

    /**
     *
     */
    public function init()
    {
        $this->getLabels();
        $this->getRules();
    }

    /**
     * @return array
     */
    public function getLabels()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return [];
    }

    /**
     * @return mixed|null
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    protected function getValidators()
    {
        if( $this->validator == null ){
            $this->validator = \Tuzhi::make(
                [
                    'class'=>$this->validClass,
                    'model'=>$this
                ]);
            $this->validator->setRules( $this->getRules() );
        }
        return $this->validator;
    }

    /**
     * @param null $data
     * @param null $scene
     * @return mixed
     */
    public function valid( $data = null ,$scene = null )
    {
        $data = ($data == null ? $this->attributes : $data );

        return $this->getValidators()->verify( $data, $scene );
    }

    public function getErrors( $attribute = null )
    {
        return $this->getValidators()->getErrors($attribute);
    }



    /**
     * 字段标签
     * @param $attribute
     * @return mixed
     */
    public function getLabel( $attribute )
    {
        return isset($this->attributeLabel[$attribute])
            ? $this->attributeLabel[$attribute]
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
        if(isset($this->attributes[$attribute])){
            if( in_array($attribute,$this->onlyRead) ){
                return false;
            }
            $this->oldAttributes[$attribute] = $this->attributes[$attribute];
        }
        return $this->attributes[$attribute] = $value;
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
        return isset($this->attributes[$attribute])
            ? $this->attributes[$attribute]
            : null;
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
        return isset($this->attributes[$attribute])
            ? $this->attributes[$attribute]
            : null;
    }

    /**
     * @param mixed $attribute
     * @return bool
     */
    public function offsetUnset($attribute)
    {
        if(isset($this->attributes[$attribute])){
            unset($this->attributes[$attribute]);
        }
        if(isset($this->oldAttributes[$attribute])){
            unset($this->oldAttributes[$attribute]);
        }
        return true;
    }

}