<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 11:06
 */

namespace tuzhi\view\engine;
use tuzhi\contracts\view\IEngine;


/**
 * Class PhpEngine
 * @package tuzhi\view\engine
 */
class PhpEngine implements IEngine
{

    /**
     * @var null
     */
    protected $content;

    /**
     * PhpEngine constructor.
     */
    public function __construct()
    {
        $this->content = null;
    }

    /**
     * @param $file
     * @param array $param
     * @return mixed
     * @throws \Exception
     */
    public function render( $file , $param = [] )
    {
        $level = ob_get_level();

        ob_start();

        extract($param, EXTR_SKIP);

        try{
            
            include $file;

        }catch(\Exception $e ){
            while( ob_get_clean() > $level ){
                ob_get_clean();
            }
            throw $e;
        }

        $this->content = trim( ob_get_clean() );
        return $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }
}