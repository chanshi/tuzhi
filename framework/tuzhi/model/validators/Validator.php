<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 16:46
 */

namespace tuzhi\model\validators;

use tuzhi\base\Object;

/**
 *
 * Class Validator
 * @package tuzhi\validators
 */
class Validator extends Object
{

    /**
     * @var
     */
    public $mode;

    /**
     * @var
     */
    public $rules = [];

    /**
     * @var
     */
    public $attributes;

    /**
     * @var array
     */
    protected static $ruleMaps =
        [
            /**
             * 包含  只在 Insert 标记下执行
             */
            'require' => 'tuzhi\model\validators\rule\RequireValid' ,
            /**
             * 闭包函数
             */
            'closure' => '',
        ];

    /**
     * @var
     */
    protected $error;

    /**
     * @var array
     */
    protected $runAttribute=[];

    protected $fullRuleObject = [];


    /**
     * Init
     */
    public function init()
    {
        $this->initRules();
    }

    /**
     * @param $attributes
     * @return bool
     */
    protected function beforeVerify( $attributes )
    {
        $this->error = [];
        $this->runAttribute = [];
        if( $attributes ){
            foreach( $attributes as $attribute )
            {
                if( in_array($attribute,$this->attributes) ){
                    $this->runAttribute[] = $this->attributes[$attribute];
                }
            }
        }else{
            $this->runAttribute = $this->fullRuleObject;
        }
        return true;
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function verify( $attributes = [] )
    {
        $this->beforeVerify( $attributes );

        foreach( $this->runAttribute as $object ) {
            if( ! $object->verify() ){
                return false;
            }
        }
        return true;
    }




    /**
     * @return bool
     */
    protected function initRules()
    {
        foreach( $this->rules as $attribute =>$rules ){
            if( ( $Object = $this->buildRuleClass($rules,$attribute) )  ){
                $this->attributes[$attribute] =$Object;
            }
        }
        return true;
    }

    /**
     * @param $rules
     * @param $attribute
     * @return array
     */
    protected function buildRuleClass( $rules ,$attribute)
    {
        $Object = [];
        foreach( $rules as $rule ) {
            $type =  strtolower(  array_unshift($rule) );
            $config = array_merge($rule,
                [
                    'validator'=>$this,
                    'attribute'=>$attribute
                ]);
            if( in_array($type,static::$ruleMaps) ){
                $ruleObject = \Tuzhi::make(
                    static::$ruleMaps[$type],
                    $config
                );
                $Object[]= $ruleObject;
                $this->fullRuleObject[] = $ruleObject;
            }
        }
        return $Object;
    }

}