<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 15:25
 */

namespace tuzhi\db\query\section;
use tuzhi\db\query\Query;

/**
 * Class SelectTrait
 * @package tuzhi\db\query\section
 */
trait SelectTrait
{

    /**
     * @var
     */
    public $select;

    /**
     * 'a,b,c,d' 以及这种情况
     *
     * @param $field
     * @param null $alias
     * @return $this
     */
    public function select( $field , $alias = null )
    {
        if( is_array($field) ){
            foreach( $field as $key=>$value ){
                if( is_numeric($key) ){
                    $this->select($value);
                }else{
                    $this->select($value,$key);
                }
            }
        }else {
            $field = $this->db->quoteColumn( $field );
            $this->select[] = $alias
                ? [$field,Query::_AS_,$alias]
                : [$field];
        }

        return $this;
    }



    /**
     * @param $field
     * @param null $alias
     * @return $this
     */
    public function avg( $field ,$alias = null )
    {
        $field = $this->db->quoteColumn( $field );
        $field = [$field,Query::F_AVG];
        $this->select[] = $alias
            ? [$field,Query::_AS_,$alias]
            : $field;
        return $this;
    }

}