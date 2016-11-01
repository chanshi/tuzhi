<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/8
 * Time: 11:35
 */

namespace tuzhi\contracts\model;

/**
 * Interface IPager
 * @package tuzhi\contracts\model
 */
interface IPager
{
    /**
     * @return mixed
     */
    public function build();

    /**
     * @return mixed
     */
    public function getPage();

    /**
     * @return mixed
     */
    public function getPageSize();

    /**
     * @return mixed
     */
    public function getTotal();

    /**
     * @return mixed
     */
    public function getTotalPage();

    /**
     * @return mixed
     */
    public function getFirstPage();

    /**
     * @return mixed
     */
    public function getPrevPage();

    /**
     * @return mixed
     */
    public function getListPage();

    /**
     * @return mixed
     */
    public function getNextPage();

    /**
     * @return mixed
     */
    public function getLastPage();
}