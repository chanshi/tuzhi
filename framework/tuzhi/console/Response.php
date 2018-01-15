<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 22:13
 */

namespace tuzhi\console;

use tuzhi\base\Object;
use tuzhi\contracts\web\IResponse;
use tuzhi\helper\Console;

/**
 * Class Response
 * @package tuzhi\console
 */
class Response extends Object implements IResponse
{

    /**
     * @var
     */
    public $content;

    /**
     *
     */
    public function send()
    {
        if(is_array($this->content)){
            foreach ( $this->content as $key=>$value ){
                $this->output( printf('%20s    %s',$key,$value) );
            }
        }else{
            $this->output($this->content);
        }
    }

    public function output( $info )
    {
        Console::stdout($info."\n");
    }

    /**
     *
     */
    public function clear()
    {
        system('clear');
    }
}