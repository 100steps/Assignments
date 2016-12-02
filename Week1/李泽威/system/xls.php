<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>添加用户</title>
</head>
<body>
<table width="100%" border="1" >
    <tr>
        <th>ID</th>
        <th>学号</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>班级</th>
        <th>身份</th>
        <th>身份证类型</th>
        <th>身份证号码</th>
        <th>出生日期</th>
        <th>联系电话</th>
        <th>户籍</th>
        <th>民族</th>
    </tr>

    <?php
    //    链接数据库
    require_once "fun.php";
    $pdo = connect();
    logTest();
    getTest("t");




    //xsl文件的生产
    header("Content-type:application/octet-stream");
    header("Accpept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");






    //师生资料的判断
    if ($_GET['t']==1){
        header("Content-Disposition:attachment;filename=老师基础资料.xls");
        $sql="SELECT *FROM student WHERE  identity='teacher'";

    }else{
        header("Content-Disposition:attachment;filename=学生基础资料.xls");
        $sql="SELECT *FROM student WHERE  identity='student'";
    }


    foreach ($pdo->query($sql)  as  $val){

        echo "<tr>

               <td>{$val['id']}</td>
                <td>{$val['studyid']}</td>
               <td>$val[name]</td>
               <td>$val[age]</td>
               <td>$val[sex]</td>
               <td>$val[class]</td>
               <td>$val[identity]</td>
               <td>$val[idtype]</td>
               <td>$val[idnub]</td>
               <td>$val[birth]</td>
               <td>$val[telenub]</td>
               <td>$val[home]</td>
               <td>$val[nation]</td>
               </tr>";
    }



    ?>
</table>
</body>
</html>