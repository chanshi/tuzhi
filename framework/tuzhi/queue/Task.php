<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 15:26
 */

namespace tuzhi\queue;

use tuzhi\base\BObject;

/**
 * Class Task
 * @package tuzhi\queue
 */
class Task extends BObject
{

    public $handler;
    /**
     * @var
     */
    public $data;
}