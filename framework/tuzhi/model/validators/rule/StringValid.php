<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 10:59
 */

namespace tuzhi\model\validators\rule;


use tuzhi\model\validators\Verify;

class StringValid extends Verify
{

    public $length;

    public $min = 0;

    public $max = 128;

    public $hasChinese = 'true';




    public function verify()
    {
        // TODO: Implement verify() method.
    }
}