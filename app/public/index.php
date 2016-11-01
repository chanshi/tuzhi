<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:29
 */

/**
 * 项目APP 目录
 */
define('APP_PATH', dirname(__DIR__) );

/**
 * 模块 路径
 */
define('MODULE_PATH',__DIR__.'/../../module');


/**
 * 加载框架
 */
require __DIR__.'/../../framework/tuzhi/Tuzhi.php';

/**
 * 初始化框架
 */
Tuzhi::init(
    ( require  APP_PATH.'/config/config.php')
);

/**
 * 运行
 */
Tuzhi::App()->run();
