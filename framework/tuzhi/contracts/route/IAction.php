<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/23
 * Time: 16:44
 */

namespace tuzhi\contracts\route;

/**
 * Interface IAction
 * @package tuzhi\contracts\route
 */
interface IAction
{
    /**
     * @return mixed
     */
    public function action();
}