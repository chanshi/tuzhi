<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/23
 * Time: 17:33
 */

namespace tuzhi\support\facades;

use Tuzhi;
use tuzhi\base\Object;

class Manage extends Object
{
    /**
     * @var
     */
    protected $corePath = '&tuzhi/support/facades/core';

    /**
     * @var
     */
    protected $app;

    /**
     * @var array
     */
    protected $core =
        [
            'App',
            'Router',
            'Request',
            'Controller',
            'Model',
            'View',
            'Asset',
            'DB',
            'Cache',
            'Log'
        ];

    /**
     * init
     */
    public function init()
    {
        $this->corePath = Tuzhi::alias($this->corePath);
        $this->app = Tuzhi::App();
    }

    /**
     * @return bool
     */
    public function load()
    {
        $filePath = rtrim($this->corePath,'/').'/';
        foreach( $this->core as $name ){
            if( file_exists($filePath.$name.'.php') ){
                include $filePath.$name.'.php';

            }
        }
        return true;
    }
}