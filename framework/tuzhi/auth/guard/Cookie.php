<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 16:29
 */

namespace tuzhi\auth\guard;

use tuzhi\auth\Guard;

class Cookie extends Guard
{
    protected $cookie;

    protected $recalledName;

    public function user()
    {
        if( $this->user ){
            return $this->user;
        }

    }
}