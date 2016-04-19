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
class BaseSetBoot implements IBootstrap
{


    public function boot(  $application )
    {
        $this->setTimeZone( $application );
        $this->setCharset( $application );
    }

    private function setTimeZone( $application ){
        date_default_timezone_set ( $application->timezone );
    }

    private function setCharset($application){
        mb_internal_encoding( $application->charset );
    }
}