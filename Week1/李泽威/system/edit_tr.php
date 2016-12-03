
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



//    链接数据库
require_once "fun.php";
$pdo = connect();
logTest();
getTest("t");



//教师和学生的不同审核方向
$id_tr=$_GET['id'];
if ($_GET['t']=='1') {
    $sql = "SELECT *FROM edit_t WHERE id_tr=$id_tr";
}else{
    $sql = "SELECT *FROM edit WHERE id_tr=$id_tr";
}

$stm=$pdo->query($sql);
if ($stm->rowCount()){
    $arr = $stm->fetch(PDO::FETCH_ASSOC);
}else{
    die("<script>alert('没有要修改的数据');window.history.back();</script>");
}
?>




<!--表单信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <?php
    if($_GET['myid']=="root"){
        echo "    <a href='index_sup.php?id=root&myid=root' >主页 </a>";
    }else{
        echo "    <a href='index.php?id=$_GET[myid]&myid=$_GET[myid]' >主页 </a>";
    }
    ?>

    <a href='javascript:Logout()' >退出登陆</a>
</div>

<div align="center">
    <h2 >个人信息</h2>
    <form action="action.php?action=Edt&id=<?php echo $arr['id']?>&myid=<?php echo $arr['id']?> " method="post"  >
            <tr>
                <table  >
                <td>
                    头像:
                </td>
                <td>
                    <?php
                    if (empty($arr['image'])){
                        echo "未修改头像";
                    }   else{
                        echo " <img src='tou/$arr[image]'  >";
                    }
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
                    echo "{$arr['idtype']}";
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    身份证号码：
                </td>
                <td>
                    <?php
                    echo "{$arr['idnub']}";
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    出生日期：
                </td>
                <td>
                    <?php
                    echo "{$arr['birth']}";
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    联系电话：
                </td>
                <td>
                    <?php
                    echo "{$arr['telenub']}";
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    户籍：
                </td>
                <td>
                    <?php
                    echo "{$arr['home']}";
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
                    echo "{$arr['nation']}";
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    受过的奖励/处分：
                </td>
                <td>
                    <?php
                    echo "{$arr['award']}";
                    ?>
                </td>
            </tr>

        </table>



        <!--        是否通过审核的验证-->
        <div style="text-align: center">
            <h4 >是否审核通过</h4>
            <?php
            if ($_GET['t']=='1'){
                echo"              <a href='action.php?action=Etr&id=$arr[id_tr]&myid=root&t=1 ' >是</a>
                                   <a href='action.php?action=Etr&id=$arr[id_tr]&myid=root&t=2 ' >否</a>";

            }else{
                echo "           <a href='action.php?action=Etr&id=$arr[id_tr]&myid=$_GET[myid]&t=3 ' >是</a>
                                   <a href='action.php?action=Etr&id=$arr[id_tr]&myid=$_GET[myid]&t=4 ' >否</a>";

            };



            ?>
        </div>



    </form>
</div>
</body>
</html>