<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:41
 */

namespace tuzhi\nosql\influxdb;

use tuzhi\base\BObject;

/**
 * Class Command
 * @package tuzhi\nosql\influxdb
 */
class Command extends BObject
{
    /**
     * @var
     */
    protected $db;

    /**
     * @var
     */
    protected $sql;

    /**
     *
     */
    public function query(){}


}