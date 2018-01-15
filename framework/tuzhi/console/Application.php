<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 14:42
 */

namespace tuzhi\console;

use tuzhi\helper\Arr;

defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));

/**
 * Class Application
 * @package tuzhi\console
 */
class Application extends \tuzhi\base\Application
{

    public function run()
    {

        $content = static::Router()->handler(static::Request());

        static::Response()->content = $content;

        static::Response()->send();
    }

    /**
     * @return array
     */
    protected function serviceCore()
    {
        return Arr::marge(
            [
                'request'=>'tuzhi\console\Request',
                'response'=>'tuzhi\console\Response',
                'router'=>'tuzhi\console\Router',
                'errorHandler'=>'tuzhi\console\ErrorHandler',
                'log'=>'tuzhi\log\Log',
            ],$this->service
        );
    }

    /**
     * @return array
     */
    protected function bootCore()
    {
        return Arr::marge(
            [
                'tuzhi\base\bootstrap\ApplicationBoot',
                'tuzhi\base\bootstrap\FacadeBoot'
            ],$this->bootstrap
        );
    }


}