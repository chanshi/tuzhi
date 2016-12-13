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
    protected $version ='v3.3.6';

    /**
     * @var string
     */
    public $sourcePath = '&tz/bootstrap/bootstrap';

    /**
     * @var bool
     */
    public $publishPath = true;

    /**
     * @var string
     */
    public $webPath = '&web/';

    /**
     * @var string
     */
    public $webUrl  = '/bs/';

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