<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/13
 * Time: 17:38
 */

namespace tuzhi\queue\job;

use tuzhi\base\Object;
use tuzhi\queue\Payload;

/**
 * Class Job
 * @package tuzhi\queue\job
 */
abstract class Job extends Object
{

    /**
     * @var
     */
    public $Payload;

    /**
     * @var
     */
    public $raw;

    /**
     * @var int
     */
    public $tries = 3;


    /**
     * @return mixed
     */
    abstract public function do();

    /**
     *
     */
    protected function resolveRaw()
    {
        $this->Payload = Payload::decode($this->raw);
    }

}