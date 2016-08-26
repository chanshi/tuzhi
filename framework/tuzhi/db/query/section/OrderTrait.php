<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 16:31
 */

namespace tuzhi\db\query\section;


use tuzhi\db\query\Query;

/**
 * Class OrderTrait
 * @package tuzhi\db\query\section
 */
trait OrderTrait
{
    /**
     * @var
     */
    public $order;

    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function orderBy($column ,$order = Query::ASC )
    {
        $this->order[] = [$column ,$order];

        return $this;
    }
}