<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 23:54
 */

namespace tuzhi\nosql\redis;

use tuzhi\base\Object;
use tuzhi\nosql\redis\commands\Keys;

class Type extends Object
{
    /**
     * @var
     */
    public $redis;

    /**
     * @var
     */
    public $key;

    /**
     * @param $key
     * @return $this
     */
    public function setKey( $key )
    {
        $this->key = new Keys($key);
        return $this;
    }

}