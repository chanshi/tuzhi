<?php

/**
 * Created by PhpStorm.
 * User: Smith
 * Date: 2016/12/6
 * Time: 15:42
 */
namespace tuzhi\contracts\queue;

/**
 * Interface IQueue
 * @package tuzhi\contracts\queue
 */
interface IQueue
{
    /**
     * @param $job
     * @param null $data
     * @param null $queue
     * @param array $options
     * @return mixed
     */
    public function push($job, $data = null, $queue = null, $options = []);

    /**
     * @param $queue
     * @return mixed
     */
    public function pop($queue);
}