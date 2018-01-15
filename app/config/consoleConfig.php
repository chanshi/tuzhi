<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 10:29
 */

return
    [
        /**
         * 定义配置类
         */
        'class' => 'tuzhi\base\Configure',

        /**
         *  配置路径
         */
        'path' => __DIR__.'/',

        /**
         * 配置文件
         */
        'files'=>
            [
                'alias.php',
                'namespace.php',
                'console.php'
            ]
    ];