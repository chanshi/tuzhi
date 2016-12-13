<?php

namespace tuzhi\queue;

use \tuzhi\base\Object;
use \tuzhi\contracts\queue\IQueue;
use \tuzhi\helper\Json;
use tuzhi\helper\Str;

/**
 * Class Queue
 * @package tuzhi\queue
 */
abstract class Queue extends Object
{
    /**
     * @var int
     */
    protected $prefix = 'queue';

    /**
     * @param $name
     * @return string
     */
    public function buildPrefix($name)
    {
        if (empty($name)) {
            $name = 'default';
        } else {
            $name = md5($name);
        }
        return $this->prefix . ":" . $name;
    }

    /**
     * @param $job
     * @param $data
     * @return string
     */
    protected function createPayload($job, $data)
    {
        return $this->setMeta([
            'job' => $job,
            'data' => $data
        ], 'id', $this->getRandomId());
    }

    /**
     * @param $queue
     * @return string
     */
    protected function getQueue($queue)
    {
        return $this->buildPrefix($queue);
    }

    /**
     * @return string
     */
    protected function getRandomId()
    {
        return Str::random(32);
    }

    /**
     * @param $payload
     * @param $key
     * @param $value
     * @return string
     */
    protected function setMeta($payload, $key, $value)
    {
        $payload[$key] = $value;
        return Json::encode($payload);
    }

    /**
     * @param $job
     * @param null $data
     * @param null $queue
     * @param array $options
     * @return mixed
     */
    abstract public function push($job, $data = null, $queue = null, $options = []);

    /**
     * @param $queue
     * @return mixed
     */
    abstract public function pop($queue);

}