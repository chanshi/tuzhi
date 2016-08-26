<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:44
 */

namespace tuzhi\web;

use tuzhi\helper\Arr;

class Application extends \tuzhi\base\Application {

    /**
     * @return mixed
     */
    public function getAppPath()
    {
        return $this->appPath;
    }

    /**
     * Run
     */
    public function run(){
        try{

            $content = static::router()->handler( static::request() );

            static::response()->setContent( $content );

            static::response()->send();

        }catch(\Exception $e){
            //TODO::
            throw $e;
        }
    }

    /**
     * @return array
     */
    protected function bootCore()
    {
        return Arr::marge(
            parent::bootCore(),
            [

            ]
        );
    }

    /**
     * @return array
     */
    protected function serviceCore()
    {
        return Arr::marge(
            [
                //'session'=>'',
                'view'=>'tuzhi\view\View',
            ],
            parent::serviceCore()
        );
    }
}