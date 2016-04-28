<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:34
 */

namespace tuzhi\support\loadBalance;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;

/**
 * Class LoadBalance
 * @package tuzhi\support\loadBalances
 */
class LoadBalance extends Object
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

    public $server;

    /**
     * @var
     */
    protected $pool;

    
    /**
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function init()
    {
        $this->pool = new ServerPool();
        $this->dispatch = \Tuzhi::make(
            $this->support[ $this->setDispatch( $this->dispatch ) ],
            [$this->pool]
        );

        if( is_array($this->server) ){
            foreach( $this->server as $s ){
                $this->addServer($s);
            }
        }else{
            $this->addServer($this->server);
        }
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