<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 12:04
 */

namespace tuzhi\helper;

use Closure;

class Arr {

    public static function each( array $array ,Closure $closure ){
        //TODO  array_walk
        foreach( $array as $key=>$value){
            call_user_func_array( $closure,[$key,$value] );
        }
    }
}