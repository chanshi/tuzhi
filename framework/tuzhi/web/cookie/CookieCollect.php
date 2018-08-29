<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:33
 */

namespace tuzhi\web\cookie;

use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\BObject;
use tuzhi\helper\Arr;

/**
 * Class CookieCollect
 * @package tuzhi\web\cookie
 */
class CookieCollect extends BObject implements \ArrayAccess ,\IteratorAggregate,\Countable
{
    /**
     * @var
     */
    protected  $cookies;

    /**
     * @var bool
     */
    public $readOnly = false;

    /**
     * CookieCollect constructor.
     * @param array $config
     */
    public function __construct(array $config =[])
    {
        parent::__construct($config);

        if( isset($config['_cookie']) ){
            $this->cookies = $config['_cookie'];
        }
    }

    /**
     * @param $name
     * @return null
     */
    public function get( $name )
    {
        return isset( $this->cookies[$name] )
            ? $this->cookies[$name]->value
            : null;
    }

    /**
     * @param $name
     * @param $cookie
     * @throws InvalidParamException
     */
    public function set($name ,$cookie)
    {
        if( $this->readOnly ){
            throw new InvalidParamException('The Cookie Collection is Read Only');
        }
        $this->cookies[$name] = $cookie;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has( $name )
    {
        return isset( $this->cookies[$name] ) && $this->cookies[$name]->value !== ''
            && $this->cookies[$name]->expire === null || $this->cookies[$name]->expire >= time();
    }

    /**
     * @param $cookie
     * @throws InvalidParamException
     */
    public function rm( $cookie )
    {
        if( $this->readOnly ){
            throw new InvalidParamException('The Cookie Collection is Read Only');
        }

        if( $cookie instanceof Cookie) {
            $cookie->expire = 1;
            $cookie->value = '';
        }else{
            //TODO:: 域名的问题
            $cookie = new Cookie(
                [
                    'name' => $cookie,
                    'expire' => 1,
                ]);
        }
        //
        $this->cookies[$cookie->name] = $cookie;
    }

    /**
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->set( $offset ,$value );
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        return $this->rm($offset);
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
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->cookies);
    }

    /**
     * @param $name
     * @param $cookie
     */
    public function __set( $name, $cookie )
    {
        return $this->set($name,$cookie);
    }

    /**
     * @param $name
     * @return null
     */
    public function __get( $name )
    {
        return $this->get( $name );
    }
}