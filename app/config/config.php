<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 23:04
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
                'app.php',
                'server.php',
                'cache.php',
            ]
];