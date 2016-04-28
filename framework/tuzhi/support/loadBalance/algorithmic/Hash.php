<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:42
 */

namespace tuzhi\support\loadBalance\algorithmic;

use tuzhi\support\loadBalance\Algorithmic;

/**
 * Class Hash
 * @package tuzhi\support\loadBalance\algorithmic
 */
class Hash extends Algorithmic
{

    /**
     * @var
     */
    public $key;

    /**
     * @return mixed
     */
    public function getServer()
    {
        $index = $this->mHash($this->key) % $this->count();
        return $this->pool[$index];
    }

    /**
     *
     * @param $key
     * @return int
     */
    private function mHash($key)
    {
        $md5 = substr( md5($key),0,8);
        $seed = 31;
        $hash = 0;

        for( $i=0;$i < 8; $i++){
            $hash = $hash * $seed + ord( $md5{$i} );
        }
        return $hash & 0x7FFFFFFF;
    }
}