<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/7
 * Time: 01:03
 */

namespace tuzhi\nosql\redis\commands;

use tuzhi\base\Object;

/**
 * Class ListCmd
 * @package tuzhi\nosql\redis\commands
 */
class ListCmd extends Object
{

    public $key;

    /**
     * @return \Redis
     */
    protected function redis()
    {
        return $this->key->redis;
    }

    /**
     * @param $value
     * @param bool $overWrite
     * @return mixed
     */
    public function lPush( $value ,$overWrite = true)
    {
        if( is_array($value) ) {
            array_unshift($value,$this->key);
        }else{
            $value = [$this->key,$value];
        }

        return $overWrite
            ? call_user_func_array([$this->redis(),'lPush'],$value)
            : call_user_func_array([$this->redis(),'lPushx'],$value);
    }

    /**
     * @param $value
     * @param $overWrite
     * @return mixed
     */
    public function rPush($value,$overWrite)
    {
        if( is_array($value) ) {
            array_unshift($value,$this->key);
        }else{
            $value = [$this->key,$value];
        }

        return $overWrite
            ? call_user_func_array([$this->redis(),'rPush'],$value)
            : call_user_func_array([$this->redis(),'rPushx'],$value);
    }

    /**
     * @return string
     */
    public function lPop()
    {
        return $this->redis()->lPop($this->key);
    }

    /**
     * @return string
     */
    public function rPop()
    {
        return $this->redis()->rPop($this->key);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->redis()->lLen($this->key);
    }

    /**
     * @param $start
     * @param $stop
     * @return array
     */
    public function range( $start ,$stop )
    {
        return $this->redis()->lRange($this->key,$start,$stop);
    }

    /**
     * @param $value
     * @param int $count
     */
    public function remove($value ,$count = 0)
    {
        //TODO:: lRem
        return $this->redis()->lRemove($this->key,$count,$value);
    }

    /**
     * 替换下标 index
     *
     * @param $index
     * @param $value
     * @return bool
     */
    public function replace($index,$value)
    {
        return $this->redis()->lSet($this->key,$index,$value);
    }

    /**
     * 裁剪 删除区域外值
     * @param $start
     * @param $stop
     * @return array
     */
    public function splice($start ,$stop)
    {
        return $this->redis()->lTrim($this->key,$start,$stop);
    }

    /**
     * @param $index
     * @return String
     */
    public function item($index)
    {
        return $this->redis()->lIndex($this->key,$index);
    }

    const POSITION_BEFORE =1;
    const POSITION_AFTER = 2;

    /**
     * 在某个值 前 或者后插入 一个值
     * @param $pivot
     * @param $value
     * @param int $position
     * @return int
     */
    public function insert($pivot,$value,$position = 1)
    {
        return $this->redis()->lInsert($this->key,$position,$pivot,$value);
    }
}