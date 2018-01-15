<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 16:28
 */

return
    [
        'module' =>
            [
                /**
                 * 模块名称
                 */
                'name' =>'test',

                /**
                 * 模块版本
                 */
                'version'=>'0.1',


                /**
                 * 模块自己需要的服务
                 */
                'services'=>
                    [
                        'config'=>
                            [
                                'class' =>'tuzhi\base\Configure',
                                'path'  => __DIR__,
                                'file'  =>
                                    [
                                        'params.php'
                                    ]
                            ],
                        'cache'=>
                            [
                                'class'  =>'tuzhi\cache\Cache',
                                'default'=>'file',
                                'support'=>
                                    [
                                        'file'=>
                                            [
                                                'keyPrefix' => 'cache_',
                                                'cacheDir'  => '&runtime/test',
                                                'fileSuffix' => '.ts'
                                            ],

                                    ]
                            ]
                    ],

                /**
                 * 模块依赖的服务
                 */
                'dependServices'=>
                    [
                        'cache',
                        'request'
                    ],

                /**
                 * 模块依赖
                 */
                'dependModule'=>
                    [
                        'user' =>
                            [
                                'module\User',
                                'version'=>'1.0'
                            ]
                    ],
                /**
                 * 最后修改时间
                 */
                'lastModifyTime'=>'',

                /**
                 * 作者
                 */
                'auth'=>'sky',

                /**
                 * 模块描述
                 */
                'describes'=>'模块测试',
            ]
    ];