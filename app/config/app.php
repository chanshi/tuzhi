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
                 * APP服务
                 */
                'service' =>
                    [

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
                            ],
                        'module'=>
                            [
                                'class'=>'tuzhi\module\ModuleManager',
                                'modulePath' => MODULE_PATH,
                                'moduleConfig'=>
                                    [
                                        /**
                                         *  模块配置文件 默认
                                         */
                                        'test'=>'/test/config/module.php',
                                    ]
                            ],
                        'redis'=>
                            [
                                'class'=>\tuzhi\nosql\redis\Connection::className(),
                                'redis'=>
                                    [
                                        'host'=>'192.168.56.102'
                                    ]
                            ],
                        'influxdb'=>
                            [
                                'class'=>\tuzhi\nosql\influxdb\Connection::className(),
                                'server'=>
                                    [
                                        'uri'=>'http://ts.xiaoyouapp.cn:8086',
                                        'database'=>'tests'
                                    ]
                            ],
                        'cache'=>
                            [
                                'class'  =>'tuzhi\cache\Cache',
                                'default'=>'memcached',
                                'support'=>
                                    [
                                        'file'=>
                                            [
                                                'keyPrefix' => 'cache_',
                                                'cacheDir'  => '&runtime/cache',
                                                'fileSuffix' => '.cache'
                                            ],
                                        'memcached'=>
                                            [
                                                'keyPrefix'=>'cache_',
                                                //允许多台 并允许使用负载? 或者 一致性哈希
                                                'server'=>'@server.memcached.server_1'
                                            ],
                                        'redis'=>
                                            [
                                                'keyPrefix'=>'cache_',
                                                'server'=>
                                                    [
                                                        'host'=>'192.168.56.102',
                                                        'dbIndex'=> 1
                                                    ]
                                            ]
                                    ]

                            ],
                        'images'=>
                            [
                                'class'=>\tuzhi\support\images\Images::className(),
                                'service'=>
                                    [
                                        'class'=> \tuzhi\support\images\services\Location::className()
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
                                                    'dbIndex'=>0,
                                                    'pConnect'=>false
                                                ]
                                        ]
                                    ]
                            ],
                    ]
            ]
        
    ];