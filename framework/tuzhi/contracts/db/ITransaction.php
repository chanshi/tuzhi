<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 16:14
 */

namespace tuzhi\contracts\db;

interface ITransaction
{
    public function transaction( $callback ,$isolationLevel =null);

    public function beginTransaction();

    public function rollback();

    public function commit();


}