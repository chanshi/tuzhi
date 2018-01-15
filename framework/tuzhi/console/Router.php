<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 22:09
 */

namespace tuzhi\console;

use tuzhi\base\Object;
use tuzhi\console\exception\NotFoundCommand;
use tuzhi\contracts\route\IRouter;
use tuzhi\contracts\web\IRequest;

/**
 * Class Router
 * @package tuzhi\console
 */
class Router extends Object  implements IRouter
{

    /**
     * @var
     */
    protected $router;

    /**
     * @var string
     */
    protected $defaultRoute = 'help' ;

    /**
     * @var string
     */
    public $namespace = 'tuzhi\console\control';


    /**
     * @param IRequest $request
     * @return mixed
     */
    public function handler( IRequest $request)
    {
        $this->router = $request->getRoute();

        $this->prepareRoute();
        return $this->dispatch( $request );
    }

    /**
     *
     */
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
     * @param $request
     * @return mixed
     * @throws NotFoundCommand
     */
    protected function dispatch($request)
    {
        if( !class_exists( $this->router[0] ) ){
            throw new NotFoundCommand('Not Found Command Control '.$this->router[0]);
        }
        $control = new $this->router[0] ();
        if( ! method_exists( $control, $this->router[1] ) ){
            $this->router[1] = 'helpAct';
            //throw new NotFoundCommand('Not Found Command Action '.$this->router[1]);
        }
        return call_user_func_array([$control,$this->router[1]],[$request]);
    }

}