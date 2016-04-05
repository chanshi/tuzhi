<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:33
 */

namespace tuzhi\web\cookie;


use tuzhi\helper\Arr;

class CookieCollect implements \ArrayAccess ,\IteratorAggregate,\Countable
{
    /**
     * @var
     */
    protected  $cookies;

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * CookieCollect constructor.
     */
    private function __construct()
    {
        $this->init();
    }

    /**
     * 单例模式
     * @return null
     */
    public static function getInstance(){
        if( ! static::$instance ){
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     *
     * @return null
     */
    protected function init()
    {
        // TODO: 初始化 加载 COOKIE
        Arr::each($_COOKIE,function($key,$value) use($this){
            $this->offsetSet($key,$value);
        });
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        return isset( $this->cookies[$offset] ) ? $this->cookies[$offset]->value : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if(isset($this->cookies[$offset])){
            $this->cookies[$offset]->value = $value;
        }else{
            $this->cookies[$offset] = new Cookie($offset,$value);
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if(isset($this->cookies[$offset])){
            $this->cookies[$offset]->value  = null;
            $this->cookies[$offset]->expire = -1;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset( $this->cookies[$offset] );
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->cookies);
    }

    /**
     * 保存
     */
    public function save(){
        foreach(static::getIterator() as $cookie){
            setcookie(
                $cookie->name,
                $cookie->value,
                $cookie->expire,
                $cookie->path,
                $cookie->domian,
                $cookie->secure,
                $cookie->httponly
            );
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this);
    }
}