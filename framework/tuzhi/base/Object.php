<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:46
 */

namespace tuzhi\base;


class Object
{

    public function __configure(array $config = [])
    {
        if(!empty( $config )){
            \Tuzhi::config($this,$config);
        }
    }

    public static function getClassName()
    {
        return get_class( __CLASS__ );
    }
}