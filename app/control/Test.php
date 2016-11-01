<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:38
 */

namespace app\control;

use tuzhi\route\Controller;


/**
 * Class Test
 * @package app\control
 */
class Test extends Controller
{

    public function IndexAction()
    {
        $cache =  \Module::Test()->cache() ;
        $cache->set('ab','sss');
        return function(){
            echo \Module::Test()['cache']->get('ab');
        };
    }
}