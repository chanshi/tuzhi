<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:46
 */

namespace app\control;

use Controller;

/**
 * 演示
 * 
 * Class Index
 * @package app\control
 */
class Index extends Controller
{

    public function IndexAction()
    {
        return function (){
            set_time_limit(0);
            $conf = new \RdKafka\Conf();
            $conf->set('group.id',0);
            $conf->set('metadata.broker.list','39.105.51.17:9092');

            $topicConf = new \RdKafka\TopicConf();
            $topicConf->set('auto.offset.reset','smallest');

            $conf->setDefaultTopicConf($topicConf );


            $consumer = new \RdKafka\KafkaConsumer($conf);

            $consumer->subscribe(['t3']);

            $message = $consumer->consume(10*1000);
            switch ($message->err){
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    var_dump($message->payload);
            }
            echo 'done';

        };
    }

    public function testAction()
    {
        return 'This is Test Control';
    }
}