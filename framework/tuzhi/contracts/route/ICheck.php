<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/6
 * Time: 15:29
 */

namespace tuzhi\contracts\route;

/**
 * Interface IPipe
 * @package tuzhi\contracts\route
 */
interface ICheck
{
    /**
     * @param IRoute $route
     * @return mixed
     */
    public function handle( IRoute $route );
}