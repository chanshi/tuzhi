<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:22
 */

namespace tuzhi\log\storage;


use tuzhi\contracts\log\IStorage;

class File implements IStorage
{

    protected $savePath;

    protected $orgFormat = '{year}/{month}/{day}' ;

    public function __construct( $config = [] )
    {

    }

    public function record( $message ,$type ){

    }

    public function clean( $type )
    {
        // TODO: Implement clean() method.
    }
}