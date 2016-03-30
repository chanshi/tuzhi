<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:44
 */

namespace tuzhi\web;


class Application extends \tuzhi\base\Application {

    public $request;

    public $route;

    public $respond;

    public function __construct( $config = [] ){
        parent::__construct( $config );
    }

    public function run(){

    }
}