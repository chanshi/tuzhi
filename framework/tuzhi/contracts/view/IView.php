<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 11:01
 */

namespace tuzhi\contracts\view;

/**
 * Interface IView
 * @package tuzhi\contracts\view
 */
interface IView
{
    /**
     * @param $view
     * @param array $param
     * @return mixed
     */
    public function render($view , $param = []);
}