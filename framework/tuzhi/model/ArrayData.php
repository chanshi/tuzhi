<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/9
 * Time: 18:59
 */

namespace tuzhi\model;

use tuzhi\base\Object;
use tuzhi\helper\Json;

/**
 * Class ArrayData
 * @package tuzhi\model
 */
class ArrayData extends Object  implements \Countable ,\ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $data=[];


    /**
     * @param $key
     * @param $name
     * @return $this
     */
    public function set($key,$name)
    {
        $this->data[$key] = $name;
        return $this;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->data[$key])
            ? $this->data[$key]
            : null;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return in_array($offset,array_keys($this->data));
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return ArrayData
     */
    public function offsetSet($offset, $value)
    {
        return $this->set($offset,$value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
         unset( $this->data[$offset] );
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->data);
    }

    /**
     * @param $key
     * @param $value
     * @return ArrayData
     */
    public function __set($key,$value)
    {
        return $this->set($key,$value);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @return array
     */
    public function toArray() :array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return Json::encode($this->data);
    }
}