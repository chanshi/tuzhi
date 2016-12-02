<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:44
 */

namespace tuzhi\web;

use tuzhi\base\Event;
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
            Event::trigger( $this,static::EVENT_BEFORE_RUN );

            $content = static::router()->handler( static::request() );

            static::response()->setContent( $content );

            static::response()->send();

            Event::trigger( Application::className() ,static::EVENT_AFTER_RUN );

        }catch(\Exception $e){
            //TODO::
            throw $e;
        }

        Event::trigger($this,static::EVENT_APP_END);

    }

    /**
     * @return array
     */
    protected function bootCore()
    {
        return Arr::append(
            parent::bootCore(),
            [
                'tuzhi\web\bootstrap\ProfilerBoot'
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
                'session'=>'tuzhi\session\Session',
                'view'=>'tuzhi\view\View',
            ],
            parent::serviceCore()
        );
    }
}