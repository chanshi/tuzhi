<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/7
 * Time: 13:54
 */

/**
 * Class User
 */
class User
{


    /**
     * @return mixed
     */
    public static function getModel()
    {
        return Tuzhi::App()
            ->get('user')
            ->getModel();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func([static::getModel(),$name],$arguments);
    }
}