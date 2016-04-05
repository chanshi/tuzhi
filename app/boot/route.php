<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:10
 */

namespace app\boot;


use tuzhi\route\Router;

Router::get('/',function(){
    return 'Hello Wold;';
});

Router::addRule(
    [
        [
            [ 'GET' ] , '/' , 'Index@Index'
        ],
        [
            [ 'GET','POST' ] ,'/login' , 'User@login'
        ],
        // 通用路由
        [
            ['GET' ,'POST' ] ,'/<\w+:control>/<\w+:action>', "<control>@<action>"
        ]
    ]
);