<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:46
 */

namespace app\resource\asset;


use tuzhi\view\Asset;


class AppAsset extends Asset
{
    /**
     * @var string 源码位置
     */

    public $webPath ='&web/';

    public $webUrl = '/';

    public $cssFile = [
        'css/common.css'
    ];

    public $jsFile = [
        'js/common.js'
    ];

    public $depends =[
        'tz\bootstrap\BootstrapAsset'
    ];

}
