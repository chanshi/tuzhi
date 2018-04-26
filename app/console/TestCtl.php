<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 10:44
 */


namespace app\console;


/**
 * Class TestCtl
 * @package app\console
 */
class TestCtl extends \tuzhi\console\control\TestCtl
{

    public function indexAct($request)
    {

        $key = \App::Redis()->getDb()->allKeys();
        print_r($key);
    }

    public function kafkaAct($request )
    {
        set_time_limit(0);
        $rk = new \RdKafka\Consumer();
// 指定 broker 地址,多个地址用"," 分割
        $rk->addBrokers("39.105.51.17:19092");


        $topic = $rk->newTopic("t4");
        $topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);


        while (true) {
            // 第一个参数是分区号
            // 第二个参数是超时时间
            $msg = $topic->consume(0, 1000);
            switch ( $msg->err ) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $this->info($msg->payload);
                    break;
                default:
                    echo 'none';
            }

        }

    }
}