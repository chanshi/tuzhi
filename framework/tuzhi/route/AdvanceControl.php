<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/3
 * Time: 13:12
 */

namespace tuzhi\route;

/**
 * Class AdvanceControl
 * @package tuzhi\route
 */
abstract class AdvanceControl
{
    /**
     * @var
     */
    protected $response;


    /**
     * @return mixed
     */
    public function  getResponse()
    {
        return $this->response;
    }

    /**
     * @param $route
     * @return mixed
     */
    abstract public function handler( $route );
}