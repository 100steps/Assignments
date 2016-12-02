
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改信息</title>
</head>
<body>
<!--退出函数的设定-->
<script>
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>





<!--登录验证-->
<?php

//    链接数据库
require_once "fun.php";
$pdo = connect();
logTest();

$id=$_GET['id'];
$sql = "SELECT *FROM student WHERE id=$id";
$stm=$pdo->query($sql);
if ($stm->rowCount()){
    $arr = $stm->fetch(PDO::FETCH_ASSOC);
}else{
    die("<script>alert('没有要修改的数据');window.history.back();</script>");
}

?>



<!--表单标题信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <?php
    if ($_GET['myid']=='root'){
        echo "<a href='index_sup.php?myid=$_GET[myid]&id=$_GET[myid]' >主页</a>";
    }else{
        echo "<a href='index.php?myid=$_GET[myid]&id=$_GET[myid]' >主页</a>";
    }

    echo "  
                  <a href='edit.php?id=$_GET[id]&myid=$_GET[myid]' >返回个人信息修改</a>
                  <a href='javascript:Logout()' >退出登陆<a>";
    ?>

</div>


<!--表单个人信息-->
<div align="center">
    <h2 >修改密码</h2>
    <form action="action.php?action=Edt_pw&id=<?php echo $id ?>&myid=<?php echo $_GET['myid'] ?>"   method="post"  >
        <table  >
            <tr>
                <td>姓名</td>
                <td>
                    <?php echo "{$arr['name']}"  ?>
                </td>
            </tr>
            <tr>
                <td>学号:</td>
                <td>
                    <?php echo "{$arr['studyid']}"  ?>
                </td>
            </tr>
            <tr>
                <td>年龄:</td>
                <td>
                    <?php echo "{$arr['age']}"  ?>
                </td>
            </tr>
            <tr>
                <td>班级:</td>
                <td>
                    <?php echo "{$arr['class']}"  ?>
                </td>
            </tr>
            <tr>
                <td>性别:</td>
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
            </tr>

            <tr>
                <td>
                    原密码：
                </td>
                <td>
                    <input name="pw1" type="password">
                </td>
            </tr>
            <tr>
                <td>
                    新密码：
                </td>
                <td>
                    <input name="pw2" type="password">
                </td>
            </tr>
            <tr>
                <td>
                    确认密码：
                </td>
                <td>
                    <input name="pw3" type="password">
                </td>
            </tr>



            <tr>
                <td></td>
                <td>
                    <input  type="submit" value="修改">
                    <input  type="reset" value="重置">
                </td>
            </tr>

        </table>


    </form>
</div>
</body>
</html>