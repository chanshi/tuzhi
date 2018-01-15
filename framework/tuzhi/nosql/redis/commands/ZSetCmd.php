<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/7
 * Time: 13:54
 */

namespace tuzhi\nosql\redis\commands;


use tuzhi\base\Object;

/**
 * Class ZSetCmd
 * @package tuzhi\nosql\redis\commands
 */
class ZSetCmd extends Object
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
     * @param $score
     * @param $member
     * @return int
     */
    public function add( $score ,$member )
    {
        return $this->redis()->zAdd($this->key,$score,$member);
    }

    /**
     * @param $member
     * @return mixed
     */
    public function remove($member)
    {
        if(is_array($member)){
            array_unshift($member,$this->key);
        }else{
            $member = [$this->key,$member];
        }
        return call_user_func_array([$this->redis(),'zRem'],$member);
    }

    /**
     * @return int
     */
    public function card()
    {
        return $this->redis()->zCard($this->key);
    }

    /**
     * @param $min
     * @param $max
     * @return int
     */
    public function count($min,$max)
    {
        return $this->redis()->zCount($this->key,$min,$max);
    }

    /**
     * @param $member
     * @return float
     */
    public function getScore($member)
    {
        return $this->redis()->zScore($this->key,$member);
    }

    /**
     * @param $member
     * @param int $increment
     * @return float
     */
    public function increment($member,$increment= 1)
    {
        return $this->redis()->zIncrBy($this->key,$increment,$member);
    }

    /**
     * 返回指定区间的成员  有小到大
     * @param $start
     * @param $stop
     * @return array
     */
    public function range($start,$stop)
    {
        return $this->redis()->zRange($this->key,$start,$stop,null);
    }

    /**
     * 返回指定区间的成员  有大到小
     * @param $start
     * @param $stop
     * @return array
     */
    public function reRange($start,$stop)
    {
        return $this->redis()->zRevRange($this->key,$start,$stop);
    }

    /**
     * @param $min
     * @param $max
     * @param null $offset
     * @param null $count
     * @return array
     */
    public function rangeByScore($min,$max,$offset=null,$count=null)
    {
        $option =[];
        if($offset && $count){
            $option['LIMIT'] =[$offset,$count];
        }

        return $this->redis()->zRangeByScore($this->key,$min,$max,$option);
    }

    /**
     * @param $min
     * @param $max
     * @param null $offset
     * @param null $count
     * @return array
     */
    public function reRangeByScore($min,$max,$offset=null,$count=null)
    {
        $option =[];
        if($offset && $count){
            $option['LIMIT'] =[$offset,$count];
        }
        return $this->redis()->zRevRangeByScore($this->key,$min,$max,$option);
    }

    /**
     * 有小到大
     * @param $member
     * @return int
     */
    public function rank($member)
    {
        return $this->redis()->zRank($this->key,$member);
    }

    /**
     * 由大到小
     * @param $member
     * @return int
     */
    public function reRank($member)
    {
        return $this->redis()->zRevRank($this->key,$member);
    }

    /**
     * @param $star
     * @param $stop
     * @return int
     */
    public function removeByRank($star,$stop)
    {
        return $this->redis()->zRemRangeByRank($this->key,$star,$stop);
    }

    /**
     * @param $min
     * @param $max
     * @return int
     */
    public function removeByScore($min,$max)
    {
        return $this->redis()->zRemRangeByScore($this->key,$min,$max);
    }

    /**
     * 交集
     * @param $out
     * @param $sets
     * @param $weights
     * @param $aggregate string     sum|min|max
     * @return  mixed
     */
    public function inter($out,$sets,$weights=null,$aggregate='SUM')
    {
        $sets= array_unshift($sets,$this->key);
        return $this->redis()->zInter($out,$sets,$weights,$aggregate);
    }

    /**
     * 合集
     * @param $out
     * @param $sets
     * @param null $weights
     * @param string $aggregate
     * @return mixed
     */
    public function union($out,$sets,$weights=null,$aggregate='SUM')
    {
        $sets= array_unshift($sets,$this->key);
        return $this->redis()->zUnion($out,$sets,$weights,$aggregate);
    }
}