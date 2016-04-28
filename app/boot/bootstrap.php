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
 * 初始化框架
 */
Tuzhi::init( ( require  APP_PATH.'/config/config.php') );


/**
 * 加载路由
 */
require __DIR__.'/route.php';

/**
 * 运行
 */

Tuzhi::App()->run();

