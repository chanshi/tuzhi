<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:11
 */


namespace tuzhi\route;

use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\Object;
use tuzhi\base\Server;
use tuzhi\contracts\route\IRouter;
use tuzhi\contracts\web\IRequest;
use tuzhi\contracts\web\IResponse;

class Router extends Object implements IRouter
{
    /**
     * @var null
     */
    public  $routeCollection = null;

    /**
     * @var
     */
    protected $currentRoute;

    /**
     * @var
     */
    protected $dispatch;

    /**
     * Init
     */
    public function init()
    {
        $this->routeCollection = new RouteCollection();
    }


    /**
     * @param IRequest $request
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function handler( IRequest $request ){
        $this->currentRoute = $this->routeCollection->findRoute( $request );
        if( $this->currentRoute->getAction() instanceof \Closure ){
            $this->dispatch = \Tuzhi::make(
                [
                    'class'=>'tuzhi\route\ClosureDispatch',
                    'route'=>$this->currentRoute ,
                    'request' => $request
                ]
            );
        }else {
            $this->dispatch = \Tuzhi::make(
                [
                    'class'=>'tuzhi\route\ControllerDispatch',
                    'route'=>$this->currentRoute,
                    'request' => $request
                ]
            );
        }
        $this->dispatch->dispatch();
        
        return $this->dispatch->getContent() ;
    }

    public function getCurrent()
    {

    }

    /**
     * @return mixed
     */
    public function getRouteAllowMethod()
    {
        return $this->routeCollection->allowMethod;
    }

    /**
     * @param $method
     * @param $patten
     * @param $action
     * @return mixed
     */
    public function addRoute($method , $patten , $action )
    {
        return $this->routeCollection->addRoute($method , $patten , $action );
    }

}