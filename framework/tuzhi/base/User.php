<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 15:13
 */

namespace base;


use tuzhi\base\Object;

class User extends Object
{

    const GUEST  = 0;

    const MEMBER = 1;

    /**
     * @var User Model;
     */
    protected $model;

    /**
     * @return bool
     */
    public function isGuest()
    {
        return $this->getUserId() == User::GUEST;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->model['uid'];
    }

}