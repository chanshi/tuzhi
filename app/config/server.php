<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 15:18
 */

return
    [

        'server'=>
            [
                //关系 数据库
                'mysql'=>
                    [
                        'master' =>
                            [
                                'driver'=>'mysql',
                                'host'=>'192.168.56.102',
                                'userName'=>'root',
                                'password'=>'root',
                                'schema'=>'tuzhi_test',
                            ],
                        'slave_0'=>
                            [
                                'driver'=>'mysql',
                                'host'=>'192.168.56.102',
                                'userName'=>'root',
                                'password'=>'root',
                                'schema'=>'tuzhi_test',
                            ],
                        'slave_1'=>
                            [
                                'driver'=>'mysql',
                                'host'=>'192.168.56.102',
                                'userName'=>'root',
                                'password'=>'root',
                                'schema'=>'tuzhi_test',
                            ],
                    ],
                //缓存 服务器
                'memcached'=>
                    [
                        'server_1'=>
                            [
                                'host'=>'192.168.56.102',
                                'port'=>11211
                            ],
                        'server_2'=>
                            [
                                'host'=>'192.168.56.102',
                                'port'=>11211
                            ]
                    ],
                //缓存 服务器
                'redis'=>
                    [

                    ],
                //队列 服务器
                'beanstalkd'=>
                    [
                        'local'=>[]
                    ],
                //图片 服务器
                'ftp'=>
                    [
                        'img'=>[]
                    ],
                //短信 服务器
                'sms'=>
                    [

                    ]
            ]
    ];