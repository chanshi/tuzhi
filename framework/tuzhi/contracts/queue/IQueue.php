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
     * @return mixed
     */
    public function push($job);

    /**
     * @param $job
     * @param $time
     * @return mixed
     */
    public function later($job,$time);

    /**
     * @return mixed
     */
    public function pop();
}