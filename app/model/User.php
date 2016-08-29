<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:58
 */

namespace app\model;


use tuzhi\db\active\ActiveRecord;
use tuzhi\db\query\InsertQuery;
use tuzhi\model\Model;

class User extends ActiveRecord
{

    protected $denyUpdateColumns =['createTime'];

    /**
     * @return array
     */
    public function getLabels()
    {
        return $this->attributeLabel =
            [
                'userName'=>'用户名',
                'password'=>'密码',
                'createTime'=>'创建时间',
                'lastTime'=>'最后时间'
            ];
    }

    /**
     * 获取规则      insert / update 主要这两个规则
     */
    public function getRules()
    {
        return $this->rules =
            [
                ['userName','null'],
                ['password','null'],
                ['createTime','null'],
                ['lastTime','null']
            ];
    }

}