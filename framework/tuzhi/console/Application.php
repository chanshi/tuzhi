<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 14:42
 */

namespace tuzhi\console;

/**
 * Class Application
 * @package tuzhi\console
 */
class Application extends \tuzhi\base\Application
{


    /**
     *
     */
    public function run()
    {
        print_r(static::Request()->getParams());
        echo 'Console Well done'."\n";
        echo PHP_SAPI."\n";
    }

    /**
     * @return array
     */
    protected function serviceCore()
    {
        return
            [
                'request'=>'tuzhi\console\Request',
                'response'=>'tuzhi\console\Response',
                'router'=>'tuzhi\console\Router',
                'errorHandler'=>'tuzhi\console\ErrorHandler',
                'log'=>'tuzhi\log\Log',
            ];
    }

    /**
     * @return array
     */
    protected function bootCore()
    {
        return
            [
                'tuzhi\base\bootstrap\ApplicationBoot'
            ]
        ;
    }


}