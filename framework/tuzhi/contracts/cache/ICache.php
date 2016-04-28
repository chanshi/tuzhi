<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 11:52
 */

namespace tuzhi\contracts\cache;

/**
 * Interface ICache
 * @package tuzhi\contracts\cache
 */
interface ICache
{
    /**
     * @param $key
     * @param null $value
     * @param int $expiry
     * @return mixed
     */
    public function set($key , $value = null ,$expiry = 0);

    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @return mixed
     */
    public function delete($key);

    /**
     * @return mixed
     */
    public function flush();

    /**
     * @param $key
     * @param int $step
     * @return mixed
     */
    public function increment($key , $step = 1,$expiry = 0);

    /**
     * @param $key
     * @param int $step
     * @return mixed
     */
    public function decrement($key , $step = 1,$expiry = 0);
}