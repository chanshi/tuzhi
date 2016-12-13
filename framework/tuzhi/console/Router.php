<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 22:09
 */

namespace tuzhi\console;

use tuzhi\console\exception\NotFoundCommand;
use tuzhi\contracts\route\IRouter;
use tuzhi\contracts\web\IRequest;

/**
 * Class Router
 * @package tuzhi\console
 */
class Router implements IRouter
{

    protected $router;

    protected $defaultRoute = 'help' ;

    protected $namespace = 'tuzhi\console\control';


    public function handler( IRequest $request)
    {
        $this->router = $request->getRoute();

        $this->prepareRoute();
        return $this->dispatch();
    }


    public function prepareRoute()
    {
        $this->router = empty($this->router)
            ? $this->defaultRoute
            : $this->router;
        $this->router = explode('.',$this->router);
        $this->router[0] = $this->namespace.'\\'. ucfirst($this->router[0]).'Ctl';
        $this->router[1] = isset($this->router[1]) ?  $this->router[1].'Act' : 'indexAct';
    }

    /**
     * 执行control;
     */
    protected function dispatch()
    {
        if( !class_exists( $this->router[0] ) ){
            throw new NotFoundCommand('Not Found Command Control '.$this->router[0]);
        }
        $control = new $this->router[0] ();
        if( ! method_exists( $control, $this->router[1] ) ){
            $this->router[1] = 'helpAct';
            //throw new NotFoundCommand('Not Found Command Action '.$this->router[1]);
        }
        return call_user_func_array([$control,$this->router[1]],[]);
    }

}