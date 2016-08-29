<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 10:28
 */


namespace tuzhi\helper;

/**
 * Class Http
 * @package tuzhi\helper
 */
class Http
{
    /**
     * @param $param
     * @param bool $encode
     * @return string
     */
    public static function buildQueryString( $param ,$encode = false )
    {
        $arg = array();
        while(list( $key,$value ) = each( $param ) ){
            $value = trim($value);
            $arg[] = ( $encode ?   $key.'='.urlencode($value)  :  $key.'='.$value);
        }
        $string = join('&',$arg);
        //
        if( get_magic_quotes_gpc() ) $string = stripslashes($string);
        return $string;
    }

    /**
     * @param $url
     * @return mixed
     */
    public static function curlGet( $url )
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); // 连接时间
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);     //限定 2 秒
        $responseText = curl_exec($curl);
        curl_close($curl);
        return $responseText;
    }
}

