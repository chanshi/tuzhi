<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 16:47
 */





Module::register(
    \Tuzhi::make(
        (require __DIR__.'/config/module.php')['module']
    )
);


/**
 *
 *  Module::Test()->cache();
 *
 *
 */