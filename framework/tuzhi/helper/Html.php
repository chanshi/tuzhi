<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 10:57
 */

namespace tuzhi\helper;

class Html
{

    /**
     * @param $tagName
     * @param null $content
     * @param array $option
     * @return string
     */
    public static function tag( $tagName , $content= null , $option = [] )
    {
        $attribute = [];

        foreach( $option as $name=>$value ){
            $attribute[] = $name.'="'.$value.'"';
        }

        $str = '<'.$tagName.' '.( $attribute ? implode(' ',$attribute) : '' ).'>';
        if( $content !==null ){
            $str .=$content.'</'.$tagName.'>';
        }
        return $str;
    }

    /**
     * @param $src
     * @param array $option
     * @return string
     */
    public static function link( $src , $option =[] )
    {
        return Html::tag('link',null,array_merge( $option ,[
            'href'=> $src,
            'rel'=>'stylesheet'
        ] ));
    }

    /**
     * @param $style
     * @return string
     */
    public static function style( $style )
    {
        return Html::tag('style',$style);
    }

    /**
     * @param $src
     * @param string $content
     * @param array $option
     * @return string
     */
    public static function script($src = null ,$content = '' ,$option = [])
    {
        if( $src ) {
            $option = array_merge($option, ['src'=>$src ,'type'=>'text/javascript'] );
        }

        return Html::tag('script', $content , $option );
    }

    /**
     * @param $content
     * @return mixed
     */
    public static function encode( $content )
    {
        return htmlspecialchars( $content );
    }


}