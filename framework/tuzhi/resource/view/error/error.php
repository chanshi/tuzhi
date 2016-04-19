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
            <a class="navbar-brand" href="#"><?php echo Tuzhi::frameName()?></a>
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
        <h1><?php echo  'Exception'  ?></h1>
    </div>
    <p class="lead"> <code> <?php echo $exception->getMessage()?> </code> </p>
    <p><?php echo $exception->getFile()?> ( <?php echo $exception->getLine() ?>  )</p>

</div>

<!-- Footer  -->
<footer class="footer">
    <div class="container">
        <p class="text-muted"><?php echo date('Y',time()).' '.Tuzhi::frameName().' '.Tuzhi::frameVersion()?></p>
    </div>
</footer>
