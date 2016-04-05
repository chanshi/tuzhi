<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:54
 */


return
    [
        'cookie'=>
            [
                'class'=>'tuzhi\web\cookie\CookieCollect',
                'expire'=> 60 * 60 * 24,
                'path' =>'/'
            ]
    ];