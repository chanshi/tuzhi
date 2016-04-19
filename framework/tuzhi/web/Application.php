<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:44
 */

namespace tuzhi\web;




class Application extends \tuzhi\base\Application {


    /**
     * 启用父类
     * Application constructor.
     * @param array $config
     */
    public function __construct( $config = [] ){

        parent::__construct( $config );

    }

    public function getAppPath()
    {
        return $this->appPath;
    }

    /**
     * 基本处理流
     */
    public function run(){
        try{

            $request = $this->request();

            $response = $this->response();

            $router  = $this->router();

            //print_r($_SERVER);exit;

            $router->handler( $request ,$response ) ;

            $response->send();

        }catch(\Exception $e){
            //这里要处理
            throw $e;
        }
    }
}