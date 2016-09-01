<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 16:59
 */

namespace tuzhi\model\validators\rule;


use tuzhi\model\validators\Verify;

class ProperValid extends Verify
{

    public $type;


    protected function check()
    {
        if( ($value = $this->getAttribute() )  && $this->type )
        {
            switch ( strtolower( $this->type )  ){
                case 'username' :
                    return $this->checkUserName($value);
                    break;
                case 'password' :
                    return $this->checkPassword($value);
                    break;
                case 'email' :
                    return $this->checkEmail( $value );
                    break;
                case 'mobile' :
                    return $this->checkMobile($value);
                    break;
                case 'tel' :
                    return $this->checkTel($value);
                    break;
                case 'url' :
                    return $this->checkUrl($value);
                default : return true;
            }
        }
        return true;
    }

    protected function checkUserName( $value )
    {
        if( !preg_match('#^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$#u',$value) ){
            $this->addError();
            return false;
        }
        return true;
    }

    protected function checkPassword($value)
    {
        if(! ( preg_match('#[\d]+#',$value) &&  preg_match('#[a-z]+#',$value) && preg_match('#[A-Z]+#',$value) ) ){
            $this->addError();
            return false;
        }
        return true;
    }


    /**
     * @param $value
     * @return bool
     */
    protected function checkEmail( $value )
    {
        if( ! preg_match('/^(?P<name>(?:"?([^"]*)"?\s)?)(?:\s+)?(?:(?P<open><?)((?P<local>.+)@(?P<domain>[^>]+))(?P<close>>?))$/i', $value) ){
            $this->addError();
            return false;
        }
        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function checkMobile( $value )
    {
        if(!preg_match('#^1[\d]{10}$#',$value))
        {
            $this->addError();
            return false;
        }
        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function checkTel($value)
    {
        if(!preg_match('#^([0\+]\d{2,3}\-)?(0\d{2,3}-)(\d{7,8})(\-\d{3,})?$#',$value))
        {
            $this->addError();
            return false;
        }
        return true;
    }

    protected function checkUrl($value)
    {
        if(!preg_match('#^((http|https)\:\/\/)?[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$#gi',$value))
        {
            $this->addError();
            return false;
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