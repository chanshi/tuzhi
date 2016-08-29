<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/9
 * Time: 14:56
 */
?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">土制框架</a>
        </div>
        <!--div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Begin page content -->
<div class="container">
    <div class="page-header">
        <h1>
            <?php if( method_exists($exception,'getName') ){?>
                <?= $exception->getName();?>
            <?php }else{ ?>
                Exception
            <?php }?>
        </h1>
    </div>
    <p class="lead"><code> <?php echo $exception->getMessage()?> </code> </p>
    <p> <kbd> <?= $exception->getLine() ?></kbd> <?php echo $exception->getFile()?> </p>
    <br>
    <br>
    <?php if($exception->getTrace()){?>
        <div>
            <h2>TraceMessage</h2>
            <table class="table table-striped table-hover">
                <?php $index = 1; foreach( $exception->getTrace() as $item){ ?>
                    <?php if( in_array( $item['function'],
                        [
                            'autoload',
                            'spl_autoload_call',
                            'class_exists',
                            'call_user_func_array',
                            'call_user_func',
                            '__callStatic',
                            '__call'
                        ]
                    ) ){ continue; }?>
                    <tr>
                        <td><h4> #<?= $index++?></h4></td>
                        <td>
                            <p class="lead">
                                <?= isset($item['class']) ?$item['class']: null ?>
                                <?= isset($item['type']) ?$item['type']: null ?>
                                <?= isset($item['function']) ? $item['function'].'( )' : null ?>
                            </p>

                            <?php if( isset($item['file']) ){?>
                                <p>
                                    <kbd><?= isset($item['line']) ? $item['line'] : null ?></kbd>
                                    <?= isset($item['file']) ? $item['file'] : null ?>
                                </p>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
            </table>
        </div>
    <?php }?>
    <?php //print_r($exception)?>

</div>

<!-- Footer  -->
<footer class="footer">
    <div class="container">
        <p class="text-muted"><?php echo date('Y',time()).' '.Tuzhi::frameName().' '.Tuzhi::frameVersion()?> - 禅师</p>
    </div>
</footer>
