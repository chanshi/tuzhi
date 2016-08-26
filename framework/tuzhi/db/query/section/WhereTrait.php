<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 15:35
 */

namespace tuzhi\db\query\section;


use tuzhi\db\query\Query;

trait WhereTrait
{
    /**
     * @var
     */
    public $where;



    /**
     * where([a=>b,[c=>d]])
     * where(a,'=',b)
     * @param $column
     * @param null $value
     * @param string $condition
     * @return $this
     */
    public function where($column, $condition = Query::EQ ,$value = null)
    {
        if( is_array($column)){
            foreach($column as $key=>$value){
                $this->where( $key,Query::EQ,$value );
            }
        }else{
            $column = $this->db->quoteColumn($column);
            $value = $this->db->quoteValue($value);

            $this->where[] =[$column,$condition,$value];
        }

        return $this;
    }

    /**
     * @param $column
     * @param string $condition
     * @param $value
     * @return $this
     */
    public function andWhere($column ,$condition = Query::EQ ,$value)
    {
        $column = $this->db->quoteColumn($column);
        $value = $this->db->quoteValue($value);

        $where = $this->where;
        $this->where = [];
        $this->where[] = [ $where, Query::AND , [$column , $condition ,$value] ];
        return $this;
    }

    /**
     * @param $column
     * @param $condition
     * @param $value
     * @return $this
     */
    public function orWhere($column ,$condition ,$value)
    {
        $column = $this->db->quoteColumn($column);
        $value = $this->db->quoteValue($value);

        $where = $this->where;
        $this->where = [];
        $this->where[] = [ $where, Query::OR , [$column , $condition ,$value] ];

        return $this;
    }

    public function andLike($column,$value)
    {
        $column = $this->db->quoteColumn($column);
        $value = $this->db->quoteValue($value);

        $this->where[] = [$column,Query::LIKE,$value];
        
        return $this;
    }
    
    public function andNotLike( $column ,$value )
    {
        $column = $this->db->quoteColumn($column);
        $value = $this->db->quoteValue($value);

        $this->where[] = [$column,Query::NOT_LIKE,$value];

        return $this;
    }

    public function andIsNull( $column )
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] = [$column,Query::IS_NULL];
        return $this;
    }

    public function andIsNotNull( $column )
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] = [$column,Query::IS_NOT_NULL];
        return $this;
    }
    
    
    /**
     * @param $field
     * @param $value
     * @return $this
     */
    public function andIn($column ,$value)
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] = [$column, Query::IN ,$value];

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @return $this
     */
    public function andNotIn($column,$value)
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] =[$column, Query::NOT_IN ,$value];

        return $this;
    }

    /**
     * @param $column
     * @param $star
     * @param $end
     * @return $this
     */
    public function andBetween( $column ,$star,$end )
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] = [$column,Query::BETWEEN,$star,$end];

        return $this;
    }

    /**
     * @param $column
     * @param $star
     * @param $end
     * @return $this
     */
    public function andNotBetween($column,$star,$end)
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] = [$column ,Query::NOT_BETWEEN,$star,$end];

        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function andExists( $column ,$value)
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] =[$column,Query::EXISTS,$value];

        return $this;
    }

    /**
     * @param $column
     * @param $value
     * @return $this
     */
    public function withNotExists( $column ,$value )
    {
        $column = $this->db->quoteColumn($column);
        $this->where[] =[$column,Query::NOT_EXISTS,$value];

        return $this;
    }

}