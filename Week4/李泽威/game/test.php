<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2016/11/11
 * Time: 18:07
 */
//bin2hex 和 ord
header("Content-Type:text/html;charset=utf8");
if (empty($_GET['name'])){
    die("<script>alert('逗我呢？');window.history.back();</script>");
}
if (!preg_match_all("/[\x{4e00}-\x{9fa5}]+|[a-zA-Z]+/u", $_GET['name'])){
    die("<script>alert('我不信这是名字');window.history.back();</script>");
}
$userName = $_GET['name'];
$userLength = strlen($userName);
$userCode = '1';
for ($i=0 ; $i<$userLength ; $i+=$userLength/3){
        if (ord($userName[$i])%10==0){
            $userCode = $userCode * 3;
        }else{
            $userCode = $userCode * (ord($userName[$i])%10)+1;
        }
}
echo $userCode;
switch ($userCode){
    case $userCode%11==0  :
        $time = "下一次和异性说话";
        header("Location:result.php?time=$time&name=$userName");
        break;

    case $userCode%7==0 :
        $time = $userCode%1000+1 . "天";
        header("Location:result.php?time=$time&name=$userName");
        break;

    case $userCode%5==0 :
        $time = $userCode%10*6+1 . "秒";
        header("Location:result.php?time=$time&name=$userName");
        break;

    case $userCode%3==0 :
        $time = $userCode%100+1 . "天";
        header("Location:result.php?time=$time&name=$userName");
        break;

    case $userCode%2==0 :
        $time = $userCode%100+1 . "月";
        header("Location:result.php?time=$time&name=$userName");
        break;

    case $userCode%2!=0 :
        $time = $userCode%10+1 . "年";
        header("Location:result.php?time=$time&name=$userName");
        break;
    default :
        $time = "还想脱单？光着吧你";
        header("Location:result.php?time=$time&name=$userName");
        break;

}