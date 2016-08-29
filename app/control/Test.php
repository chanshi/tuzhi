<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:38
 */

namespace app\control;

use app\model\User;
use Tuzhi;
use tuzhi\db\query\Expression;
use tuzhi\db\query\InsertQuery;
use tuzhi\db\query\Query;
use tuzhi\route\Controller;
use tuzhi\log\Log;
use tuzhi\cache\Cache;

/**
 * Class Test
 * @package app\control
 */
class Test extends Controller
{

    /**
     * 测试视图
     * @return mixed|void
     */
    public function  ViewAction()
    {

        //Log::Notice('test');


        //Cache::File()->set('test',1);

        $db =\Tuzhi::App()->db();

        $result = $db->createCommand('SHOW STATUS')->queryAll();

        return json_encode($result);

        //return  Cache::File()->increment('test');

        //return \Tuzhi::$app->view()->renderPage('index/index');
    }

    /**
     * @return mixed 打印 phpinfo
     */
    public function infoAction()
    {
        return phpinfo();
    }

    /**
     * 数据测试
     */
    public function dataAction()
    {
        $data=[
            'userName'=>'wo',
            'password'=>md5('wo'),
            'createTime'=>time(),
            'lastTime'=>time()
        ];

        //print_r(User::find()->where('userId','=','2')->all());

        //echo User::insert($data);
        //echo User::update()->where(['userId'=>2])->update(['userName'=>'sb1']);
        //echo User::delete()->where(['userId'=>1])->delete();
        exit;
    }

    /**
     * @return mixed 查询测试
     */
    public function queryAction()
    {
        $result =[];
        // test 1
        $test['sql'] = 'select *';
        $test['query'] = (new Query());
        $result[] = $test;

        // test 2
        $test['sql'] = 'select a,b,c from table where a=b and c=d GROUP BY 1  HAVING  count(*) > 1 order by 1 desc limit 10';
        $test['query'] =(new Query())
            ->select(['a','b','c'])
            ->table('table')
            ->where(['a'=>'b','c'=>'d'])
            ->groupBy('1')
            ->having(new Expression('count(*)'),'>',1)
            ->orderBy('1',Query::DESC)
            ->limit(10);
        $result[] = $test;

        // test 3
        $test['sql'] = 'select * from user as a left join log as b on a.id=b.id ';
        $test['query'] =(new Query())
            ->table('user','a')
            ->leftJoin('log','b','a.id=b.id');
        $result[] =$test;

        // test 4
        $test['sql'] = 'select * from user as a left join ( select id from log  ) as b on a.id = b.id ';
        $test['query'] = (new Query())
            ->select('*')
            ->table('user','a')
            ->leftJoin( (new Query())
                ->select('id')
                ->table('log')
                ,'b','a.id = b.id');
        $result[] =$test;

        return Tuzhi::App()->view()->renderPage('test/query',[
            'result'=>$result
        ]);
    }


    //***  测试H5 录音

    public function audioAction()
    {
        return Tuzhi::App()->view()->renderPage('test/audio');
    }

    /**
     *
     */
    public function modelAction()
    {
        //$model = new \app\model\Test();

        //$data = ['id'=>1,'userId'=>6,'value'=>'pic'];

        //Tuzhi::App()->db()->createCommand((new InsertQuery('test',$data)))->execute();
        //print_r(Tuzhi::App()->db()->getSchema()->getLastInsertId('userId'));

        //print_r(\app\model\Test::insert(['id'=>1,'userId'=>2,'value'=>'pic']));

        $model = User::getRecord(2);

        //step 1
        //echo $model->userName;

        $model['userName'] = '我是好人';
        if( ! $model->save()){
            print_r($model>getErrors());
        }

    }
}