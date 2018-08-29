<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:34
 */

namespace tuzhi\support\loadBalance;

use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\BObject;

/**
 * Class LoadBalance
 * @package tuzhi\support\loadBalances
 */
class LoadBalance extends BObject
{

    /**
     * @var array
     */
    protected $support =
        [
            'hash'=>'tuzhi\support\loadBalance\algorithmic\Hash',
            'round'=>'tuzhi\support\loadBalance\algorithmic\Round',
            'weight'=>'tuzhi\support\loadBalance\algorithmic\Weight'
        ];

    /**
     * @var string  默认轮训
     */
    public $dispatch = 'round';

    /**
     * @var
     */
    public $server;

    /**
     * @var ServerPool
     */
    protected $pool;

    
    /**
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function init()
    {
        $this->pool = new ServerPool();

        if( is_array($this->server) ){
            foreach( $this->server as $s ){
                $this->addServer($s);
            }
        }else{
            $this->addServer($this->server);
        }

        $this->dispatch = \Tuzhi::make(
            [
                'class' => $this->support[ $this->setDispatch( $this->dispatch ) ],
                'pool'  => $this->pool
            ]
        );
    }

    /**
     *
     * @param $dispatch
     * @return string
     */
    public function setDispatch( $dispatch )
    {
        $dispatch = strtolower( $dispatch );
        if( array_key_exists($dispatch ,$this->support) ){
            $this->dispatch = $dispatch;
        }else{
            $this->dispatch = 'round';
        }
        return $this->dispatch;
    }

    /**
     * @param $server
     * @param array $option
     * @throws InvalidParamException
     */
    public function addServer( $server ,$option =[] )
    {
        //TODO:: 此处规则的处理 不应该交给 底层处理
        if( is_array($server) ){
            $instance = array_shift($server);
            $config = array_merge($server,$option);
        }else if( is_string($server) ){
            $instance = $server;
            $config = $option;
        }else{
            throw new InvalidParamException('Invalid Param in LoadBalance the Param is '.$server.' ');
        }
        $this->pool->addServer(new Server($instance ,$config) );
    }

    /**
     * @return bool
     */
    public function removeServer()
    {
        //TODO::
        return false;
    }

    /**
     *
     * @return mixed
     */
    public function loop()
    {
        //TODO:: 当 池 发生变化的时候 调度也要相应的发生变化

        return $this->dispatch->getServer();
    }

    /**
     * @return mixed
     */
    public function getPool()
    {
        return $this->pool;
    }
}