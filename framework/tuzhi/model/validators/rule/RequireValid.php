<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/31
 * Time: 19:52
 */

namespace tuzhi\model\validators\rule;

use tuzhi\model\validators\Verify;

/**
 * Class RequireValid
 * @package tuzhi\model\validators\rule
 */
class RequireValid extends Verify
{

    public function verify()
    {
        return isset( $this->validator->model[$this->attribute] );
    }
}