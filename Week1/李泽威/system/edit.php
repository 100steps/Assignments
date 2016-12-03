
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改信息</title>
</head>
<body>
<!--退出函数-->
<script>
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>





<!--登入验证和在线验证-->
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
    die("没有要修改的数据");
}

?>




<!--表单信息-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <?php
    if ($_GET['myid']=='root'){
        echo "<a href='index_sup.php?myid=$_GET[myid]&id=$_GET[myid]' >主页</a>";
    }else{
        echo "<a href='index.php?myid=$_GET[myid]&id=$_GET[myid]' >主页</a>";
    }

        echo "   
                  <a href='use.php?id=$_GET[id]&myid=$_GET[myid]' >个人信息</a>
                  <a href='edit_pw.php?id=$_GET[id]&myid=$_GET[myid] '>密码修改</a>
                  <a href='javascript:Logout()' >退出登陆<a>";

    ?>





<div align="center">
    <h2 >修改信息</h2>
    <?php

    //不同身份修改信息的跳转
    if ($_GET['myid']=='root'){
        echo"     <form action=\"action.php?action=Edt&id=$_GET[id]&myid=root\" method=\"post\"  enctype=\"multipart/form-data\"> ";
    }elseif ($arr['identity']=='teacher'){
        echo"     <form action=\"action.php?action=Tra&id=teacher&myid=$_GET[myid]\" method=\"post\"  enctype=\"multipart/form-data\"> ";
    }else{
        echo"     <form action=\"action.php?action=Tra&id=student&myid=$_GET[myid]\" method=\"post\"  enctype=\"multipart/form-data\"> ";
    }
    ?>




<!--    信息的录入-->
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
                <td>
                    上传头像:
                </td>
                <td>
                    <input name="file" type="file"   >
                </td>
            </tr>

            <tr>
            <td>
                姓名:
            </td>
            <td>
                <input name="name" type="text" value="<?php echo "{$arr['name']}"  ?>">
            </td>
            </tr>
            <tr>
                <td>
                    学号:
                </td>
                <td>
                    <input name="id_st" type="hidden" value="<?php echo "{$arr['studyid']}"?>">
                  <?php echo "{$arr['studyid']}"?>
                </td>
            </tr>
            <tr>
                <td>
                    年龄:
                </td>
                <td>
                    <select name="age">
                        <option value="">年龄</option>
                        <?php
                        for ($i=1;$i<100;$i++ ){
                            $jud=($arr['age']==$i)?"selected":"" ;
                            echo "<option value=$i $jud >$i</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    班级:
                </td>
                <td>
                    <select name="class">
                        <option value ="">班级</option>
                        <option value ="g1b1" <?php echo ($arr['class']=='g1b1')?"selected":""  ?>>高一（1）班</option>
                        <option value ="g1b2" <?php echo ($arr['class']=='g1b2')?"selected":""  ?>>高一（2）班</option>
                        <option value ="g1b3" <?php echo ($arr['class']=='g1b3')?"selected":""  ?>>高一（3）班</option>
                        <option value ="g1b4" <?php echo ($arr['class']=='g1b4')?"selected":""  ?>>高一（4）班</option>
                        <option value ="g2b1" <?php echo ($arr['class']=='g2b1')?"selected":""  ?>>高二（1）班</option>
                        <option value ="g2b2" <?php echo ($arr['class']=='g2b2')?"selected":""  ?>>高二（2）班</option>
                        <option value ="g2b3" <?php echo ($arr['class']=='g2b3')?"selected":""  ?>>高二（3）班</option>
                        <option value ="g2b4" <?php echo ($arr['class']=='g2b4')?"selected":""  ?>>高二（4）班</option>
                        <option value ="g3b1" <?php echo ($arr['class']=='g3b1')?"selected":""  ?>>高三（1）班</option>
                        <option value ="g3b2" <?php echo ($arr['class']=='g3b2')?"selected":""  ?>>高三（2）班</option>
                        <option value ="g3b3" <?php echo ($arr['class']=='g3b3')?"selected":""  ?>>高三（3）班</option>
                        <option value ="g3b4" <?php echo ($arr['class']=='g3b4')?"selected":""  ?>>高三（4）班</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    性别:
                </td>
                <td>
                    <input name="sex" type="radio" value="male"  <?php echo ($arr['sex']=='male')?"checked":""  ?> >男
                    <input name="sex" type="radio" value="female" <?php echo ($arr['sex']=='female')?"checked":""  ?> >女
                </td>
            </tr>
            <tr>
                <td>
                    身份：
                </td>
                <td>
                    <input name="idt" type="radio" value="student"  <?php echo ($arr['identity']=='student')?"checked":""  ?> >学生
                    <input name="idt" type="radio" value="teacher" <?php echo ($arr['identity']=='teacher')?"checked":""  ?> >老师
                </td>
            </tr>

            <tr>
                <td>
                    身份证类型:
                </td>
                <td>
                    <input name="idtype" type="radio" value="town"  checked >城镇
                    <input name="idtype" type="radio" value="vill" <?php echo ($arr['idtype']=='vill')?"checked":""  ?> >农村
                </td>
            </tr>
            <tr>
                <td>
                    身份证号码:
                </td>
                <td>
                    <input name="idnub" type="text"  value="<?php echo "{$arr['idnub']}"  ?> ">
                </td>
            </tr>
            <tr>
                <td>
                    出生日期:
                </td>
                <td>
                    <input name="birth" type="text"  value="<?php echo "{$arr['birth']}"  ?> ">
                </td>
            </tr>
            <tr>
                <td>
                    联系电话:
                </td>
                <td>
                    <input name="telenub" type="text"  value="<?php echo "{$arr['telenub']}"  ?> ">
                </td>
            </tr>
            <tr>
                <td>
                    民族:
                </td>
                <td>
                    <input name="nation" type="text"  value="<?php echo "{$arr['nation']}"  ?> ">
                </td>
            </tr>
            <tr>
                <td>
                    户籍:
                </td>
                <td>
                    <input name="home" type="text"  value="<?php echo "{$arr['home']}"  ?> ">
                </td>
            </tr>
            <tr>
                <td >
                    在校期间受过奖励/处分:
                </td>
                <td>
                    <input  name="award" type="text"  value="<?php echo "{$arr['award']}"  ?> ">
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