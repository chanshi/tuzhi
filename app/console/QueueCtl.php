<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 11:58
 */

namespace app\console;

use tuzhi\console\Control;
use tuzhi\queue\Task;
use tuzhi\support\profiler\Memory;

/**
 * Class QueueCtl
 * @package app\console
 */
class QueueCtl extends Control
{
    /**
     *
     */
    public function indexAct()
    {
        $this->info('queue');
    }

    public function statusAct()
    {
        $queue = \Queue::Sky();
        while (true)
        {
            print_r($queue->getCount());
            usleep(1000*1000);
            \Response::clear();
        }
    }

    public function clearAct()
    {
        \Queue::Sky()->clearReady();
        $this->info('clear done');
    }

    public function addJobAct()
    {
        echo  \Queue::Sky()->getName();
        $job = new Task(
            [
                'handler'=> 'app\job\TestJob',
                'data'=>
                    [
                        'value'=> 2
                    ]
            ]
        );
        while(true)
        {
            \Queue::Sky()->push($job);
            \Queue::Sky()->later($job,100);
            $this->info('add job done!');
            sleep(1);
        }

    }

    /**
     * 批量执行
     */
    public function daemonAct()
    {
        $queue = \Queue::Sky();
        Memory::mark('daemon.start');
        while (true){
            $job = $queue->pop();
            if( $job ){
                $this->info(date('Y-m-d H:i:s'));
                //echo date('Y-m-d H:i:s')."\n";
                $job->do();
                $this->info('');
            }
            Memory::mark('daemon.end');
            $this->info(Memory::slice('daemon'));
            //sleep(1);
            usleep(100000);  //1000000

        }
    }
}