<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/6
 * Time: 15:43
 */


namespace tuzhi\route\check;

use tuzhi\contracts\route\IRoute;
use tuzhi\base\Object;
use tuzhi\contracts\route\ICheck;


class ThrottleRequests extends Object
{

    /**
     * @var int
     */
    public $maxAttempts = 60;

    /**
     * @var int
     */
    public $decayMinutes = 1;

    /**
     * @param $route
     * @param $request
     */
    public function handle( $route , $request)
    {
        //return ['error'=>'test'];
    }

    /**
     *
     */
    protected function tooManyAttempts()
    {
        // Response  429;
    }
}