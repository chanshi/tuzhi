<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 11:43
 */

namespace tuzhi\cache\storage;


use tuzhi\contracts\cache\ICache;
use tuzhi\cache\CacheTrait;

class Memcached implements ICache
{

    use CacheTrait;

    /**
     * @var 
     */
    protected $memcached;

    public function init()
    {

    }

    /**
     * @param $key
     * @param null $value
     * @param int $expiry
     * @return mixed
     */
    public function set($key, $value = null, $expiry = 0)
    {
        return $this->memcached->set(
            $this->getKey($key),
            $this->setContent($value),
            $expiry == 0 ? 0 : time() + $expiry
        );
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->memcached->get(
            $this->getKey($key)
        );
    }

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->memcached->delete(
            $this->getKey($key)
        );
    }

    /**
     * @return mixed
     */
    public function flush()
    {
        return $this->memcached->flush();
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return mixed
     */
    public function increment($key, $step = 1,$expiry = 0)
    {
        return $this->memcached->increment(
            $this->getKey($key),
            $step,
            $expiry == 0 ? 0 : time() + $expiry
        );
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return mixed
     */
    public function decrement($key, $step = 1,$expiry = 0)
    {
        return $this->memcached->decrement(
            $this->getKey($key),
            $step,
            $expiry == 0 ? 0 : time() + $expiry
        );
    }
}