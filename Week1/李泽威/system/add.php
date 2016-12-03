
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加用户信息</title>
</head>
<body>
<script> //退出函数
    function Logout() {
        if (confirm("确定退出吗？"))
            window.location="action.php?action=Logo"
    }
</script>




<?php
//在线验证
require_once "fun.php";
logTest();
?>



<!--菜单表格-->
<div style="text-align: center">
    <h1 >中学生信息管理系统</h1>
    <a href="index_sup.php?myid=root&id=root" >主页</a>
    <a href="add.php?myid=root&id=root" >添加用户</a>
    <a href="javascript:Logout()" >退出登陆</a>
</div>
<div align="center">
    <h2>添加用户</h2>
    <form action="action.php?action=Reg&myid=root&id=root" method="post"  >
        <table >
            <tr>
                <td>姓名</td>
                <td>
                    <input name="name" type="text" >
                </td>
            </tr>
            <tr>
                <td>
                    学号：
                </td>
                <td>
                    <input name="id_st" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    密码：
                </td>
                <td>
                    <input name="pw1" type="password">
                </td>
            </tr>
            <tr>
                <td>年龄</td>
                <td>
                    <select name="age">
                        <option value="">年龄</option>
                        <?php
                        for ($i=0;$i<100;$i++ ){
                            echo "<option value=$i>$i</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>班级</td>
                <td>
                    <select name="class">
                        <option value ="">班级</option>
                        <option value ="g1b1">高一（1）班</option>
                        <option value ="g1b2">高一（2）班</option>
                        <option value ="g1b3">高一（3）班</option>
                        <option value ="g1b4">高一（4）班</option>
                        <option value ="g2b1">高二（1）班</option>
                        <option value ="g2b2">高二（2）班</option>
                        <option value ="g2b3">高二（3）班</option>
                        <option value ="g2b4">高二（4）班</option>
                        <option value ="g3b1">高三（1）班</option>
                        <option value ="g3b2">高三（2）班</option>
                        <option value ="g3b3">高三（3）班</option>
                        <option value ="g3b4">高三（4）班</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>性别</td>
                <td>
                    <input name="sex" type="radio" value="male">男
                    <input name="sex" type="radio" value="female">女
                </td>
            </tr>
            <tr>
                <td>
                    身份：
                </td>
                <td>
                    <input name="idt" type="radio" value="student">学生
                    <input name="idt" type="radio" value="teacher">老师
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input  type="submit" value="添加">
                    <input  type="reset" value="重置">
                </td>
            </tr>


        </table>


    </form>
</div>
</body>
</html>