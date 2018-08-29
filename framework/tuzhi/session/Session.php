<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:51
 */

namespace tuzhi\session;

use tuzhi\base\BObject;


/**
 * Class Session
 * @package tuzhi\session
 */
class Session extends BObject
{
    /**
     * @var array
     */
    protected $storeClassMap = 
        [
            
        ];

    /**
     * 检查是否
     * @return bool
     */
    public function isActive()
    {
        if( php_sapi_name() !== 'cli' ){
            if( version_compare(phpversion(),'5.4.0','>=') ){
                return session_status() === PHP_SESSION_ACTIVE
                    ? true
                    : false;
            }else{
                return session_id() === '' ?  false : true;
            }
        }
        return false;
    }

    /**
     *
     */
    public function open()
    {
        if( ! $this->isActive() ){
            @session_start();
        }
        return true;
    }

    /**
     * @param $name
     * @return null
     */
    public function get( $name )
    {
        $this->open();
        return isset($_SESSION[$name])
            ? $_SESSION[$name]
            : null;
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function set( $name ,$value )
    {
        $this->open();
        return $_SESSION[$name] = $value;
    }

    /**
     * @param $name
     */
    public function rm( $name )
    {
        $this->open();
        unset( $_SESSION[$name] );
    }
}