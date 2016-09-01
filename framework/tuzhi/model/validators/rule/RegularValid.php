<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 11:03
 */

namespace tuzhi\model\validators\rule;

use tuzhi\model\validators\Verify;

/**
 * Class RegularValid
 * @package tuzhi\model\validators\rule
 */
class RegularValid extends Verify
{

    /**
     * @var
     */
    public $patten;

    /**
     * @var string
     */
    public $error = '{label} 不符合规定';

    /**
     * @return bool|int
     */
    protected function checkPatten()
    {
        if( $this->getAttribute() && $this->patten ){
            $status = preg_match($this->patten, $this->getAttribute());
            if( ! $status ){
                $this->addError();
            }
            return $status;
        }
        return true;
    }

    /**
     * @return bool|int
     */
    public function verify()
    {
        return $this->checkPatten();
    }
}