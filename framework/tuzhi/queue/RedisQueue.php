<?php
/**
 * Created by PhpStorm.
 * User: Smith
 * Date: 2016/12/7
 * Time: 16:24
 */

namespace tuzhi\queue;


use tuzhi\contracts\queue\IQueue;
use tuzhi\helper\Json;

/**
 * Class RedisQueue
 * @package tuzhi\queue
 */
class RedisQueue extends Queue implements IQueue
{
    /**
     * @var
     */
    protected $redis;

    /**
     * init
     */
    public function init()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    /**
     * @param $job
     * @param null $data
     * @param null $queue
     * @param array $options
     * @return mixed
     */
    public function push($job, $data = null, $queue = null, $options = [])
    {
        $payload = $this->createPayload($job, $data);
        $this->redis->rpush($this->getQueue($queue), $payload);
        $payload = Json::decode($payload);
        return $payload['id'];
    }

    /**
     * @param $queue
     * @return null
     */
    public function pop($queue = null)
    {
        $payload = $this->redis->lpop($this->getQueue($queue));
        return $payload ?: null;
    }



}