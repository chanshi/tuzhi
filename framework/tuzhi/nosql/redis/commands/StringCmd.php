<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/7
 * Time: 00:25
 */
namespace tuzhi\nosql\redis\commands;


use tuzhi\base\Object;

/**
 * Class StringCmd
 * @package tuzhi\nosql\redis\commands
 */
class StringCmd extends  Object
{
    /**
     * @var Keys
     */
    public $key;

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->redis()->get( $this->key );
    }

    /**
     * @param $value
     * @param bool $overWrite
     * @return bool
     */
    public function set( $value ,$overWrite = false )
    {
        return $overWrite
            ? $this->redis()->set($this->key,$value)
            : $this->redis()->setnx($this->key,$value);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->redis()->strlen($this->key);
    }

    /**
     * @param $offset
     * @param $replaceStr
     * @return string
     */
    public function setRange($offset, $replaceStr )
    {
        return $this->redis()->setRange($this->key,$offset,$replaceStr);
    }

    /**
     * @param $start
     * @param $end
     * @return string
     */
    public function getRange($start ,$end)
    {
        return $this->redis()->getRange($this->key,$start,$end);
    }

    /**
     * @param $newString
     * @return string
     */
    public function replace($newString)
    {
        return $this->redis()->getSet($this->key,$newString);
    }

    /**
     * @param $string
     * @return int
     */
    public function append( $string )
    {
        return $this->redis()->append($this->key,$string);
    }

    /**
     * @param int $increment
     * @return int
     */
    public function increment($increment = 1)
    {
        return $this->redis()->incrBy($this->key,$increment);
    }

    /**
     * @param int $decrement
     * @return int
     */
    public function decrement($decrement =1)
    {
        return $this->redis()->decrBy($this->key,$decrement);
    }

    /**
     * @return \Redis
     */
    protected function redis()
    {
        return $this->key->redis;
    }


}