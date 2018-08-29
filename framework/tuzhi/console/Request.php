<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/30
 * Time: 22:03
 */

namespace tuzhi\console;

use tuzhi\base\BObject;
use tuzhi\contracts\web\IRequest;

class Request extends BObject implements IRequest
{

    /**
     * @var
     */
    protected $params =[];

    /**
     * @var string
     */
    protected $route ='';

    /**
     *
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->getParams();
    }

    /**
     * @return array
     */
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
        //
        $this->route = array_shift($this->params);
        $result = [];
        //处理
        foreach($this->params as $param){
            $param = str_replace("--",'',$param);
            list($key,$value)=explode('=',$param);
            $result[$key] =$value;
        }
        return $this->params = $result;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * 意义?
     */
    public function all()
    {
        return $this->params;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get( $key )
    {
        return isset($this->params[$key])
            ? $this->params[$key]
            : null;
    }
}