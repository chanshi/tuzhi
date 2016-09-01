<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 10:54
 */

namespace tuzhi\model\validators\rule;

use tuzhi\model\validators\Verify;

/**
 * Class CompareValid
 * @package tuzhi\model\validators\rule
 */
class CompareValid extends Verify
{
    /**
     * @var
     */
    public $type = 'string';

    /**
     * @var
     */
    public $op = '==';

    /**
     * @var
     */
    public $value;

    /**
     * @var
     */
    public $opAttribute;

    /**
     *
     */
    public function verify()
    {
        // TODO: Implement verify() method.
    }
}