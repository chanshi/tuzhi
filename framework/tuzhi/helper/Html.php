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
            if(is_numeric($name)){
                $attribute[] = $value;
            }else{
                $attribute[] = $name.'="'.$value.'"';
            }
        }

        $str = '<'.$tagName.( $attribute ? ' '.implode(' ',$attribute) : '' ).'>';
        if( $content !==null ){
            $str .=$content.'</'.$tagName.'>';
        }
        return $str;
    }

    public static function endTag( $tagName )
    {
        return '</'.$tagName.'>';
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

    /**
     * @param $data
     * @param null $current
     * @param array $option
     * @return string
     */
    public static function checkbox($data,$current=null,$option = [])
    {
        $checkbox = [];
        foreach ($data as $key=>$value)
        {
            $op = array_merge($option,['type'=>'checkbox','value'=>$key]);
            if(is_array($current)){
                if(in_array($key,$current)){
                    $op['checked']='true';
                }
            }else {
                if($current === $key){
                    $op['checked']='true';
                }
            }
            $checkbox[] = Html::tag('label',Html::tag('input',null,$op).$value);
        }

        return join("",$checkbox);
    }

    /**
     * 未注意 多选的情况
     *
     * @param $data
     * @param null $current
     * @param array $option
     * @return string
     */
    public static function select($data,$current=null,$option=[])
    {
        $options = [];
        foreach($data as $key => $value){
            $op =['value'=>$key];
            if( $current === $key ){
                $op[] = 'selected';
            }
            $options[] = Html::tag('option',$value,$op);
        }
        return Html::tag('select',join("\n",$options),$option);
    }

}