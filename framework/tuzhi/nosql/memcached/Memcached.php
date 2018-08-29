<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 00:18
 */

namespace tuzhi\nosql\memcached;

use tuzhi\base\BObject;

class Memcached extends BObject
{
    /**
     * @var
     */
    public $memcached;

    /**
     * 设置值
     * @param $key
     * @param null $value
     * @param int $expiry
     * @return bool
     */
    public function set( $key , $value = null ,$expiry = 0 )
    {
        if( is_array($key) ){
            $this->memcached->setMulti( $key , $expiry );
        }else if( is_string($key) ){
            $this->memcached->set( $key ,$value ,$expiry );

        }

        return $this->isSuccess();
    }


    /**
     * 获取缓存
     * @param $key
     * @return null
     */
    public function get( $key )
    {
        $result = $this->memcached->get($key);
        if( $this->notFound() ){
            $result = null;
        }
        return $result;
    }

    /**
     * 删除字段
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        $this->memcached->delete($key);
        return $this->isSuccess();
    }

    /**
     * 清空所有
     *
     * @param int $delay
     * @return bool
     */
    public function flush($delay = 0)
    {
        $this->memcached->flush($delay);
        return $this->isSuccess();
    }


    /**
     * @param $key
     * @param int $step
     * @param int $init
     * @param int $expiry
     * @return mixed
     */
    public function increment( $key ,$step = 1 ,$init = 0,$expiry = 0)
    {
        return $this->memcached->increment($key,$step,$init,$expiry);
    }

    /**
     * @param $key
     * @param int $step
     * @param int $init
     * @param int $expiry
     * @return mixed
     */
    public function decrement( $key ,$step = 1 ,$init=0,$expiry = 0)
    {
        return $this->memcached->decrement($key,$step,$init,$expiry);
    }

    /**
     * @return bool
     */
    protected function isSuccess()
    {
        return $this->memcached->getResultCode() == \Memcached::RES_SUCCESS
            ? true
            : false;
    }

    protected function notFound()
    {
        return $this->memcached->getResultCode() == \Memcached::RES_NOTFOUND
            ? true
            : false;
    }
}