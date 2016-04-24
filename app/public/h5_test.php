<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/22
 * Time: 14:54
 */
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<video id="myVideo" autoplay="autoplay"></video>
<br />
<input type="button" value="拍照" /><br />
拍照结果：
<div id="result"></div>
<script type="text/javascript">
    $(document).ready(init);
    function init() {
//为了便于使用这个接口，先做一下兼容性处理
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        //Google Chrome用webkitGetUserMedia，Firefox用mozGetUserMedia
        navigator.getUserMedia({video:true}, success, error);  //显示影像
        //定义button点击后要做什麼
        $("input[type='button']").click(function () {
            shoot(); //执行拍照
        });
    }
    function success(stream) {
        // window.URL.createObjectURL   window.webkitURL.createObjectURL
        $("#myVideo").attr("src", URL.createObjectUR( stream ) );
        $("#myVideo").play();
    }
    function error(error) {
        alert(error.name || error);
    }
    //拍照
    function shoot() {
        var video = $("#myVideo")[0];
        var canvas = capture(video);
        $("#result").empty();
        $("#result").append(canvas); //呈现图像(拍照结果)
        var imgData = canvas.toDataURL("image/jpg");
        var base64String = imgData.substr(22); //取得base64字串
        //上传，储存图片
        $.ajax({
            url: "vod/avatar.php",
            type: "post",
            data: { data: base64String },
            async: true,
            success: function (htmlVal) {
                alert("另存图片成功！");
            }, error: function (e) {
                alert(e.responseText); //alert错误信息
            }
        });
    }
    //从video元素抓取图像到canvas
    function capture(video) {
        var canvas = document.createElement('canvas'); //建立canvas js DOM元素
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);
        return canvas;
    }
</script>
</body>
</html>
