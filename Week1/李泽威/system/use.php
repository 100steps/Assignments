
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>详细信息</title>
</head>
<body>
<!--退出函数-->
<script>
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>




<!--登录验证-->
<?php
require_once "fun.php";
logTest();




//    链接数据库
$pdo = connect();

$id=$_GET['id'];
$sql = "SELECT *FROM student WHERE id=$id";
$stm=$pdo->query($sql);
if ($stm->rowCount()){
    $arr = $stm->fetch(PDO::FETCH_ASSOC);
}else{
    die("没有要修改的数据;window.history.back();<script>alert('没有要修改的数据');window.history.back();</script>");
}
?>



<!--表单信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <?php

    $sql_s="SELECT *FROM student  WHERE id='$_GET[myid]'";  ///学生老师判断
    $stm_s=$pdo->query($sql_s);
    $arr_s=$stm_s->fetch(PDO::FETCH_ASSOC);


    //    身份判断区分
    if ($_GET['myid']=='root'){
        echo "<a href='index_sup.php?id=$_GET[myid]&myid=$_GET[myid]' >主页    </a>
              <a href='edit.php?id=$_GET[id]&myid=root'>  个人信息修改</a>
              <a href='javascript:Logout()' >退出登陆</a>";

    }else{
        echo "<a href='index.php?id=$_GET[myid]&myid=$_GET[myid] ' >主页 </a>    ";


    }

    if ($_GET['id']!=$_GET['myid']){

    }else{
        echo "<a href='edit.php?id=$_GET[id]&myid=$_GET[myid]'>个人信息修改</a>
               <a href='javascript:Logout()' >退出登陆</a>";
    }
    ?>
</div>




<!--信息输入-->
<div align="center">
    <h2 >个人信息</h2>
    <form action="action.php?action=Edt_pw&id=<?php echo $id ?>  " method="post"  >
        <table  >
            <tr>
                <td>
                    头像:
                </td>
                <td>
                    <?php
                    echo "<img src='tou/$arr[image]'  >";
                    ?>
                </td>
            </tr>
            <tr>
            <tr>
                <td>
                    姓名:
                </td>
                <td>
                    <?php echo "{$arr['name']}"  ?>
                </td>
            </tr>
            <tr>
                <td>
                    学号:
                </td>
                <td>
                    <?php echo "{$arr['studyid']}"  ?>
                </td>
            </tr>
            <tr>
                <td>
                    年龄:
                </td>
                <td>
                    <?php echo "{$arr['age']}"  ?>
                </td>
            </tr>
            <tr>
                <td>
                    班级:
                </td>
                <td>
                    <?php echo "{$arr['class']}"  ?>
                </td>
            </tr>
            <tr>
                <td>
                    性别:
                </td>
                <td>
                    <?php echo "{$arr['sex']}"  ?>
                </td>
            </tr>
            <tr>
                <td>
                    身份：
                </td>
                <td>
                    <?php echo "{$arr['identity']}"  ?>
                </td>

            <tr>
                <td>
                    身份证类型：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'or $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['idtype']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    身份证号码：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['idnub']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    出生日期：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['birth']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    联系电话：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['telenub']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    户籍：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['home']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            </tr>
            <tr>
                <td>
                    民族：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['nation']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    受过的奖励/处分：
                </td>
                <td>
                    <?php
                    if(@$arr_s['identity']=='teacher'|| $_GET['myid']=='root'|| $_GET['id']==$_GET['myid']){
                        echo "{$arr['award']}";
                    }else{
                        echo "权限不足，无法查看";
                    }
                    ?>
                </td>
            </tr>


        </table>


    </form>
</div>
</body>
</html>