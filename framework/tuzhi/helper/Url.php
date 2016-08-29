<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 10:29
 */

namespace tuzhi\helper;



use tuzhi\web\Application;

class Url
{

    /**
     *
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

        $queryString = $GET ? '?'.http_build_query($GET) : '';

        return $queryString;
    }
}