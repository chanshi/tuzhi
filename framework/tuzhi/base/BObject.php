<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:46
 */

namespace tuzhi\base;


use tuzhi\contracts\base\IObject;

/**
 * Class BObject
 * @package tuzhi\base
 */
class BObject implements IObject
{

    /**
     * BObject constructor.
     * @param array $config
     */
    public function __construct( array $config = []  )
    {
        $this->initConfig($config);
        $this->init();
    }
    
    /**
     * @param array $config
     */
    final private function initConfig( $config = [] )
    {
        foreach($config as $name => $value )
        {
            //TODO:: 新加功能
            if( is_string($value) && (substr($value,0,1) == '@') ){
                $value = \Tuzhi::config( $value );
            }

            $this->{$name} = $value;
        }
    }

    /**
     * @return mixed
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * @return mixed
     */
    public function init() {}
}