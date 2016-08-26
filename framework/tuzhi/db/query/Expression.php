<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:34
 */

namespace tuzhi\db\query;

/**
 * Class Expression
 * @package tuzhi\db\query
 */
class Expression
{

    /**
     * @var
     */
    public $expression;

    /**
     * Expression constructor.
     * @param $expression
     */
    public function __construct( $expression )
    {
        $this->expression = $expression;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->expression;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->expression;
    }
}