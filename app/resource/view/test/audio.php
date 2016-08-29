<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/9
 * Time: 15:13
 */

$view->title = 'Audio Html 5 底层驱动测试';

?>

<?php $view->contentBegin()?>
<h1><?= $view->title?></h1>
<video id="webcam"></video>
<script>
    //window.AudioContext = window.AudioContext || window.webkitAudioContent;

    if( ! navigator.getUserMedia ){
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
    }

    if( navigator.getUserMedia ){
        navigator.getUserMedia(
            {
                "video" : true,
                "audio" : true
            },
            function ( stream ){
                var video = document.getElementById('webcam');
                if( window.URL ){
                    video.src = window.URL.createObjectURL(stream);
                }else{
                    video.src = stream;
                }
                video.autoplay = true;
            },
            function (){
                console.log('not support');
            }
        );
    }else{
        console.log('not support getUserMedia');
    }

</script>
<?php $view->contentEnd()?>
