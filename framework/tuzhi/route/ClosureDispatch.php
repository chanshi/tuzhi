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
class ClosureDispatch  extends Dispatcher  implements IDispatch
{

    /**
     * @return mixed
     */
    public function dispatch()
    {
        $this->prepare()
        && $this->getCallContent();
    }


    /**
     * @return mixed
     */
    protected function getCallContent()
    {
        $this->content = call_user_func_array(
            $this->route->getAction(),
            $this->route->getMatch()
        );
    }

}