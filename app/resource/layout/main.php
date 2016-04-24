<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 09:29
 */

use \app\resource\asset\AppAsset;


AppAsset::register( $view );

?>
<?php $view->pageBegin()?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $view->title?></title>
    <?= $view->headTag()?>
</head>
<body>
<?= $view->bodyBeginTag()?>

<?= $content?>

<?= $view->bodyEndTag()?>
</body>
</html>
<?php $view->pageEnd()?>

