<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 10:08
 */

namespace tuzhi\helper;

/**
 * Class Str
 * @package tuzhi\helper
 */
class Str
{
    /**
     * @param $handler
     * @param $str
     * @return bool
     */
    public function starWith( $handler , $str )
    {
        return  strpos( $handler ,$str ) === 0
            ? true
            : false ;
    }

    /**
     * 随机数
     *
     * @param int $num
     * @return string
     */
    public static function random( $num = 6 )
    {
        $all = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
        return substr(str_shuffle($all),0,$num);
    }

    /**
     * 首字母大写
     *
     * @param $string
     * @return string
     */
    public static function ucFirst( $string )
    {
        return ucfirst(strtolower($string));
    }

    /**
     * 字符长度
     *
     * @param $string
     * @return int
     */
    public static function length($string)
    {
        return mb_strlen($string,\Tuzhi::App()->charset);
    }
}