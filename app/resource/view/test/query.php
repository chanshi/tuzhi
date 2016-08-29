<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/30
 * Time: 11:40
 */


$view->title = 'View 测试 '.Tuzhi::frameName();

?>

<?php $view->contentBegin()?>

<h1> 测试 Query  </h1>

<?php foreach($result as $index=>$item){?>

    <div class="panel panel-default">

        <div class="panel-heading">测试 #<?= $index?></div>
        <div class="panel-body">
            <p>原始: <?= $item['sql'] ?></p>
            <p>结果: <?= $item['query']?></p>
        </div>
    </div>

<?php }?>

<?php $view->contentEnd()?>
