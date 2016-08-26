<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:08
 */

namespace tuzhi\base\bootstrap;


use tuzhi\contracts\base\IBootstrap;

/**
 * Class BaseSetBoot
 * @package tuzhi\base\bootstrap
 */
class ApplicationBoot implements IBootstrap
{


    public function boot(  $application )
    {
        /**
         *  设置时区
         */
        $this->setTimeZone( $application );

        /**
         *  设置字符
         */
        $this->setCharset( $application );

        /**
         *  异常处理?
         */
        $this->setErrorHandler( $application );
    }


    private function setTimeZone( $application ){
        date_default_timezone_set ( $application->timezone );
    }

    
    private function setCharset($application){
        mb_internal_encoding( $application->charset );
    }

    private function setErrorHandler( $application ) {
        error_reporting(E_ALL);
        //修改调用方法
        $application->get('errorHandler');
    }
}