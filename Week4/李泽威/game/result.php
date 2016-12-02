<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试结果</title>
</head>
<style>
    body {
        text-align: center;
        background: black;
    }
    #img {
        z-index: -1;
        position: absolute;
        left: 12%;
    }
    #result{
        margin-top: 25%;
        color: #c3e3b5;
        font-size: 30px;
        display: inline-block;
        z-index: 2;
    }
    a{
        text-decoration: none;
        color: #bababa;
    }
</style>
<body>
<div id="content">
    <img src="img/background2.jpg" id="img">
    <div id="result">
    <?php
        echo "$_GET[name]距离脱单还有".$_GET['time'];
    ?><br/>
        <a href="index.html">返回</a>
    </div>
</div>
</body>
</html>