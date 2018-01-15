<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/12
 * Time: 16:46
 */

namespace tuzhi\facades;


use tuzhi\base\Object;

/**
 * Class Facades
 * @package tuzhi\facades
 */
class Facades extends Object
{
    /**
     * @var array
     */
    protected $maps=
        [
            'App',
            'Router',
            'Request',
            'Response',
            'Controller',
            'Model',
            'View',
            'Asset',
            'DB',
            'Cache',
            'Log',
            'Block',
            'Config',
            'Cookie',
            'Session',
            'ActiveRecord',
            'Form',
            'User',
            'DataCollection',
            'Module',
            'Event',
            'Queue',
            'Img'
        ];

    /**
     * @return bool
     */
    public function load()
    {
        foreach( $this->maps as $facade ){
            $file = __DIR__.'/libs/'.$facade.'.php';
            if( file_exists($file) ){
                include  $file ;
            }
        }
        return true;
    }
}