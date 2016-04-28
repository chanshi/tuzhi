<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:04
 */

/**
 * 规则
 * 路径 已 / 结尾
 */
return
    [
        // 别名
        'alias'=>
            [
                '&app' => APP_PATH.'/',
                '&config' => APP_PATH.'/config/',
                '&public' => APP_PATH.'/public/',
                '&runtime' => APP_PATH.'/runtime/',
                '&resource' => APP_PATH.'/resource/',
                '&view' => APP_PATH.'/resource/view/',
                '&web' => APP_PATH.'/public/'
            ]
    ];