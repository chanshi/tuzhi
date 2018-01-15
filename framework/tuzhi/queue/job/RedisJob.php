<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/14
 * Time: 14:49
 */

namespace tuzhi\queue\job;

/**
 * Class RedisJob
 * @package tuzhi\queue\job
 */
class RedisJob extends Job
{

    public $job;

    /**
     * @var
     */
    public $queue;


    public function do()
    {
        try{
            $this->resolveRaw();

            //print_r($this->Payload['job']);exit;
            $handler = \Tuzhi::make($this->Payload['job']->handler);

            call_user_func_array([$handler,'done'],[$this,$this->Payload['job']->data]);
        }catch (\Exception $e){
            $this->delete();
        }


    }

    /**
     *
     */
    public function delete()
    {
        $this->queue->deleteReserved( $this->raw );
    }

    /**
     *
     */
    public function reJoin()
    {
        $this->queue->releaseToReady( $this->raw );
    }
}