<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/31
 * Time: 18:00
 */

namespace tuzhi\model;


/**
 * Class Form
 * @package app\model
 */
class Form extends Model
{
    public function submit()
    {
        if($this->verify()){
            return $this->add();
        }
        return $this->getVerifyFirstError();
    }

}