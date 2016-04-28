<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:42
 */

namespace tuzhi\support\loadBalance\algorithmic;

use tuzhi\support\loadBalance\Algorithmic;

class Weight extends Algorithmic
{

    private $minWeight = 0;

    private $maxWeight = 100;

    private $interval = [];

    /**
     * 转化下数据
     */
    public function init()
    {
        $minWeight =$maxWeight = $this->minWeight;
        foreach( $this->pool as $index=>$pool ){
            $maxWeight+= $pool->getWeight();
            $this->interval[$index] = [ $minWeight ,$maxWeight ];
            $minWeight = $maxWeight;
        }
        $this->maxWeight = $maxWeight;
    }

    /**
     * @return mixed
     */
    private function getWeight()
    {
        return rand($this->minWeight,$this->maxWeight);
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        $weight = $this->getWeight();
        $index = 0;
        foreach( $this->interval as $index =>$interval ){
            if( $weight >= $interval[0] && $weight < $interval[1] ){
               break;
            }
        }
        return $this->pool[$index];
    }
}