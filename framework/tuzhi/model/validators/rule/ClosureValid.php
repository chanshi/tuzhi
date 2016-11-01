<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 17:49
 */

namespace tuzhi\model\validators\rule;

use tuzhi\model\validators\Verify;

/**
 * Class ClosureValid
 * @package tuzhi\model\validators\rule
 */
class ClosureValid extends Verify
{

    /**
     * @var
     */
    public $closure;

    /**
     * @return bool|mixed
     */
    protected function checkClosure()
    {

        if( ($value = $this->getAttribute()) !== null ){
            $status = call_user_func($this->closure,$this);
            if($status == false){
                $this->addError();
            }
            return $status;
        }
        return true;
    }

    /**
     * @return bool|mixed
     */
    public function verify()
    {
        return $this->checkClosure();
    }
}