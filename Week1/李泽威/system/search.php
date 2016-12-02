<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>搜索结果</title>
</head>
<body>

<!--表头-->
<h2 style="text-align: center">搜索结果</h2>
<table width="100%" border="1" >
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>性别</th>
        <th>班级</th>
        <th>身份</th>
        <th>密码</th>
        <th>操作</th>
    </tr>


    <!--    数据库链接-->
    <?php
    //    链接数据库
    require_once "fun.php";
    $pdo = connect();
    logTest();


    $seaName=$_POST['name'];
    $type=$_POST['type'];
    if($type=="name"){
        $ord=" WHERE  $type LIKE '%$seaName%'";
    }else{
        $ord="WHERE  $type ='$seaName'";
    }

    if($_GET['id']=="root" && $_GET['myid']=="root"){
        echo "  <a href='index_sup.php?id=$_GET[id]&myid=$_GET[myid]'>返回</a>";
    }else{
        echo "  <a href='index.php?id=$_GET[id]&myid=$_GET[myid]'>返回</a>";
    }






    if ($type=="name"){
        $sql = "SELECT *FROM student ORDER BY identity ";
        foreach ($pdo->query($sql) as $val) {
            if (preg_match("/^[\x{0000}-\x{ffff}]*.*" . $seaName . "[\x{0000}-\x{ffff}]*.*$/u", $val['name'])) {
                echo "<tr>
                   <td>{$val['id']}</td>
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
        }
    }else{


        $sql="SELECT *FROM student WHERE $type=$seaName ORDER BY $type";
        foreach ($pdo->query($sql)  as  $val){

            echo "<tr>
               <td>{$val['id']}</td>
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

    }





    //
    //
    //    $sql="SELECT *FROM student $ord ORDER BY identity";
    //    foreach ($pdo->query($sql)  as  $val){
    //
    //        echo "<tr>
    //               <td>{$val['id']}</td>
    //               <td>$val[name]</td>
    //               <td>$val[age]</td>
    //               <td>$val[sex]</td>
    //               <td>$val[class]</td>
    //               <td>$val[identity]</td>
    //               <td>$val[password]</td>
    //               <td><a href='javascript:doDel($val[id])'>删除</a>
    //                   <a href='use.php?id=$val[id]&myid=$_GET[myid]'>查看/修改</a>
    //              </td>
    //               </tr>";
    //    }


    ?>
</table>



</body>
</html>