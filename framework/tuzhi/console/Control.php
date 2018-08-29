<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/2
 * Time: 11:57
 */

namespace tuzhi\console;

use tuzhi\base\BObject;
use tuzhi\helper\Console;


class Control extends BObject
{


    /**
     * @return string
     */
    public function helpAct()
    {
        return $this->info('===help===');
    }

    /**
     * @param $message
     */
    public function info( $message )
    {
        $message = Console::ansiFormat($message,[Console::FRAMED,Console::FG_CYAN]);
        Console::stdout($message."\n");
    }

    /**
     * @param $message
     */
    public function error( $message )
    {
        Console::stderr($message);
    }

    /**
     * @param $message
     * @return string
     */
    public function ask( $message)
    {
        return Console::prompt($message);
    }

    /**
     * @param $message
     * @param bool $default
     * @return bool
     */
    public function confirm( $message ,$default = true )
    {
        return Console::confirm($message,$default);
    }

    public function select( $prompt , $option =[] )
    {
        return Console::select($prompt,$option);
    }
}