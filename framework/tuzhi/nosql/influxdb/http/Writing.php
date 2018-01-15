<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2017/3/17
 * Time: 11:36
 */

namespace tuzhi\nosql\influxdb\http;

class Writing extends Request
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @var string
     */
    protected $patten = '/write';

}