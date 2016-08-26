<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 16:46
 */

namespace tuzhi\validators;


use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;

/**
 * 大爷 忘了解耦
 *
 * Class Validator
 * @package tuzhi\validators
 */
class Validator extends Object
{

    const TYPE_SEGMENT = 1;
    const TYPE_ALL = 2;

    /**
     * @var array
     */
    public static $valid =
        [
            'closure'=> 'tuzhi\validators\validator\ClosureValid',
            'number' => 'tuzhi\validators\validator\NumberValid',
            'unique' => 'tuzhi\validators\validator\UniqueValid',
            'null' => 'tuzhi\validators\validator\NullValid'
        ];

    /**
     * @var null
     */
    protected $error = null;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var  允许为 array or Model
     */
    public $data;


    public function setRules( $rules )
    {
        foreach( $rules as $rule )
        {
            $this->validators[] = $this->registerValid($rule);
        }
        return $this;
    }

    protected function registerValid( $rule )
    {
        $attribute = array_shift($rule);
        $validType = strtolower( array_shift($rule) );

        $rule['class'] = static::$valid[$validType];
        $rule['validator'] = $this;
        $rule['attribute'] = $attribute;

        return \Tuzhi::make( $rule );
    }

    /**
     * @param $data
     * @param int $type
     * @return bool|void
     * @throws InvalidParamException
     */
    public function verify( $data ,$type = Validator::TYPE_SEGMENT)
    {
        $this->clean();
        $this->data = $data;
        if($type == Validator::TYPE_SEGMENT){
            return $this->verifySegment($data);
        }
        if($type == Validator::TYPE_ALL){
            return $this->verifyAll($data);
        }
        throw new InvalidParamException('Invalid Param Type in class Validator '.$type);
    }

    /**
     * 片段验证
     * @param $data
     * @return bool
     */
    public function verifySegment( $data )
    {
        $verify = true;
        foreach ($this->validators as $validator)
        {
            $attribute = $validator->attribute;
            if( ! array_key_exists($attribute,$data) ){
                continue;
            }

            $verify = $verify && $validator->valid( $data[$attribute] );
        }
        return $verify;
    }

    /**
     * 整体验证
     * @param $data
     * @return bool
     */
    public function verifyAll( $data )
    {
        $verify = true;
        foreach($this->validators as $validator){

            $attribute = $validator->attribute;

            $verify = $verify && $validator->valid(  isset($data[$attribute]) ? $data[$attribute] : null  );
        }
        return $verify;
    }

    /**
     * @param null $attribute
     * @return null
     */
    public function getErrors( $attribute = null )
    {
        if( $attribute && isset($this->error[$attribute]) ){
            return $this->error[$attribute];
        }
        return $this->error;
    }

    /**
     * @param $attribute
     * @param $message
     * @return $this
     */
    public function addError($attribute,$message)
    {
        if(!isset($this->error[$attribute])){
            $this->error[$attribute]=[];
            $this->error[$attribute][] = $message;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function clean()
    {
        $this->error = [];
        $this->data = [];
        return true;
    }
}