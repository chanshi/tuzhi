<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/6
 * Time: 18:14
 */

namespace tuzhi\nosql\redis\commands;

/**
 * Class SortTrait
 * @package tuzhi\nosql\redis\commands
 * SORT key [BY pattern] [LIMIT offset count] [GET pattern [GET pattern ...]] [ASC | DESC] [ALPHA] [STORE destination]
 */
trait SortTrait
{
    /**
     * @var array
     */
    protected $sort = [];

    /**
     * @param int $offset
     * @param int $count
     * @return $this
     */
    public function limit($offset = 0,$count =10)
    {
        $this->sort['limit'] = [$offset,$count];
        return $this;
    }

    /**
     * @param $patten
     * @return $this
     */
    public function sortBy( $patten )
    {
        $this->sort['by']= $patten;
        return $this;
    }

    /**
     * @param $key
     * @param array $sort
     */
    public function sort($key , $sort = [])
    {
        if(!empty($sort)){
            $this->sort = $sort;
        }
        $this->redis->sort($key,$this->sort);
    }
}