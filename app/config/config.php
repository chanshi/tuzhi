<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 23:04
 */

return
    [
        'class' => 'tuzhi\base\Configure',
        'path'=> APP_PATH.'/config/',
        'files'=>
            [
                'alias.php',
                'autoload.php',
                'app.php',
                'server.php',
                'cache.php',
                'memcached.php',
                'cookie.php',
                'session.php',
                // 这个跟环境有关系 暂不处理
                //'developing/server.php',
                //'testing/server.php'
            ]
];