<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/6
 * Time: 16:05
 */

return
    [
        'router'=>
            [

                'index@*'=>
                    [
                        'check'=>['base']
                    ],

                'public@*'=>
                    [
                        'check'=>[]
                    ],

                /**
                 * 前置检查
                 */
                'check'=>
                    [
                        'base'=>
                            [
                                'class' => '',
                                'path' => 'ALL'
                            ],
                        'auth'=>
                            [
                                'class'=>'',
                                'path'=>
                                    [
                                        '/index',
                                        '/my',
                                    ]
                            ]
                    ],

            ]
    ];