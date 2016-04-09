<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/8
 * Time: 23:42
 */

return
    [
        'memcached' =>
            [
                'server_1'=>
                    [
                        'host'=>'192.168.56.102',
                        'port'=>662
                    ],
                'server_2'=>
                    [
                        'host'=>'192.168.56.102',
                        'port'=>662
                    ],
                'group'=>
                [
                    'server'=>
                        [
                            '@memcached.server_1',
                            '@memcached.server_2'
                        ],
                    'strategy'=>'hash'
                ]
            ]
    ];