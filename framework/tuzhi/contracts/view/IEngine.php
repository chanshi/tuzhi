<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 11:03
 */

namespace tuzhi\contracts\view;


interface IEngine
{
    public function render( $file ,$param = [] );
}