<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 10:14
 */


return
    [

        /**
         * console
         */
        'app'=>
            [

                'class'=>'tuzhi\console\Application',

                /**
                 * 网站编码
                 */
                'charset' => 'utf-8',

                /**
                 * 时区
                 */
                'timezone' => 'PRC' ,

                /**
                 * 运行环境
                 */
                'environment' => 'development',

                /**
                 * 提供的服务
                 */
                'service'=>
                    [
                        'router'=>
                            [
                                'class'=> \tuzhi\console\Router::className(),
                                'namespace'=>'app\console'
                            ],
                        'redis'=>
                            [
                                'class'=>\tuzhi\nosql\redis\Connection::className(),
                                'redis'=>
                                    [
                                        'host'=>'192.168.56.102'
                                    ]
                            ],
                        'queue'=>
                            [
                                'class'=> \tuzhi\queue\QueueManage::className(),
                                'config'=>
                                    [
                                        [
                                            'queueName'=>'sky',
                                            'driver'=>'redis',
                                            'server'=>
                                                [
                                                    'host'=>'192.168.56.102',
                                                    'dbIndex'=>0
                                                ]
                                        ]
                                    ]
                            ],
                    ],
            ]
    ];