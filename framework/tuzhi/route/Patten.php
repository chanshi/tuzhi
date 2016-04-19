<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/11
 * Time: 21:13
 */

namespace tuzhi\route;

use tuzhi\helper\Arr;
/**
 * 模式匹配
 *
 * Class Patten
 * @package tuzhi\route
 */
class Patten
{
    /**
     * @var
     */
    public $raw;

    /**
     * @var
     */
    public $segment;

    /**
     * @var array
     */
    public $matched=[];


    /**
     * Patten constructor.
     * @param $patten
     */
    public function __construct( $patten )
    {
        $this->raw = $patten;

        $this->segment = $this->normalizePatten($this->raw);
    }

    /**
     * @param $patten
     * @return mixed
     */
    protected function normalizePatten( $patten )
    {
        $seg = explode('/', ltrim($patten,'/') );

        foreach( $seg as $index=>$value ){
            if( strpos($value,'<') === 0 && strpos($value,'>') === ( strlen($value) - 1 ) ){
                 $reg = explode(':',substr( $value ,1,-1 ));
                if( $reg[0] ){
                    $reg[0] = "#^({$reg[0]})+$#i";
                }
                $seg[$index] = $reg;
            } else {
                $seg[$index] = $value;
            }
        }
        return $seg;
    }

    /**
     * @param $path
     * @return null
     */
    protected function normalizeUrlPath( $path )
    {
        $path = trim($path,'/');
        //$path = Arr::head( explode('.',$path) );
        return empty($path) ? null :  explode('/',$path);
    }

    /**
     * 匹配算法
     *
     * @param $path
     * @return bool
     */
    public function match( $path ){
        
        $path = $this->normalizeUrlPath($path);

        //空值匹配
        if( $path == null && empty( $this->segment[0] ) ){
            return  true;
        }

        $isMatch = true;
        foreach( $path as $index=>$value ){
            // 空值的情况
            if( !isset( $this->segment[$index] ) || empty( $this->segment[$index] )  ){
                return false;
            }
            // 匹配字符串
            if( is_string( $this->segment[$index] )  ){
                if( strtolower( $value ) ==  strtolower( $this->segment[$index] ) ){
                    continue;
                }else{
                    return false;
                }
            }
            // 匹配字段
            if( is_array( $this->segment[$index] ) ) {
                preg_match( $this->segment[$index][0] ,$value ,$match );
                if( isset($match[1])){
                    $this->matched[$this->segment[$index][1]] = $match[1];
                    continue;
                }else {
                    return false;
                }
            }
        }

        return $isMatch;
    }

    /**
     * @return array
     */
    public function getMatchValue()
    {
        return $this->matched;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return  (string) md5(  $this->raw  );
    }
}