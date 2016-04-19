<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/2
 * Time: 14:38
 */

namespace tuzhi\contracts\web;

/**
 * Interface IResponse
 * @package tuzhi\contracts\web
 */
interface IResponse
{

    /**
     * @return mixed
     */
    public function send();
    
}