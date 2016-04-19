<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 11:40
 */

/**
 * 加载框架
 */
require __DIR__.'/../../framework/tuzhi/Tuzhi.php';

/**
 * 加载别名
 */
Tuzhi::setAlias( __DIR__.'/../config/alias.php');


/**
 * 加载配置?
 */

$config =  (require __DIR__.'/../config/app.php');


/**
 * 创建应用
 */
Tuzhi::make(
    'tuzhi\web\Application',
    [$config['app']]
);

/**
 * 加载路由
 */
require __DIR__.'/route.php';

/**
 * 运行
 */
Tuzhi::$app->run();
