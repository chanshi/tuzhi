<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 14:21
 */

namespace tuzhi\contracts\model;

/**
 * Interface IDataCollection
 * @package tuzhi\contracts\model
 */
interface IDataCollection
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return mixed
     */
    public function getPager();

    /**
     * @return mixed
     */
    public function query();

}