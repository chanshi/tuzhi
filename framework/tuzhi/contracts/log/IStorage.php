<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:24
 */

namespace tuzhi\contracts\log;

/**
 * Interface IStorage
 * @package tuzhi\contracts\log
 */
interface IStorage
{
    /**
     * @param $message
     * @return mixed
     */
    public function record ( $message ,$type );

    /**
     * 清除
     * @return mixed
     */
    public function clean($type);
}