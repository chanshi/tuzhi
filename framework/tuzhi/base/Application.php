<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:43
 */

namespace tuzhi\base;


use tuzhi\contracts\base\IApplication;

class Application extends Object implements IApplication
{


    public function __construct( $config = []){
        parent::__configure ( $config );

    }

    public function run(){}
}