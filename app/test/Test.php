<?php

/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/30
 * Time: 20:58
 */

class myTest extends PHPUnit_Framework_TestCase
{
    public function testPush(){
        $stack = array();
        $this->assertEquals(0,count($stack));
    }
}
