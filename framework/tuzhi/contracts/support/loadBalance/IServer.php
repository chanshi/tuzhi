<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/26
 * Time: 10:59
 */

namespace tuzhi\contracts\support\loadBalance;


/**
 * Interface IServer
 * @package tuzhi\contracts\support\loadBalance
 */
interface IServer
{
    /**
     * @return mixed
     */
    public function getServer();

    /**
     * @param $server
     * @return mixed
     */
    public function setServer( $server );
}