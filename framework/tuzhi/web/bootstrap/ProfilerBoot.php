<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 15:36
 */

namespace tuzhi\web\bootstrap;

use tuzhi\contracts\base\IBootstrap;
use tuzhi\support\profiler\Profiler;

/**
 * Class ProfilerBoot
 * @package tuzhi\web\bootstrap
 */
class ProfilerBoot implements IBootstrap
{
    /**
     * @param $application
     */
    public function boot( $application )
    {
        if( ! $application->isProduction() ){
            // 启用分析
            $Profiler = new Profiler();
            $Profiler->eventRegister();
        }
    }
}