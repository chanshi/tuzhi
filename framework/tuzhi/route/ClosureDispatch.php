<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/19
 * Time: 15:33
 */

namespace tuzhi\route;

use tuzhi\base\Object;
use tuzhi\contracts\route\IDispatch;

/**
 * Class ClosureDispatch
 * @package tuzhi\route
 */
class ClosureDispatch  implements IDispatch
{

    /**
     * @var
     */
    public $route;

    /**
     * @var
     */
    public $content;

    /**
     * ClosureDispatch constructor.
     * @param $route
     */
    public function __construct( $route )
    {
        $this->route = $route;
    }

    /**
     *
     */
    public function dispatch()
    {
        $this->content = call_user_func_array(
            $this->route->getAction(),
            $this->route->getMatch()
        );
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}