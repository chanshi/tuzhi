<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:46
 */

namespace app\control;


use tuzhi\route\Control;

/**
 * 演示
 * 
 * Class Index
 * @package app\control
 */
class Index extends Control
{
    public $middleWare = [];

    public function IndexAction()
    {
        return 'This is Control: Hellow Wold;';
    }
}