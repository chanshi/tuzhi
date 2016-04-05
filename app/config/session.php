<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:54
 */

return
    [
        'session'=>
            [
                'class' => 'tuzhi\session\Session',
                'sessionName'=>'tu',
                'storage' =>
                    [
                        'class' => 'tuzhi\session\storage\Redis',
                        'server'=> '@redis.1'
                    ]
            ]
    ];