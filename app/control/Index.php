<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:46
 */

namespace app\control;

use Controller;

/**
 * 演示
 * 
 * Class Index
 * @package app\control
 */
class Index extends Controller
{

    public function IndexAction()
    {
        return 'This is Control: Hellow Wold;';
    }

    public function testAction()
    {
        return 'This is Test Control';
    }
}