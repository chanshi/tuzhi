<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/6
 * Time: 17:22
 */

namespace tuzhi\support\monitor\memcached;

/**
 * 采集数据
 * Class Memcached
 * @package tuzhi\support\monitor\memcached
 */
class Memcached
{
    private $data;

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function threads()
    {
        return $this->data['threads'];
    }

    public function startTime(){}

    public function upTime(){}

    public function usedSize(){}

    public function totalSize(){}

    public function usedItem(){
        return $this->data['curr_items'];
    }

    public function totalItem(){
        return $this->data['total_items'];
    }

    public function currConnect(){

    }

    public function totalConnect(){

    }

    public function totalHits(){}

    public function totalMiss(){}

    public function hitRate(){}

    public function missRate(){}

    public function setRate(){}

    public function RequestRate(){}

}