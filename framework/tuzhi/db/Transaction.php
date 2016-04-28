<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:33
 */

namespace tuzhi\db;


use tuzhi\base\Object;

/**
 * Class Transaction
 * @package tuzhi\db
 */
class Transaction extends Object
{

    const READ_UNCOMMITTED = 'READ UNCOMMITTED';

    const READ_COMMITTED = 'READ COMMITTED';

    const REPEATABLE_READ = 'REPEATABLE READ';

    const SERIALIZABLE = 'SERIALIZABLE';

    public $db;

    private $_level = 0;


    public function begin()
    {

    }

    public function rollback()
    {

    }

    public function commit()
    {
        
    }

}