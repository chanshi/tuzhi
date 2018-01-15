<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:38
 */

namespace app\control;

use tuzhi\queue\Task;
use tuzhi\route\Controller;
use tuzhi\web\Application;


/**
 * Class Test
 * @package app\control
 */
class Test extends Controller
{

    public function IndexAction()
    {
        \Cache::Redis()->set('redis-test','good',60);

        var_dump(\Cache::Redis()->get('redis-test'));

        var_dump(\Cache::Redis()->increment('count'));

        var_dump(\Cache::Redis()->decrement('del'));

        //\Cache::Redis()->flush();
    }


    public function redisAction()
    {
        $redis = Application::Redis();
        $redis->open();

        $db = $redis->getDb(1);
        $keys = $db->allKeys();

        // ALL key
        var_dump($keys);

        var_dump($db['test']->typeToString());

        var_dump($db['ab']->typeToString());

        var_dump($db['ac']->typeToString());
        var_dump($db['ab']->del());

        // TEST 列表 推入 和 弹出
//        var_dump($db['cost']->typeToString());
//        $db['cost']->Object()->lPush('test');
//        var_dump($db['cost']->Object()->length());
//        var_dump($db['cost']->Object()->lPop());

    }

    public function influxdbAction()
    {
        $influxdb = \App::Influxdb();
        return function ()use($influxdb){
            print_r($influxdb->ping());
        };
    }


    /**
     * @return \Closure
     */
    public function queueAction()
    {
        return function (){
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
            \Queue::Sky()->push($job);
            \Queue::Sky()->later($job,60);
        };

    }

    public function queuePopAction()
    {
        return function (){
           // while (true) {
            try{
                $job = \Queue::Sky()->pop();
                $job->do();
                //unset($job);
                $job = \Queue::Sky()->pop();
                $job->do();
            }catch( \Exception $e){
                throw $e;
            }

           // }
        };

    }
}