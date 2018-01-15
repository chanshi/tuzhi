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
     * @param $queryString
     * @return array
     */
    public static function parseQueryString( $queryString )
    {
        $result = [];
        if( $queryString != '' ){
            parse_str($queryString,$result);
        }
        return $result;
    }

    /**
     * @param $url
     * @param array $options
     * @return mixed
     */
    public static function curlGet( $url ,$options=[])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20); // 连接时间
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);     //限定 2 秒
        if($options){
            curl_setopt_array($curl,$options);
        }
        $responseText = curl_exec($curl);
        $info = curl_getinfo($curl);
        //print_r($info);
        curl_close($curl);
        return $responseText;
    }

    /**
     * @param $url
     * @param $data
     * @param array $options
     * @return mixed
     */
    public static function curlPost($url,$data,$options=[])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
        curl_setopt($curl, CURLOPT_POST, true); // post传输数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // post传输数据
        if($options){
            curl_setopt_array($curl,$options);
        }
        $responseText = curl_exec($curl);
        $info = curl_error($curl);
        curl_close($curl);
        return $responseText;
    }
}

