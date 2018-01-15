<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 16:30
 */

namespace tuzhi\auth;

use tuzhi\base\Object;

/**
 * Class Guard
 * @package tuzhi\auth
 */
class Guard extends Object
{
    protected $user;

    /**
     * @return bool
     */
    public function check()
    {
        return  ! is_null( $this->user);
    }

    /**
     * @param $credentials
     */
    public function validate( $credentials = [])
    {

    }

    /**
     *
     */
    public function user()
    {
        return $this->user;
    }


}