<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 15:01
 */

namespace tuzhi\route;

/**
 * Class Route
 * @package tuzhi\route
 */
class Route
{
    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $patten;

    /**
     * @var array
     */
    public $method = [];

    /**
     * @var
     */
    public $action;

    /**
     * @var
     */
    public $cache;

    /**
     * @var
     */
    public $params;

    /**
     * @var
     */
    public $advance = [];

    /**
     * Route constructor.
     * @param $method
     * @param $patten
     * @param $action
     */
    public function __construct($method,$patten,$action)
    {
        $this->setMethod($method);
        $this->setPatten($patten);
        $this->setAction($action);
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod( $method )
    {
        if( is_array($method) ){
            $this->method = array_merge($this->method,$method);
        }else{
            array_push($this->method, strtoupper( $method ) );
        }
        return $this;
    }

    /**
     * @param $method
     * @return Route
     */
    public function andMethod( $method )
    {
        return $this->setMethod($method);
    }

    /**
     * @param $option
     * @return $this
     */
    public function andCache( $option )
    {
        $this->cache = $option;
        return $this;
    }

    /**
     * @param $patten
     * @return $this
     */
    public function setPatten( $patten )
    {
        $this->patten = new Patten($patten);
        return $this;
    }

    /**
     * @param $action
     * @return $this
     */
    public function setAction( $action )
    {
        $this->action = $action;
        return $this;
    }

    /**
     * 
     * @return mixed
     */
    public function getName()
    {
        if( $this->name == null){
            $this->name = sha1(  $this->patten  . serialize( $this->method ) );
        }
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        if( is_string( $this->action ) &&  preg_match('#<\w+>#i',$this->action) ){
            $match = $this->getMatch();
            $patten = array_map(function($value){ return '#<'.$value.'>#';} ,array_keys( $match ));
            $this->action = preg_replace($patten,array_values($match),$this->action);
        }
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getMatch()
    {
        return  $this->patten->getMatchValue();
    }

    /**
     * 匹配方法
     *
     * @param $method
     * @return bool
     */
    public function matchMethod ( $method )
    {
        if( in_array('ALL',$this->method) ){
            return true;
        }else{
            return in_array( strtoupper( $method ) , $this->method )
                ? true
                : false;
        }
    }

    /**
     * 匹配路径
     *
     * @param $patten
     */
    public function matchPatten ( $patten ){
        return $this->patten->match( $patten );
    }


}