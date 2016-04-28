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
 * 轮训
 * Class Round
 * @package tuzhi\support\loadBalance\algorithmic
 */
class Round extends Algorithmic
{
    /**
     * @var int
     */
    private $currentIndex = 0;


    public function getServer()
    {
        if( $this->currentIndex === $this->count() )
        {
            $this->currentIndex = 0;
        }

        $server = $this->pool[$this->currentIndex];

        $this->currentIndex++;
        //返回
        return $server;
    }
}