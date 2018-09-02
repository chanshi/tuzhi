<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/8
 * Time: 11:11
 */

namespace tuzhi\cache\support;

use tuzhi\base\BObject;
use tuzhi\cache\CacheTrait;
use tuzhi\contracts\cache\ICache;
use tuzhi\nosql\redis\Database;

/**
 * Class Redis
 * @package tuzhi\cache\support
 */
class Redis extends BObject implements ICache
{
    /**
     *
     */
    use CacheTrait;

    /**
     * @var
     */
    public $server;

    /**
     * @var
     */
    public $connect = 'tuzhi\nosql\redis\Connection';

    /**
     * @var Database
     */
    protected $redis;

    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
        $this->redis = \Tuzhi::make(
            [
                'class'=>$this->connect,
                'redis'=>$this->server
            ]);

        $this->redis = $this->redis->getDb();
    }

    /**
     * @param $key
     * @param null $value
     * @param int $expiry
     * @return bool
     */
    public function set($key, $value = null, $expiry = 0)
    {
        $key = $this->getKey($key);
        $this->redis[$key]->Object()->set( $this->setContent( $value ) );
        $expiry && $this->redis[$key]->expire( $expiry );
        return true;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
         $data = $this->redis[$this->getKey($key)]->exists()
            ? $this->redis[$this->getKey($key)]->Object()->get()
            : null;
         return $this->getContent( $data );
    }

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->redis[$key]->del();
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return null
     */
    public function increment($key, $step = 1, $expiry = 0)
    {
        $this->redis[$this->getKey($key)]->Object()->increment($step);
        $expiry && $this->redis[$this->getKey($key)]->expire( $expiry );
        return $this->get($key);
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return null
     */
    public function decrement($key, $step = 1, $expiry = 0)
    {
        $this->redis[$this->getKey($key)]->Object()->decrement($step);
        $expiry && $this->redis[$this->getKey($key)]->expire( $expiry );
        return $this->get($key);
    }

    /**
     * @return mixed
     */
    public function flush()
    {
        return $this->redis->clean( $this->keyPrefix.'*' );
    }
}