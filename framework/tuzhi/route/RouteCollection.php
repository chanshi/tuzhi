<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/11
 * Time: 20:46
 */

namespace tuzhi\route;


use tuzhi\route\exception\NotMatchRouteException;

class RouteCollection implements \IteratorAggregate , \ArrayAccess ,\Countable
{
    /**
     * @var array
     */
    public $routes;

    /**
     * @var array
     */
    public $allowMethod =
        [
            'GET',
            'POST',
            'HEAD',
            'PUT',
            'PATCH',
            'DELETE',
            'PURGE',
            'OPTIONS',
            'TRACE',
            'CONNECT',
            'ALL'
        ];

    /**
     * RouteCollection constructor.
     */
    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * @param $method
     * @param $patten
     * @param $action
     * @return Route
     */
    public function addRoute($method,$patten,$action )
    {
        $route = new Route( $method ,$patten ,$action );
        $this->routes[ $route->getName() ] = $route;
        return $route;
    }

    /**
     *
     * @param $request
     * @return mixed|null
     * @throws NotMatchRouteException
     */
    public function findRoute( $request )
    {
        foreach( $this as $name=>$route )
        {
            //match method && match patten
            if( $route->matchMethod( $request->getMethod() ) && 
                $route->matchPatten( $request->getPath() )
            ){
                return $route;
            }
        }
        throw new NotMatchRouteException('Not Match Route The Method "'.$request->getMethod().'" The Patten "'.$request->getPath().'" ');
    }

    /**
     * @return array
     */
    public function getAllowMethod()
    {
        return $this->allowMethod;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->routes );
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {

        $this->routes[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        if( isset( $this->routes[$offset] ) ){
            return $this->routes[$offset];
        }
        return null;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetUnset($offset)
    {
        if( isset( $this->routes[$offset] ) ){
            unset( $this->routes[$offset] );
        }
        return true;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset( $this->routes[$offset] );
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count( $this->routes );
    }
}