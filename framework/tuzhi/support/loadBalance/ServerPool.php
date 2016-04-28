<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:57
 */

namespace tuzhi\support\loadBalance;

/**
 * Class ServerPool
 * @package tuzhi\support\loadBalance
 */
class ServerPool implements \Countable ,\IteratorAggregate ,\ArrayAccess
{

    /**
     * @var array
     */
    protected $pools = [];

    /**
     * @param $server
     * @return $this
     */
    public function addServer( $server )
    {
        $this->pools[] = $server;
        return $this;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count( $this->pools );
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->pools );
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset( $this->pools[$offset] );
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset( $this->pools[$offset] ) ? $this->pools[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->pools[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if( isset( $this->pools[$offset] )){
            unset( $this->pools[$offset] ) ;
        }
    }

}