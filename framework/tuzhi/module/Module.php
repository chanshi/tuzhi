<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/1
 * Time: 17:58
 */

namespace tuzhi\module;


use tuzhi\base\Object;


/**
 * Class Module
 * @package tuzhi\module
 */
class Module extends Object implements \ArrayAccess
{
    /**
     * @var
     */
    public $name ;

    /**
     * @var
     */
    public $services;


    public $dependServices;
    public $dependModule;
    public $lastModifyTime;
    public $auth;
    public $describes;

    /**
     * @var
     */
    protected $registered =[];

    public function init()
    {
        $this->registerServers();
    }

    /**
     * @return bool
     */
    public function registerServers()
    {
        foreach( $this->services as $name=>$definition ) {
            $this->registerServer($name,$definition);
        }
        return true;
    }

    /**
     * @param $name
     * @param $definition
     */
    protected function registerServer($name,$definition)
    {
        $name = strtolower($name);
        $this->registered[$name] = \Tuzhi::App()->register(
            $this->getServerName($name),
            $definition
        );
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getServer( $name )
    {
        if( ! isset( $this->registered[$name] ) ){
            $this->registered[$name] = \Tuzhi::App()->get( $this->getServerName($name) );
        }
        return $this->registered[$name];
    }

    /**
     * @param $serviceName
     * @return string
     */
    protected function getServerName( $serviceName )
    {
        return join(
            '.',
            [
                'module',
                $this->name,
                $serviceName
            ]
        );

    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->services[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getServer($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->registerServer($offset,$value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->registered[$offset],$this->services[$offset]);
    }

    /**
     * @param $name
     * @param $definition
     */
    public function __set($name,$definition)
    {
        return $this->registerServer($name,$definition);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getServer($name);
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call( $name ,$args )
    {
        return $this->getServer($name);
    }
}