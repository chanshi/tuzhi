<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/26
 * Time: 22:31
 */

namespace tuzhi\nosql\memcached;


use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;
use tuzhi\helper\Arr;

class Connection extends Object
{

    /**
     * @var
     */
    public $memcached;

    /**
     * @var
     */
    public $server;

    /**
     * @var
     */
    public $option =
        [
            [ \Memcached::OPT_BINARY_PROTOCOL , TRUE ]
        ];

    /**
     * @var string
     */
    public $command = 'tuzhi\nosql\memcached\Memcached';

    /**
     * @var string
     */
    protected $memcachedClass = 'Memcached';

    /**
     * @var array
     */
    protected $persistentId = [];


    /**
     *
     */
    public function init()
    {
        if( $this->server ){
            $server = [];
            if( !Arr::isAssoc( $this->server ) ){
                foreach( $this->server as $item ){
                    $ser = new Server($item);
                    $this->persistentId[] = $ser->getId();
                    array_push($server,$ser);
                }
            }else{
                $ser = new Server($this->server);
                $this->persistentId[] = $ser->getId();
                array_push($server,$ser);
            }

            $this->server = $server;
        }
    }

    /**
     * @return array|null
     */
    protected function getPersistent()
    {
        $persistent = $this->persistentId;
        if( empty($persistent) ){
            return null;
        }
        if( is_array( $persistent ) ){
            sort($persistent);
            $this->persistentId = md5( join('.',$persistent) );
        }
        return $this->persistentId;
    }

    /**
     * @return bool
     * @throws InvalidParamException
     */
    protected function open()
    {
        if( $this->memcached ){
            return true;
        }

        try{

            $memcached = new $this->memcachedClass( $this->getPersistent() );

            // 配置参数
            foreach($this->option as $option){
                call_user_func_array([$memcached,'setOption'],$option);
            }
            // 添加服务器
            foreach( $this->server as $server ){
                call_user_func_array( [$memcached,'addServer'] ,$server->getArray() );
            }
            // 如果未设置 则使用默认服务器
            if( ! $memcached ){
                throw new \Exception('Cant Create Memcached');
            }
            $this->memcached = $memcached;

        }catch(\Exception $e){
            throw new InvalidParamException('Not Create Memcached Servers ');
        }
    }

    /**
     * @return mixed
     */
    public function getMemcached()
    {
        if( $this->memcached == null ){
            $this->open();
        }
        if( $this->memcached instanceof $this->memcachedClass){
            return $this->memcached;
        }
        return null;
    }

    /**
     * @return mixed|string
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function getCommand()
    {
        if( is_string($this->command) ){
            $command = \Tuzhi::make(
                [
                    'class' => $this->command,
                    'memcached' =>$this->getMemcached()
                ]
            );
            $this->command = $command;
        }
        return $this->command;
    }


    /**
     * 关闭实例
     */
    public function close()
    {
        if( $this->memcached instanceof $this->memcachedClass){
            $this->memcached->quit();
        }
        $this->memcached = null;
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->close();
    }
}