<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:49
 */

namespace tz\bootstrap;

use tuzhi\view\Asset;

class BootstrapAsset extends Asset
{
    /**
     * @var string
     */
    public $sourcePath = '&tz/bootstrap/';

    /**
     * @var array
     */
    public $cssFile = [
        'dist/css/bootstrap.min.css'
    ];

    /**
     * @var array
     */
    public $jsFile = [
        'dist/js/bootstrap.min.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'tz\jquery\JqueryAsset'
    ];
    
}