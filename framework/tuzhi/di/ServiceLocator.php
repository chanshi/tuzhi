<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:33
 */

namespace tuzhi\di;
use tuzhi\base\ErrorException;
use tuzhi\base\Server;

/**
 *
 *
 * Class ServiceLocator
 * @package tuzhi\di
 */
class ServiceLocator
{

    /**
     * @var
     */
    protected $container;

    /**
     * @var
     */
    protected static $server;

    /**
     * @var
     */
    protected static $completed;

    /**
     * ServiceLocator constructor.
     * @param $server
     */
    public function __construct( $server )
    {
        $this->container = Container::getInstance();
        $this->set( $server );
    }

    /**
     * @param $serverName
     * @return bool
     */
    public function has( $serverName )
    {
        return isset( static::$completed[$serverName] ) ;
    }


    /**
     * @param $serverName
     * @return bool|null
     * @throws ErrorException
     */
    public function get( $serverName )
    {
        $server = null;
        if( $this->has($serverName) ){
            $server = static::$completed[$serverName];
            
            if( $server instanceof Server && ! $server->isRunning() ){
                $server->start();
            }
            return $server;
        }

        if( isset( static::$server[$serverName] ) ){

            $server = $this->container->get( $serverName );

            if( $server instanceof Server && ! $server->isRunning() ){
                $server->start();
            }

            static::$completed[$serverName] = $server;
            return $server;
        }
        
        return false;
    }

    /**
     * @param $serverName
     * @param null $definition
     * @return bool
     */
    public function set( $serverName , $definition = null ){
        if( $definition == null && is_array($serverName) ){
            foreach( $serverName as $key =>$value ){
                $this->set( $key ,$value );
            }
        }else if( $definition !== null ){
            $this->container->set( $serverName ,$definition );
            static::$server[$serverName] = $definition;
        }
        return true;
    }

    /**
     * @param $serverName
     * @return bool
     */
    public function unset( $serverName )
    {
        if( isset( static::$completed[$serverName] ) ){
            unset( static::$completed[$serverName] );
        }
        return true;
    }

    
}