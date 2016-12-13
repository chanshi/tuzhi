<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/23
 * Time: 14:46
 */

namespace tuzhi\base\bootstrap;

use Tuzhi;
use tuzhi\contracts\base\IBootstrap;

class FacadeBoot implements IBootstrap
{

    protected $facade = 'tuzhi\facades\Facades';

    /**
     * @param $app
     */
    public function boot( $app )
    {
        $facade = Tuzhi::make($this->facade);

        $facade->load();
    }
}