<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/7
 * Time: 13:49
 */

namespace tuzhi\nosql\redis\commands;

use tuzhi\base\BObject;

/**
 * Class SetCmd
 * @package tuzhi\nosql\redis\commands
 */
class SetCmd extends BObject
{
    public $key;

    /**
     * @return \Redis
     */
    public function redis()
    {
        return $this->key->redis;
    }

    /**
     * @param $value
     * @return int
     */
    public function add($value)
    {
        return is_array($value)
            ? $this->redis()->sAddArray($this->key,$value)
            : $this->redis()->sAdd($this->key,$value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function remove( $value )
    {
        if(is_array($value)){
            array_unshift($value,$this->key);
        }else{
            $value = [$this->key,$value];
        }
        return call_user_func_array([$this->redis(),'sRem'],$value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function exists($value)
    {
        return $this->redis()->sIsMember($this->key,$value);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->redis()->sMembers($this->key);
    }

    /**
     * 集合数量 ?
     * @return int
     */
    public function count()
    {
        return $this->redis()->sCard($this->key);
    }

    /**
     * @return string
     */
    public function randomRemove()
    {
        return $this->redis()->sPop($this->key);
    }

    /**
     * @return string
     */
    public function random()
    {
        return $this->redis()->sRandMember($this->key);
    }

    /**
     * 交集
     * @param $sets
     * @param null $storeSetName
     * @return mixed
     */
    public function inter($sets,$storeSetName = null)
    {
        if(is_array($sets)){
            array_unshift($sets,$this->key);
        }else{
            $sets= [$this->key,$sets];
        }
        if($storeSetName){
            array_unshift($sets,$storeSetName);

            return call_user_func_array([$this->redis(),'sInterStore'],$sets);
        }else{
            return call_user_func_array([$this->redis(),'sInter'],$sets);
        }
    }

    /**
     * 合集
     * @param $sets
     * @param null $storeSetName
     * @return mixed
     */
    public function union($sets,$storeSetName = null)
    {
        if(is_array($sets)){
            array_unshift($sets,$this->key);
        }else{
            $sets= [$this->key,$sets];
        }
        if($storeSetName){
            array_unshift($sets,$storeSetName);

            return call_user_func_array([$this->redis(),'sUnionStore'],$sets);
        }else{
            return call_user_func_array([$this->redis(),'sUnion'],$sets);
        }
    }

    /**
     * 差集
     * @param $sets
     * @param null $storeSetName
     * @return mixed
     */
    public function diff($sets,$storeSetName =null)
    {
        if(is_array($sets)){
            array_unshift($sets,$this->key);
        }else{
            $sets= [$this->key,$sets];
        }
        if($storeSetName){
            array_unshift($sets,$storeSetName);

            return call_user_func_array([$this->redis(),'sDiffStore'],$sets);
        }else{
            return call_user_func_array([$this->redis(),'sDiff'],$sets);
        }
    }
}