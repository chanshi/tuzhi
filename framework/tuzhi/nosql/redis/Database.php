<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 23:04
 */

namespace tuzhi\nosql\redis;

use tuzhi\model\ArrayData;
use tuzhi\nosql\redis\Keys;

/**
 * Class Database
 * @package tuzhi\nosql\redis
 */
class Database extends ArrayData
{
    /**
     * @var
     */
    public $dbIndex;

    /**
     * @var
     */
    public $connection;

    /**
     * @var \Redis
     */
    public $redis;

    /**
     *
     */
    public function select()
    {
        $this->redis->select( $this->dbIndex );
        return $this;
    }

    /**
     * @param $patten
     * @return mixed
     */
    public function keys( $patten )
    {
        return $this->redis->keys($patten);
    }

    /**
     * @return mixed
     */
    public function allKeys()
    {
        return $this->redis->keys('*');
    }

    /**
     * @return int
     */
    public function size()
    {
        return $this->redis->dbSize();
    }

    /**
     * @return mixed  key  |  nil
     */
    public function randomKey()
    {
        return $this->redis->randomkey();
    }

    /**
     * @return bool
     */
    public function flush()
    {
        $this->data =[];
        return $this->redis->flushDB();
    }

    /**
     * @param $patten
     * @return int
     */
    public function clean( $patten )
    {
        return $this->redis->del( $this->keys($patten) );
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        if( ! isset($this->data[$key]) ){
            $this->data[$key] = new Keys(
                [
                    'key'=>$key,
                    'redis'=>$this->redis
                ]
            );
        }
        return parent::get($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function oString( $key )
    {
        $key = $this->get($key);
        return $key->String();
    }

    /**
     * @param $key
     */
    public function key( $key )
    {
        //return $this->get($key)->
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return new Transaction(['redis'=>$this->redis]);
    }

    /**
     * @param $key
     * @param $callback
     * @return mixed
     */
    public function transaction($key,$callback)
    {
        $transaction = $this->getTransaction();
        $transaction->begin($key);


            if( ! call_user_func_array($callback,[$this]) ){
                $transaction->rollback();
            }else{
                $transaction->commit();
            }


    }

}