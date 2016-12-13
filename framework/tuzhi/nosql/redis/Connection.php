<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 17:19
 */

namespace tuzhi\nosql\redis;


use tuzhi\base\Object;

/**
 * Class Connection
 * @package tuzhi\nosql\redis
 */
class Connection extends Object
{

    /**
     * @var
     */
    public $redis;

    /**
     * @var \Redis
     */
    protected $service;

    /**
     * @var array
     */
    protected $dbList = [];

    /**
     *
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->redis = new Server($this->redis);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->service instanceof \Redis && $this->service->ping()== 'PONG';
    }

    /**
     * @return \Redis
     * @throws \Exception
     */
    public function open()
    {
        if($this->isActive())  return $this->service;

        try {
            $this->service = new \Redis();
            if ($this->redis->pConnect) {
                $this->service->pconnect(
                    $this->redis->host,
                    $this->redis->port);
            } else {
                $this->service->connect(
                    $this->redis->host,
                    $this->redis->port
                );
            }
        }catch (\Exception $e){
            throw $e;
        }

        return $this->service;
    }

    /**
     * @return bool
     */
    public function close()
    {
        if( $this->service instanceof \Redis ){
            $this->service->close();
        }
        return true;
    }

    /**
     * Redis::getDb(0)->string('abc')->set('value');
     * Redis::getDb()['abc']->set('value');
     * @param int $dbIndex
     * @return Database
     */
    public function getDb($dbIndex = null)
    {
        $this->open();

        $dbIndex = $dbIndex === null
            ? $this->redis->dbIndex
            : $dbIndex;

        if( ! isset( $this->dbList[$dbIndex] ) ){
            $this->dbList[$dbIndex] = new Database(['dbIndex'=>$dbIndex,'redis'=>$this->service]);
        }
        $this->dbList[$dbIndex]
            ->select();
        return $this->dbList[$dbIndex];
    }

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return new Transaction(['redis'=>$this->getDb()]);
    }

    /**
     * @param $key
     * @param $callback
     * @return mixed
     */
    public function transaction($key,$callback)
    {
        $transaction = $this->getTransaction()->begin( $key );
        try{
            if( ! call_user_func($callback) ){
                $transaction->rollback();
            }
            return $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollback();
        }
    }

}