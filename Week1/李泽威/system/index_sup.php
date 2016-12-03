<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>超级用户</title>
</head>
<body>
<!--删除和退出函数-->
<script>
    function doDel(id) {
        if (confirm("确定删除吗？"))
            window.location="action.php?action=Del&myid=root&id="+id;
    }
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>




<!--登录验证-->
<?php
require_once "fun.php";
logTest();
?>



<!--表单信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <a href="xls.php?id=root&myid=root&t=3" >学生信息导出</a>
    <a href="xls.php?id=root&myid=root&t=1" >老师信息导出</a>
</div>
<div style="text-align: center">

    <a href="index_sup.php?myid=root&id=root" >主页</a>
    <a href="add.php?myid=root&id=root" >添加用户</a>
    <a href="javascript:Logout()" >退出登陆</a>
</div>


<div style="text-align: center">
    <!--    搜索功能-->
    <h4 >搜索信息</h4>
    <form action="search.php?id=root&myid=root" method="post">
        <select name="type">
            <option value="id">id</option>
            <option value="studyid">学号</option>
            <option value="name">姓名</option>
            <option value="age">年龄</option>
            <option value="sex">性别</option>
            <option value="class">班级</option>
            <option value="identity">身份</option>
            <option value="birth">生日</option>
            <option value="idtype">身份证类型</option>
            <option value="idnub">身份证号码</option>
            <option value="telenub">电话号码</option>
            <option value="nation">民族</option>
        </select>
        <input type="text" name="name">
        <input type="submit" value="搜索">
    </form>
</div>






<h2 style="text-align: center">教师信息管理</h2>
<table width="100%" border="1" >
    <tr>
        <th>ID</th>
        <th>学号</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>班级</th>
        <th>身份</th>
        <th>密码</th>
        <th>操作</th>
    </tr>



    <?php
    //链接数据库
    $pdo = connect();


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





    //教师信息输出
    $sql="SELECT *FROM student WHERE  identity='teacher' limit $gox,$endx ";
    foreach ($pdo->query($sql)  as  $val){

        echo "<tr>
               <td>{$val['id']}</td>
                <td>{$val['studyid']}</td>
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex]</td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td>$val[password]</td>
               <td><a href='javascript:doDel($val[id])'>删除</a>
                   <a href='use.php?id=$val[id]&myid=$_GET[myid]'>查看/修改</a>
              </td>
               </tr>";
    }
    ?>

</table >



<!--学生信息-->
<h2 style="text-align: center">学生信息管理</h2>
<table width="100%" border="1" >
    <tr>
        <th>ID</th>
        <th>学号</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>班级</th>
        <th>身份</th>
        <th>密码</th>
        <th>操作</th>
    </tr>

    <?php

    //学生翻页配置

    $sql_s= "select count(*) as amount from student WHERE identity='student'";

    $stm_s= $pdo->query($sql_s);
    $arr_s = $stm_s->fetch(PDO::FETCH_ASSOC);
    $amonut=$arr_s['amount'];
    $pagesize=10;
    $page=@$_GET['page'];
    if (empty($page)){
        $page=1;
    }
    $go=($page-1)*$pagesize;
    $end=$page*$pagesize;
    if ($amonut%$pagesize==0){
        $pagemount=$amonut/$pagesize;
    }else{
        $pagemount=intval($amonut/$pagesize)+1;
    }


    //学生翻页参数设置
    $page_string = "";
    if( $page == 1 ){
        $page_string .= '第一页|上一页|';
    }
    else{
        $page_string .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&page=1>第一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&page='.($page-1).'>上一页</a>|';
    }
    if( ($page == $pagemount) || ($pagemount == 0) ){
        $page_string .= '下一页|尾页';
    }
    else{
        $page_string .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&page='.($page+1).'>下一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&page='.$pagemount.'>尾页</a>';
    }

    echo "   <tr>$page_string</tr>";




    //学生信息输出
    $sql="SELECT *FROM student WHERE  identity='student' limit $go,$end ";
    foreach ($pdo->query($sql)  as  $val){

        echo "<tr>
               <td>{$val['id']}</td>
                <td>{$val['studyid']}</td>
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex]</td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td>$val[password]</td>
               <td><a href='javascript:doDel($val[id])'>删除</a>
                   <a href='use.php?id=$val[id]&myid=$_GET[myid]'>查看/修改</a>
              </td>
               </tr>";
    }
    ?>

</table>







<!--老师审核信息-->
<h2 style="text-align: center">教师审核信息管理</h2>
<table width="100%" border="1" >
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
    </tr>

    <?php


    //老师审核翻页配置
    $sql_t= "select count(*) as amount from edit_t ";

    $stm_t= $pdo->query($sql_t);
    $arr_t = $stm_t->fetch(PDO::FETCH_ASSOC);
    $amonutt=$arr_t['amount'];
    $pagesizet=10;
    $paget=@$_GET['paget'];
    if (empty($paget)){
        $paget=1;
    }
    $got=($paget-1)*$pagesizet;
    $endt=$paget*$pagesizet;
    if ($amonutt%$pagesizet==0){
        $pagemountt=$amonutt/$pagesizet;
    }else{
        $pagemountt=intval($amonutt/$pagesizet)+1;
    }



    //老师审核翻页参数设置
    $page_stringt = "";
    if( $paget == 1 ){
        $page_stringt .= '第一页|上一页|';
    }
    else{
        $page_stringt .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&paget=1>第一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&paget='.($paget-1).'>上一页</a>|';
    }
    if( ($paget == $pagemountt) || ($pagemountt == 0) ){
        $page_stringt .= '下一页|尾页';
    }
    else{
        $page_stringt .= '<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&paget='.($paget+1).'>下一页</a>|<a href=?id='.$_GET['id'].'&myid='.$_GET['myid'].'&paget='.$pagemountt.'>尾页</a>';
    }

    echo "   <tr>$page_stringt</tr>";




    //教师审核信息输出
    $sql="SELECT *FROM edit_t limit $got,$endt ";
    foreach ($pdo->query($sql)  as  $val){

        echo "<tr>
               <td>{$val['id_tr']}</td>
               <td>{$val['id']}</td>
               <td>{$val['studyid']}</td>               
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex]</td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td>
                   <a href='edit_tr.php?id=$val[id_tr]&myid=root&t=1'>查看</a>
              </td>
               </tr>";
    }
    ?>

</table>






<!--学生审核信息-->
<h2 style="text-align: center">学生审核信息管理</h2>
<table width="100%" border="1" >
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
    </tr>


    <?php
    //学生审核翻页配置
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




    //学生审核翻页参数设置
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
    $sql = "SELECT *FROM edit limit $goz,$endz ";
    foreach ($pdo->query($sql) as $val) {

        echo "<tr>
        <td>{$val['id_tr']}</td>
        <td>{$val['id']}</td>
        <td>{$val['studyid']}</td>
        <td>$val[name]</td>
        <td>$val[age]</td>
        <td>$val[sex]</td>
        <td>$val[class]</td>
        <td>$val[identity]</td>
        <td>
            <a href='edit_tr.php?id=$val[id_tr]&myid=$_GET[myid]&t=3'>查看</a>
        </td>
    </tr>";
    }

    ?>

</table>

</body>
</html>