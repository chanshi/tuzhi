<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 10:29
 */

namespace tuzhi\helper;


use tuzhi\web\Application;

/**
 * Class Url
 * @package tuzhi\helper
 */
class Url
{

    /**
     * 拼接
     * @param array $param
     * @param bool $append
     * @return string
     */
    public static function build( $param = [] , $append = false  )
    {
        $GET = $append
            ? Application::Request()->all('get')
            : [] ;
        $GET = array_merge($GET,$param);

        $queryString = $GET ? '?'.Http::buildQueryString($GET) : '';

        return $queryString;
    }

    /**
     * @return mixed
     */
    public static function patten()
    {
        return  '/'.Application::Request()->getPath();
    }

    /**
     * @param array $params
     * @param $append
     * @return string
     */
    public static function create( $params = [] , $append )
    {
        return static::patten().static::build($params,$append);
    }
}