<?php

namespace tuzhi\queue;

use \tuzhi\base\Object;

/**
 * Class Queue
 * @package tuzhi\queue
 */
class Queue extends Object
{
    /**
     * @var
     */
    public $queueName;

    /**
     * @var
     */
    public $driver;

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->queueName = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->queueName;
    }

    /**
     * @param $job
     * @return string
     */
    protected function createPayload( $job )
    {
        $Payload = new Payload();
        $Payload['job'] = $job;
        return $Payload->toEncode();
    }

    /**
     * @param $payload
     * @return mixed
     */
    protected function getMetaId($payload)
    {
        return Payload::decode($payload)['id'];
    }

    /**
     * @param $payload
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function setMeta($payload,$key,$value)
    {
        $Payload = Payload::decode($payload);
        $Payload[$key]=$value;
        return $Payload->toEncode();
    }

    /**
     * @return int
     */
    protected function getTime()
    {
        return time();
    }


}