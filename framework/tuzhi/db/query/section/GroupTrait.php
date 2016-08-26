<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 16:27
 */

namespace tuzhi\db\query\section;


trait GroupTrait
{
    /**
     * @var
     */
    public $group;

    /**
     * @param $column
     * @return $this
     */
    public function groupBy( $column  )
    {
        $column = $this->db->quoteColumn($column);
        $this->group[] = [$column];

        return $this;
    }
}