<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 15:37
 */

namespace tuzhi\contracts\route;

/**
 * Interface IDispatch
 * @package tuzhi\contracts\route
 */
interface IDispatch
{
    /**
     * @return mixed
     */
    public function dispatch();

    /**
     * @return mixed
     */
    public function getContent();
}