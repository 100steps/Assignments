
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>学生信息管理</title>
</head>
<body>
<!--退出函数-->
<script>
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>








<?php


//    链接数据库
require_once "fun.php";
$pdo = connect();
logTest();

//学生老师身份判断
$sql="SELECT *FROM student  WHERE id='$_GET[myid]'";
$stm=$pdo->query($sql);
$arr=$stm->fetch(PDO::FETCH_ASSOC);


?>




<!--表单信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <a href="index.php?id=<?php  echo $_GET['myid'] ?>&myid=<?php  echo $_GET['myid'] ?>" >主页</a>
    <a href="use.php?id=<?php  echo $_GET['myid'] ?>&myid=<?php  echo $_GET['myid'] ?>">个人信息</a>
    <a href="javascript:Logout()" >退出登陆</a>
</div>


<!--老师与学生的区分-->
    <h2 style="text-align: center">
        <?php if ($arr['identity']=='student') {
            echo "任课老师信息";
        }else{
            echo "所教学生信息";
        }
        ?>
    </h2>

    <table width="100%" border="1" >
    <tr>
    <th>ID</th>
    <th>学号</th>
    <th>姓名</th>
    <th>年龄</th>
    <th>性别</th>
    <th>班级</th>
    <th>身份</th>
    <th>操作</th>
    </tr>
        <?php








        //翻页配置
        $sql_x= "select count(*) as amount from student WHERE identity='teacher' ";

        $stm_x= $pdo->query($sql_x);
        $arr_x = $stm_x->fetch(PDO::FETCH_ASSOC);
        $amonutx=$arr_x['amount'];
        $pagesizex=10;
        $pagex=@$_GET['pagex'];
        if (empty($pagex)){
            $pagex=1;
        }
        $gox=($pagex-1)*$pagesizex;
        $endx=$pagex*$pagesizex;
        if ($amonutx%$pagesizex==0){
            $pagemountx=$amonutx/$pagesizex;
        }else{
            $pagemountx=intval($amonutx/$pagesizex)+1;
        }



        //翻页参数设置
        $page_stringx = "";
        if( $pagex == 1 ){
            $page_stringx .= '第一页|上一页|';
        }
        else{
            $page_stringx .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&pagex=1>第一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&pagex='.($pagex-1).'>上一页</a>|';
        }
        if( ($pagex == $pagemountx) || ($pagemountx == 0) ){
            $page_stringx .= '下一页|尾页';
        }
        else{
            $page_stringx .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&pagex='.($pagex+1).'>下一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&pagex='.$pagemountx.'>尾页</a>';
        }

        echo "   <tr>$page_stringx</tr>";






        //表单输出
        if ($arr['identity']=='student'){
            $sql="SELECT *FROM student  WHERE identity='teacher'&&class='$arr[class]' limit $gox,$endx ";

        }else{
            $sql="SELECT *FROM student  WHERE identity='student'&&class='$arr[class]' limit $gox,$endx ";

        }

            foreach ($pdo->query($sql) as $val){

                echo "<tr>
               <td>{$val['id']}</td>
                <td>$val[studyid]</td>
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex]</td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td><a href='use.php?id=$val[id]&myid=$_GET[myid]'>查看</a></td>

               </tr>";
            }


        ?>


    </table>




<!--学生审核表单-->
<?php
if ($arr['identity']=='teacher') {
    echo "<h2 style=\"text-align: center\">学生审核信息管理</h2>
<table width=\"100%\" border=\"1\" >
    <tr>
        <th>审核码</th>
        <th>ID</th>
        <th>学号</th>       
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>班级</th>
        <th>身份</th>
        <th>操作</th>
    </tr>";




    //翻页配置
    $sql_z = "select count(*) as amount from edit ";

    $stm_z = $pdo->query($sql_z);
    $arr_z = $stm_z->fetch(PDO::FETCH_ASSOC);
    $amonutz = $arr_z['amount'];
    $pagesizez = 10;
    $pagez = @$_GET['pagez'];
    if (empty($pagez)) {
        $pagez = 1;
    }
    $goz = ($pagez - 1) * $pagesizez;
    $endz = $pagez * $pagesizez;
    if ($amonutz % $pagesizez == 0) {
        $pagemountz = $amonutz / $pagesizez;
    } else {
        $pagemountz = intval($amonutz / $pagesizez) + 1;
    }


//    翻页参数设置
    $page_stringz = "";
    if ($pagez == 1) {
        $page_stringz .= '第一页|上一页|';
    } else {
        $page_stringz .= '<a href=?id='.$_GET['id'].'&myid=' . $_GET['myid'] . '&pagez=1>第一页</a>|<a href=?id='.$_GET['id'].'&myid=' . $_GET['myid'] . '&pagez=' . ($pagez - 1) . '>上一页</a>|';
    }
    if (($pagez == $pagemountz) || ($pagemountz == 0)) {
        $page_stringz .= '下一页|尾页';
    } else {
        $page_stringz .= '<a href=?id='.$_GET['id'].'&myid=' . $_GET['myid'] . '&pagez=' . ($pagez + 1) . '>下一页</a>|<a href=?id='.$_GET['id'].'&myid=' . $_GET['myid'] . '&pagez=' . $pagemountz . '>尾页</a>';
    }

    echo "   <tr>$page_stringz</tr>";




    //学生审核信息输出
    $sql = "SELECT *FROM edit WHERE identity='student' limit $goz,$endz ";
    foreach ($pdo->query($sql) as $val) {

        echo "<tr>
               <td>{$val['id_tr']}</td>
               <td>{$val['studyid']}</td>
               <td>{$val['id']}</td>
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex] </td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td>
                   <a href='edit_tr.php?id=$val[id_tr]&myid=$_GET[myid]&t=3'>查看</a>
              </td>
               </tr>";
    }
}
    ?>

</table>
</body>
</html>