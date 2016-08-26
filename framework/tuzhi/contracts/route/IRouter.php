<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/10
 * Time: 15:54
 */

namespace tuzhi\contracts\route;


use tuzhi\contracts\web\IRequest;

/**
 * Interface IRouter
 * @package tuzhi\contracts\route
 */
interface IRouter
{
    /**
     * @param IRequest $request
     * @return mixed
     */
    public function handler( IRequest  $request );
}