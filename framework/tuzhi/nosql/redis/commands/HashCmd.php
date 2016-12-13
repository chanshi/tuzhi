<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/7
 * Time: 00:45
 */

namespace tuzhi\nosql\redis\commands;

use tuzhi\base\Object;

/**
 * Class HashCmd
 * @package tuzhi\nosql\redis\commands
 */
class HashCmd extends Object
{
    /**
     * @var
     */
    public $key;

    /**
     * @param $field
     * @param $value
     * @param bool $overWrite
     * @return bool|int
     */
    public function set($field,$value = null,$overWrite = true)
    {
        if(is_array($field)){
            return $this->redis()->hMset($this->key,$field);
        }else{
            return $overWrite
                ? $this->redis()->hSet($this->key,$field,$value)
                : $this->redis()->hSetNx($this->key,$field,$value);
        }
    }

    /**
     * @param $field
     * @return array|string
     */
    public function get($field)
    {
        return is_array($field)
            ? $this->redis()->hMGet($this->key,$field)
            : $this->redis()->hGet($this->key,$field);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->redis()->hGetAll($this->key);
    }

    /**
     * @return array
     */
    public function keys()
    {
        return $this->redis()->hKeys($this->key);
    }

    /**
     * @return array
     */
    public function vals()
    {
        return $this->redis()->hVals($this->key);
    }

    /**
     * @param $field
     * @param int $increment
     * @return int
     */
    public function increment( $field,$increment =1 )
    {
        return $this->redis()->hIncrBy($this->key,$field,$increment);
    }

    /**
     * @return mixed
     */
    public function del()
    {
        $args = func_get_args();
        array_unshift($args,$this->key);
        return call_user_func_array([$this->redis(),'hDel'],$args);
    }

    /**
     * @param $field
     * @return bool
     */
    public function exists($field)
    {
        return $this->redis()->hExists($this->key,$field);
    }

    /**
     * @return int
     */
    public function length()
    {
        return $this->redis()->hLen( $this->key);
    }

    /**
     * @return \Redis
     */
    protected function redis()
    {
        return $this->key->redis;
    }
}