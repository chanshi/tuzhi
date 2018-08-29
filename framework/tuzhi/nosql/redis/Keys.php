<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 17:48
 */

namespace tuzhi\nosql\redis;

use tuzhi\base\BObject;
use tuzhi\nosql\redis\commands\HashCmd;
use tuzhi\nosql\redis\commands\ListCmd;
use tuzhi\nosql\redis\commands\SetCmd;
use tuzhi\nosql\redis\commands\StringCmd;
use tuzhi\nosql\redis\commands\ZSetCmd;

/**
 * Class KeysTrait
 * @package tuzhi\nosql\redis\commands
 */
class Keys extends BObject
{

    /**
     * 0  NONE
     * 1  STRING
     * 2  SET
     * 3  LIST
     * 4  ZSET
     * 5  HASH
     */
    const TYPE_NONE   = 0;
    const TYPE_STRING = 1;
    const TYPE_SET    = 2;
    const TYPE_LIST   = 3;
    const TYPE_ZSET   = 4;
    const TYPE_HASH   = 5;


    protected $typeString =
        [
            0 => 'none',
            1 => 'string',
            2 => 'set',
            3 => 'list',
            4 => 'zset',
            5 => 'hash'
        ];


    public $key;
    /**
     * @var \Redis
     */
    public $redis;

    /**
     * @var
     */
    protected $command;


    /**
     * @return bool
     */
    public function exists()
    {
        return $this->redis->exists($this->key) ? true : false;
    }

    /**
     * @return bool
     */
    public function del()
    {
        return  $this->redis->del($this->key) == true;
    }


    /**
     * @return int
     */
    public function ttl()
    {
        return $this->redis->ttl($this->key);
    }


    /**
     * @param $newKey
     * @param bool $force
     * @return bool
     */
    public function rename($newKey,$force = true)
    {
        if( ! $this->exists() ) return false;
        return $force
            ? $this->redis->rename($this->key,$newKey)
            : $this->redis->renamex($this->key,$newKey);

    }


    /**
     * @param $seconds
     * @return bool
     */
    public function expire( $seconds )
    {
        return $this->redis->expire($this->key,$seconds);
    }

    /**
     * @return bool
     */
    public function persist()
    {
        return $this->redis->persist($this->key);
    }

    /**
     * @param $dbIndex
     * @return bool
     */
    public function move( $dbIndex )
    {
        return $this->redis->move($this->key,$dbIndex);
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->redis->type($this->key);
    }

    /**
     * @return mixed
     */
    public function typeToString()
    {
        return $this->typeString[$this->type()];
    }

    /**
     * @return bool
     */
    public function isString()
    {
        return $this->type() === Keys::TYPE_STRING;
    }

    /**
     * @return bool
     */
    public function isSet()
    {
        return $this->type() === Keys::TYPE_SET;
    }

    /**
     * @return bool
     */
    public function isList()
    {
        return $this->type() === Keys::TYPE_LIST;
    }

    /**
     * @return bool
     */
    public function isZset()
    {
        return $this->type() === Keys::TYPE_ZSET;
    }

    /**
     * @return bool
     */
    public function isHash()
    {
        return $this->type() === Keys::TYPE_HASH;
    }

    /**
     * @return string
     */
    public function getRefcount()
    {
        return $this->redis->object('REFCOUNT',$this->key);
    }

    /**
     * @return StringCmd
     */
    public function String()
    {
        if(! ( $this->command instanceof  StringCmd ) ){
            $this->command = new StringCmd(['key'=>$this]);
        }
        return $this->command;
    }

    /**
     * @return SetCmd
     */
    public function Set()
    {
        if( !( $this->command instanceof SetCmd ) ){
            $this->command = new SetCmd(['key'=>$this]);
        }
        return $this->command;
    }

    /**
     * @return ListCmd
     */
    public function List()
    {
        if( ! $this->command instanceof ListCmd){
            $this->command = new ListCmd(['key'=>$this]);
        }
        return $this->command;
    }

    /**
     * @return HashCmd
     */
    public function Hash()
    {
        if( ! $this->command instanceof  HashCmd){
            $this->command = new HashCmd(['key'=>$this]);
        }
        return $this->command;
    }

    /**
     * @return ZSetCmd
     */
    public function ZSet()
    {
        if( ! $this->command instanceof  ZSetCmd){
            $this->command = new ZSetCmd(['key'=>$this]);
        }
        return $this->command;
    }

    /**
     * @return null|HashCmd|ListCmd|SetCmd|StringCmd|ZSetCmd
     */
    public function Object()
    {
        $Object = null;
        switch ( $this->type() ){

            case Keys::TYPE_NONE  :
            case Keys::TYPE_STRING :
            default :
                $Object = $this->String();
                break;
            case Keys::TYPE_SET :
                $Object = $this->Set();
                break;
            case Keys::TYPE_LIST :
                $Object = $this->List();
                break;
            case Keys::TYPE_ZSET :
                $Object = $this->ZSet();
                break;
            case Keys::TYPE_HASH :
                $Object = $this->Hash();
                break;
        }
        return $Object;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->key;
    }

}