<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 16:33
 */

return
    [
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
                
            ]
    ];