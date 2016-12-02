<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 15:51
 */

namespace tuzhi\support\profiler;

use tuzhi\model\ArrayData;

/**
 * Class Data
 * @package tuzhi\support\profiler
 */
class Collection extends ArrayData
{
    /**
     * @return array
     */
    public function collect()
    {
        return [ strtolower( basename( str_replace('\\','//',get_called_class())) )=>$this->toArray()];
    }

}