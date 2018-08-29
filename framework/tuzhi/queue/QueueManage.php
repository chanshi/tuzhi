<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/13
 * Time: 17:40
 */

namespace tuzhi\queue;

use tuzhi\base\BObject;

/**
 * Queue::Name()->push($job);
 * Class QueueManage
 * @package tuzhi\queue
 */
class QueueManage extends BObject
{

    protected $maps =
        [
            'redis' => '\tuzhi\queue\driver\RedisQueue'
        ];

    /**
     * @var array
     */
    protected $queue=[];

    /**
     * @var
     */
    public $config;

    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
        $this->initQueue();
    }

    /**
     * @return bool
     */
    public function initQueue()
    {
        foreach ($this->config as $config)
        {
            $config = array_merge($config,['class'=>$this->maps[ $config['driver'] ]]);
            $this->queue[ $config['queueName'] ] = \Tuzhi::make($config);
        }
        return true;
    }

    /**
     * @param $queueName
     * @return mixed
     */
    public function get( $queueName )
    {
        $queueName = strtolower($queueName);
        return $this->queue[$queueName];
    }


}