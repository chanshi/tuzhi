<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:11
 */


namespace tuzhi\route;

use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\Server;
use tuzhi\contracts\route\IRouter;
use tuzhi\contracts\web\IRequest;
use tuzhi\contracts\web\IResponse;

class Router extends Server implements IRouter
{
    /**
     * @var null
     */
    public static $routeCollection = null;

    /**
     * @var
     */
    protected $currentRoute;

    /**
     * @var
     */
    protected $dispatch;

   

    public function init()
    {
        if( static::$routeCollection == null ){
            static::$routeCollection = new RouteCollection();
        }
    }

    /**
     * 启动服务
     */
    public function start()
    {
        //TODO: 优化 加载缓存路由
        $this->init();
        //加载路由

        parent::start();
    }

    /**
     * @param IRequest $request
     * @param IResponse $response
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function handler( IRequest $request ,IResponse $response){

        $this->currentRoute = static::$routeCollection->findRoute( $request );

        if(  $this->currentRoute->getAction() instanceof \Closure ){
            $this->dispatch = \Tuzhi::make(
                'tuzhi\route\ClosureDispatch',
                [$this->currentRoute]
            );
        }else {
            $this->dispatch = \Tuzhi::make(
                'tuzhi\route\ControllerDispatch',
                [$this->currentRoute]
            );
        }
        $this->dispatch->dispatch();
        
        $response->setContent( $this->dispatch->getContent()  );
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        if( static::$routeCollection == null ){
            static::$routeCollection = new RouteCollection();
        }

        //Add Route
        if( in_array( strtoupper($name), static::$routeCollection->getAllowMethod() ) ){

            array_unshift($arguments ,$name);

            return call_user_func_array([static::$routeCollection,'addRoute'] ,$arguments);

        }else{

            throw new NotFoundMethodException('Not Found Static Method '.$name.' in Router ');
        }
    }

}