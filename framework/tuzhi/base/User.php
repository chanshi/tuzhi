<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 15:13
 */

namespace base;


use tuzhi\base\BObject;

/**
 * Class User
 * @package base
 */
class User extends BObject
{

    /**
     *
     */
    const GUEST  = 0;

    /**
     *
     */
    const MEMBER = 1;

    /**
     * @var User Model;
     */
    public $model;

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
        return $this->model
            ? $this->model->getId()
            : User::GUEST;
    }

}