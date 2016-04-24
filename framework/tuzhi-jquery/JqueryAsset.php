<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 10:35
 */

namespace tz\jquery;


use tuzhi\view\Asset;

/**
 * Class JqueryAsset
 * @package tz\jquery
 */
class JqueryAsset extends Asset
{

    /**
     * @var string
     */
    public $sourcePath = '&tz/jquery/';

    /**
     * @var array
     */
    public $jsFile = [
        'src/jquery-2.2.3.min.js'
    ];
}