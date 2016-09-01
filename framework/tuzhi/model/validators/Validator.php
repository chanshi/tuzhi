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
    public $model;

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
            'require' => 'tuzhi\model\validators\rule\RequireValid',
            'closure' => 'tuzhi\model\validators\rule\ClosureValid',
            'regular' => 'tuzhi\model\validators\rule\RegularValid',
            'compare' => 'tuzhi\model\validators\rule\CompareValid',
            'length'  => 'tuzhi\model\validators\rule\LengthValid',
            'proper'  => 'tuzhi\model\validators\rule\ProperValid',
        ];

    /**
     * @var
     */
    protected $error;

    /**
     * @var array
     */
    protected $runAttribute=[];

    /**
     * @var array
     */
    protected $fullRuleObject = [];

    /**
     * @var bool
     */
    protected $verifyStatus = true;


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
        $this->verifyStatus = true;
        $this->model->setVerifyErrors([]);
        if( $attributes ){
            foreach( $attributes as $attribute ) {
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
     * @param bool $all
     * @return bool
     */
    public function verify( $attributes = [] ,$all = false)
    {
        $this->beforeVerify( $attributes );

        foreach( $this->runAttribute as $object ) {
            if(  ! $object->verify() && $all  ){
                break;
            }
        }
        $this->afterVerify();
        return $this->verifyStatus;
    }

    /**
     * @return bool
     */
    public function afterVerify()
    {
        $this->model->setVerifyErrors($this->error);
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
            //print_r($rule);exit;
            $type =  strtolower(  array_shift($rule) );
            $config = array_merge($rule,
                [
                    'validator'=>$this,
                    'attribute'=>$attribute
                ]);
            if( in_array($type, array_keys( static::$ruleMaps ) ) ){
                $config['class'] = static::$ruleMaps[$type];
                $ruleObject = \Tuzhi::make( $config );
                $Object[]= $ruleObject;
                $this->fullRuleObject[] = $ruleObject;
            }
        }
        return $Object;
    }

    /**
     * @param $attribute
     * @param $errorMessage
     * @return bool
     */
    public function setError( $attribute , $errorMessage )
    {
        if( $this->verifyStatus ){
            $this->verifyStatus = false;
        }

        if( ! isset($this->error[$attribute]) ){
            $this->error[$attribute] = [];
        }
        $this->error[$attribute][] = $errorMessage;
        return true;
    }

}