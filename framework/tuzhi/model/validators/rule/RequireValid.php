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
    /**
     * @var string
     */
    public $error = '请输入 {label}';

    /**
     * @return bool
     */
    protected function checkRequire()
    {
        if( $this->getAttribute() === null ){
            $this->addError();
            return false;
        }
        return  true;
    }

    /**
     * @return bool
     */
    public function verify()
    {
        return $this->checkRequire();
    }
}