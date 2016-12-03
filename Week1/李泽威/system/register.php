<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
</head>
<body>
<form action="action.php?action=Reg" method="post">
    <table width="100%" height="600" >
        <tr>

            <td  valign="center" align="center">
                <table >
                    <tr>
                        <td>
                            <h3>
                                请完善信息
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            姓名：
                        </td>
                        <td>
                            <input name="name" type="text">
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
                        <td>
                            确认密码：
                        </td>
                        <td>
                            <input name="pw2" type="password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            年龄：
                        </td>
                        <td>
                            <select name="age">
                                <option value="">年龄</option>
                                <?php
                                for ($i=1;$i<100;$i++ ){

                                    echo "<option value=$i >$i</option>";
                                }
                                ?>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            班级：
                        </td>
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
                        <td>
                            性别：
                        </td>
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
                            <input name="idt" type="radio" value="root">超级管理员
                        </td>
                    </tr>
                    <tr>
                        <td>
                            教师/管理员注册码：
                        </td>
                        <td>
                            <input name="key" type="password" value="key">
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input type="submit" value="注册">
                            <a href="login.html">返回</a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>


</form>
</body>
</html>