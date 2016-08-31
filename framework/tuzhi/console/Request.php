<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 22:03
 */

namespace tuzhi\console;

use tuzhi\base\Object;
use tuzhi\contracts\web\IRequest;

class Request extends Object implements IRequest
{

    protected $params;


    public function getParams()
    {
        if( $this->params == null ) {
            if( isset($_SERVER['argv']) ){
                $this->params = $_SERVER['argv'];
                //
                array_shift($this->params);
            }else{
                $this->params = [];
            }
        }
        return $this->params;
    }

    /**
     * 意义?
     */
    public function all()
    {
        // TODO: Implement all() method.
    }
}