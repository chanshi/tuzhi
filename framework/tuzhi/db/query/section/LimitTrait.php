<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 16:43
 */

namespace tuzhi\db\query\section;

/**
 * Class LimitTrait
 * @package tuzhi\db\query\section
 */
trait LimitTrait
{
    /**
     * @var
     */
    public $limit;

    /**
     * @param $index
     * @param null $offset
     * @return $this
     */
    public function limit( $index ,$offset = null )
    {
        $this->limit = $offset
            ? [$index,$offset]
            : [$index];
        return $this;
    }
}