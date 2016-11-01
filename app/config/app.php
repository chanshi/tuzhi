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
                'environment' => 'production',

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
                            ]
                    ]
            ]
        
    ];