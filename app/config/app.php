<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 10:46
 */

return
    [
        'app' =>
            [
                'class'=>'tuzhi\web\Application',
                // 基本
                'charset' => 'utf-8',
                'timezone' => 'PRC' ,
                'environment' => 'production',
                // 启动
                'bootstrap'=>
                    [

                    ],
                //服务
                'server' =>
                    [
                        'log'=>
                            [
                                'class' => 'tuzhi\log\Log',
                                'storage' =>
                                    [
                                        'class' => 'tuzhi\log\storage\File',
                                        'path' => '&runtime/logs/{year}/{month}/{day}/',
                                        'file' =>  '{type}.log'
                                    ],
                                'allow' => 7,
                                'pattern'=> '{time} {message}'
                            ],
                        'request'=>
                            [
                                'class'=>'tuzhi\web\Request',
                            ],
                        'router'=>
                            [
                                'class'=>'tuzhi\route\Router',
                            ],
                        'response'=>
                            [
                                'class'=>'tuzhi\web\Response',
                            ],
                        'errorHandler'=>
                            [
                                'class'=>'tuzhi\web\ErrorHandler'
                            ],
                        'view'=>
                            [
                                'class'=>'tuzhi\view\View',
                                'theme'=>
                                    [
                                        'class'   => 'tuzhi\view\Theme',
                                        'webPath' => '&web',
                                        'webUrl'  => '/',
                                        'basePath'=> '&resource'
                                    ]
                            ],
                        'db'=>
                            [
                                'class' => 'tuzhi\db\Connection',
                                'master'=> '@server.mysql.master',
                                'slave' =>
                                    [
                                        'class'=>'tuzhi\support\loadBalance\LoadBalance',
                                        'server'=>
                                            [
                                                ['@server.mysql.slave_1','weight'=>60],
                                                ['@server.mysql.slave_0','weight'=>40]
                                            ],
                                        'dispatch'=>'weight'
                                    ],
                                'attribute'=>
                                    [
                                        PDO::ATTR_TIMEOUT => 10
                                    ]
                            ]
                    ],
                //中间件
                'middleware'=>
                    [

                    ]
            ]
        
    ];