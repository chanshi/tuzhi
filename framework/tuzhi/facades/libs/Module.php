<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 17:29
 */

class Module
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $service = Tuzhi::App()->get('module');
        $Module = call_user_func([$service,'getModule'],$name);

        return isset($arguments[0])
            ? $Module[$arguments[0]]
            : $Module ;
    }
}