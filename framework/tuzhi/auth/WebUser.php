<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 16:21
 */

namespace tuzhi\auth;


use tuzhi\contracts\auth\IUser;
use tuzhi\model\Model;

/**
 * Class WebUser
 * @package tuzhi\auth
 */
class WebUser extends Model implements IUser
{
    /**
     * @var array
     */
    protected $attAllow =
        [
            'id',
            'password',
        ];

    /**
     * @return mixed
     */
    public function getAuthId()
    {
        return $this['id'];
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this['password'];
    }

}