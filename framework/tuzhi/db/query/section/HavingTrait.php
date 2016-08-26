<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 16:28
 */

namespace tuzhi\db\query\section;

/**
 * Class HavingTrait
 * @package tuzhi\db\query\section
 */
trait HavingTrait
{
    /**
     * @var
     */
    public $having;

    /**
     * @param $column
     * @param $condition
     * @param $value
     * @return $this
     */
    public function having( $column , $condition , $value )
    {
        $column = $this->db->quoteColumn($column);
        $value = $this->db->quoteValue($value);

        $this->having[] = [ $column , $condition , $value ];

        return $this;
    }
    
}