<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 15:12
 */

namespace app\job;

use tuzhi\base\Object;
use tuzhi\queue\job\Job;

/**
 * Class TestJob
 * @package app\job
 */
class TestJob extends Object
{
    /**
     * @param $job Job
     * @param $data
     */
    public function done( $job ,$data )
    {
        echo 'do Job';
        $job->delete();
    }
}