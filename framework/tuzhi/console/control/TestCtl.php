<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/2
 * Time: 15:21
 */

namespace tuzhi\console\control;


use tuzhi\console\Control;

/**
 * Class TestCtl
 * @package tuzhi\console\control
 */
class TestCtl extends Control
{
    /**
     *
     */
    public function indexAct()
    {
        $this->info('======== 测试 =========');

//        if( $this->confirm('确定更新？') )
//        {
//            $this->info('正在更新..');
//        }else{
//            $this->info('已取消');
//        }

//        $input = $this->ask('请输入用户名');
//        $this->info($input);

        $select = $this->select('请选择',[
            '我试试',
            '你试试'
        ]);

        $this->info($select);

    }

    /**
     * 批量执行
     */
    public function progressAct()
    {
        $index = 1;
        while (true){
            $this->info($index);
            $index++;
            sleep(1);
            die(0);
        }
    }
}