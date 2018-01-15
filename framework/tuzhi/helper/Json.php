<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/9
 * Time: 19:11
 */

namespace tuzhi\helper;

/**
 * Class Json
 * @package tuzhi\helper
 */
class Json
{
    /**
     * @param $data
     * @return string
     */
    public static function encode($data)
    {
        return json_encode($data);
    }

    /**
     * @param $data
     * @param bool $type
     * @return mixed
     */
    public static function decode($data,$type = true)
    {
        return json_decode($data, $type);
    }
}