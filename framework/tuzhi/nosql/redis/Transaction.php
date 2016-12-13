<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 23:05
 */

namespace tuzhi\nosql\redis;


use tuzhi\base\Object;

/**
 * Class Transaction
 * @package tuzhi\nosql\redis
 */
class Transaction extends Object
{
    /**
     * @var \Redis
     */
    public $redis;

    /**
     * @param $key
     */
    public function begin( $key )
    {
        $this->redis->watch( $key );
        $this->redis->multi();
    }

    /**
     * @return mixed
     */
    public function commit()
    {
        return $this->redis->exec();
    }

    /**
     * @return mixed
     */
    public function rollback()
    {
        return $this->redis->discard();
    }
}