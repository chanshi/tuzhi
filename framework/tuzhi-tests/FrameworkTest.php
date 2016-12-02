<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/9
 * Time: 21:56
 */

namespace tz\tests;

class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    

    protected function mockWebApp()
    {
        \Tuzhi::init( require __DIR__.'/data/config/config.php');
    }

    public function isEq($a,$b)
    {
        $this->assertEquals($a,$b);
    }
}