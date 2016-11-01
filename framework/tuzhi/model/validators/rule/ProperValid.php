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

    /**
     * @var
     */
    public $type;

    /**
     * @return bool
     */
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
                case 'ip' : break;
                case 'money' : break;
                default : return true;
            }
        }
        return true;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function checkUserName( $value )
    {
        if( !preg_match('#^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$#u',$value) ){
            $this->addError();
            return false;
        }
        return true;
    }

    /**
     * @param $value
     * @return bool
     */
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
        if( ! filter_var($value,FILTER_VALIDATE_EMAIL) ){
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
        if(!preg_match('#^[1]{1}[3|5|7|8]{1}[0-9]{9}$#',$value))
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

    /**
     * @param $value
     * @return bool
     */
    protected function checkUrl($value)
    {
        if(! filter_var($value,FILTER_VALIDATE_URL))
        {
            $this->addError();
            return false;
        }
        return true;
    }

    protected function checkIP($value)
    {
        if( ! filter_var($value,FILTER_VALIDATE_IP) ){
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