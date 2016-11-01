<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/9
 * Time: 01:33
 */

namespace tuzhi\di;

/**
 * Class Instance
 * @package tuzhi\di
 */
class Instance
{

    /**
     * @var
     */
    public $name;


    /**
     * Instance constructor.
     * @param $name
     */
    public function __construct( $name )
    {
        $this->name = $name;
    }


    /**
     * @param $name
     * @return static
     */
    public static function set( $name )
    {
        return new static($name);
    }


    /**
     * @return mixed
     */
    public function get()
    {
        return Container::getInstance()->get( $this->name );
    }

}