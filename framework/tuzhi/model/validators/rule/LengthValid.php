<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 16:43
 */

namespace tuzhi\model\validators\rule;


use tuzhi\model\validators\Verify;

class LengthValid extends Verify
{

    /**
     * @var
     */
    public $min;

    /**
     * @var
     */
    public $max;


    /**
     * @return bool
     */
    protected function check()
    {
        if( ($value = $this->getAttribute() ) ){
            if( $this->min ){
                if( is_array( $value ) ){
                     if (count($value) < $this->min){
                         $this->addError();
                     }
                }else if(is_string( $value )){
                    if( mb_strlen( $value ) < $this->min ){
                        $this->addError();
                    }
                }else if( is_integer($value)){
                    if( $value < $this->min){
                        $this->addError();
                    }
                }
            }
            if($this->max){
                if( is_array( $value ) ){
                    if (count($value) > $this->max){
                        $this->addError();
                    }
                }else if(is_string( $value )){
                    if( mb_strlen( $value ) > $this->max ){
                        $this->addError();
                    }
                }else if( is_integer($value) ){
                    if( $value > $this->max){
                        $this->addError();
                    }
                }
            }
        }
        return true;
    }

    /**
     * @return bool
     */
    public function verify()
    {
        return $this->check();
    }
}