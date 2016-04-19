<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:10
 */

namespace app\boot;


use tuzhi\route\Router;

/**
 * 路由器 配置
 *
 * 暂时不加 module 的路由器配置
 *
 * 匹配模式 建议放在最后处理
 *
 * 参数的匹配问题
 *
 */


/**
 * 直接处理
 */
Router::get('/test/<\d+:ab>',function( $ab ){
    return '我在测试'.$ab;
});

/**
 * 定义路由器的几种方式
 */
Router::get('/goods','Index@Index');

/**
 * 通用的控制器模式
 */
Router::all('/<\w+:control>/<\w+:action>','<control>@<action>');
