<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/9
 * Time: 22:06
 */

namespace ts\tests\tests;

use tz\tests\FrameworkTest;

class TuzhiTest extends FrameworkTest
{
    public function testBase()
    {
        $this->assertEquals(1,1);
    }


    /**
     * 测试别名
     */
    public function testAlias()
    {
        $this->mockWebApp();
        $this->isEq(\Tuzhi::alias('&tuzhi'),TUZHI_PATH);
    }
}