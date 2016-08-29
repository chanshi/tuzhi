<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/29
 * Time: 10:39
 */

namespace tuzhi\view\widget;


use tuzhi\view\Widget;

class BlockWidget extends Widget
{
    /**
     * @var
     */
    protected $block;

    /**
     * @return mixed
     */
    public function run()
    {
        return $this->block;
    }
}