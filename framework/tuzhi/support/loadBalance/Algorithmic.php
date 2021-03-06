<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 22:45
 */

namespace tuzhi\support\loadBalance;

use tuzhi\base\BObject;

/**
 * Class Algorithmic
 * @package tuzhi\support\loadBalance
 */
abstract class Algorithmic extends BObject
{

    /**
     * @var
     */
    public $pool;

    /**
     * @return mixed
     */
    protected function count()
    {
        return $this->pool->count();
    }

    /**
     * @return mixed
     */
    abstract public function getServer();
}