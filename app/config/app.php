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
                // 基本
                'charset' => 'utf8',
                'timezone' => 'PRC' ,
                'appPath' => __DIR__.'../',
                'environment' => 'production',
                // 启动
                'bootstrap'=>
                    [

                    ],
                //服务
                'serve' =>
                    [
                        'log'=>
                            [
                                'class' => 'tuzhi\log\Log',
                                'storage' =>
                                    [
                                        'class'     =>'tuzhi\log\storage\File',
                                        'savePath'  => 'log/',
                                        'orgFormat' => '{year}/{month}'
                                    ],
                                'allow' => 7,
                                'pattern'=> '{time}{message}'

                            ],
                        'request'=>
                            [
                                'class'=>'tuzhi\web\Request',
                                'session'=>'@session',
                                'cookie'=>'@cookie'
                            ],
                        'router'=>
                            [
                                'class'=>'tuzhi\route\Router',
                                'request'=>'@request'
                            ],
                        'response'=>
                            [
                                'class'=>'tuzhi\web\Response',
                            ],
                        'errorHandler'=>
                            [
                                'class'=>'tuzhi\base\Error',
                            ],
                        'exceptionHandler'=>
                            [
                                'class'=>'tuzhi\base\Exception'
                            ]
                    ],
                //中间件
                'middleware'=>
                    [

                    ]
            ]
    ];