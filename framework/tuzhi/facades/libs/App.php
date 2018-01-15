<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/12
 * Time: 16:36
 */

class App
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundServersException
     */
    public static function __callStatic($name, $arguments)
    {
        $service = strtolower($name);
        return Tuzhi::$app->get($service);
    }
}