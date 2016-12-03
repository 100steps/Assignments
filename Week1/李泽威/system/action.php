<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>处理</title>
</head>

<body>
<?php

//    链接数据库
require_once "fun.php";
$pdo = connect();
getTest('action');
if ($_GET['action'] != "Log" && $_GET['action'] != "Logo"&& $_GET['action'] != "Reg" ){
    logTest();
}

//登入验证
if ($_GET['action']!='Etr' and $_GET['action']!='Tra' and $_GET['action']!='Add' and  $_GET['action']!='Del' and $_GET['action']!='Edt' and $_GET['action']!='Reg' and $_GET['action']!='Log' and $_GET['action']!='Edt_pw' and $_GET['action']!='Logo' ){
    die("<script>alert('非法登入！！');window.history.back();</script>");
}



switch ($_GET['action']) {



    case 'Del':   //删除信息
        $id = $_GET['id'];
        $sql = "DELETE FROM student WHERE id=$id";
        $sre = $pdo->exec($sql);
        if ($sre) {
            echo "<script>alert('删除成功');window.location='index_sup.php?id=root&myid=root';</script>";

        } else {
            echo "<script>alert('删除失败');window.location='index_sup.php?id=root&myid=root';</script>";
        }
        break;




    case 'Edt':        //修改信息

        if (empty($_POST['name'])) {
            die("<script>alert('姓名为空');window.history.back();</script>");
        }
        if (empty($_POST['age'])) {
            die("<script>alert('年龄为空');window.history.back();</script>");
        }
        if (empty($_POST['class'])) {
            die("<script>alert('班级为空');window.history.back();</script>");
        }
        if (empty($_POST['sex'])) {
            die("<script>alert('未选定性别');window.history.back();</script>");
        }
        if (empty($_POST['idt'])) {
            die("<script>alert('未选定身份');window.history.back();</script>");
        }

        //修改数值录入
        $id = $_GET['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $class = $_POST['class'];
        $idt = $_POST['idt'];

        $birth = $_POST['birth'];
        $idtype = $_POST['idtype'];
        $idnub = $_POST['idnub'];
        $telenub = $_POST['telenub'];
        $nation = $_POST['nation'];
        $home = $_POST['home'];
        $award = $_POST['award'];
        $file = $_FILES['file'];

        //头像修改
        if ($file['name']) {

            move_uploaded_file($file['tmp_name'], "tou/$file[name]");
            $sql = "UPDATE student SET image='$file[name]' WHERE id=$id";

            $sre = $pdo->exec($sql);
            if ($sre) {
            } else {
                echo "<script>alert('修改头像失败');window.history.back();</script>";
            }
        }

        //信息修改执行
        $sql = "UPDATE student SET name='$name',age=$age,sex='$sex',class='$class',identity='$idt',
              birth='$birth',idtype='$idtype',idnub='$idnub',telenub='$telenub',nation='$nation',home='$home',award='$award'  WHERE id=$id";
        $sre = $pdo->exec($sql);
        if ($sre) {
            if ($_GET['myid'] == 'root') {
                echo "<script>alert('修改成功');window.location='index_sup.php?id=$_GET[myid]&myid=$_GET[myid]';</script>";
            } else {
                echo "<script>alert('修改成功');window.location='index.php?id=$_GET[myid]&myid=$_GET[myid]';</script>";
            }

        } else {
            echo "<script>alert('修改失败');window.history.back();</script>";
        }
        break;





    //注册or添加信息
    case  'Reg':
        if (empty($_POST['name'])) {
            die("<script>alert('请输入姓名');window.history.back();</script>");
        }
        if (empty($_POST['age'])) {
            die("<script>alert('请输入年龄');window.history.back();</script>");
        }
        if (empty($_POST['class'])) {
            die("<script>alert('选择班级');window.history.back();</script>");
        }
        if (empty($_POST['sex'])) {
            die("<script>alert('请选择性别');window.history.back();</script>");
        }
        if (empty($_POST['idt'])) {
            die("<script>alert('请选择身份');window.history.back();</script>");
        }
        if (empty($_POST['id_st'])) {
            die("<script>alert('请输入学号');window.history.back();</script>");
        }
        if (100000>$_POST['id_st'] || $_POST['id_st']>999999){
            die("<script>alert('学号必须为六位数');window.history.back();</script>");
        }

        if (@$_GET['myid'] == 'root') {

            $_POST['pw2'] = $_POST['pw1'];
        }
        if (empty($_POST['pw1']) or empty($_POST['pw2'])) {
            die("<script>alert('请输入密码');window.history.back();</script>");
        }

        if ($_POST['pw1'] != $_POST['pw2']) {
            die("<script>alert('前后两次密码不一致');window.history.back();</script>");
        }
        if($_POST['idt']=="teacher" &&$_GET['myid']!="root"&& $_POST['key'] != "teacherKey"){
            die("<script>alert('教师注册码错误');window.history.back();</script>");
        }
        if($_POST['idt']=="root" &&$_GET['myid']!="root"&& $_POST['key'] != "rootKey"){
            die("<script>alert('管理员注册码错误');window.history.back();</script>");
        }


        //注册or添加的基本信息录入
        $name = $_POST['name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $class = $_POST['class'];
        $idt = $_POST['idt'];
        $pw = $_POST['pw1'];
        $id_st=$_POST['id_st'];


        //注册or添加的判断

        $sql = "SELECT *FROM student WHERE studyid='$id_st'";
        $stm = $pdo->query($sql);

        if ($stm->rowCount()) {
            die("<script>alert('学号已存在');window.history.back();</script>");
        }
        $pdo->query("SET NAMES UTF8");
        $sql = "INSERT INTO student VALUE(NULL ,'$id_st','$name',$age,'$sex','$class' ,'$idt','$pw',NULL ,NULL ,NULL ,NULL ,NULL ,NULL ,NULL,'')  ";
        $sre = $pdo->exec($sql);
        if ($sre) {
            if (@$_GET['myid'] == 'root') {
                echo "<script>alert('添加成功');window.location='index_sup.php?myid=root&id=root';</script>";
            } else {

                $sql = "SELECT  *FROM student WHERE studyid='$id_st'";
                $stm = $pdo->query($sql);
                $arr = $stm->fetch(PDO::FETCH_ASSOC);

                if( $arr['identity'] =='root'){
                    $myid = 'root';
                }else{
                    $myid = $arr['id'];
                }


                session_start();
                unset($_SESSION['int']);
                $_SESSION['uid'] = $myid;


                echo "<script>alert('注册成功');window.location='index.php?myid=$myid&id=$myid';</script>";
            }

        } else {

            print_r($pdo->errorInfo());
            if ($_GET['myid'] == 'root') {
                echo "<script>alert('添加失败');window.history.back();</script>";
            } else {
                echo "<script>alert('注册失败');window.history.back();</script>";
            }



        }

        break;





    //登录账户
    case 'Log':
        if (empty($_POST['id_st'])) {
            die("<script>alert('请输入学号');window.history.back();</script>");
        }
        if (empty($_POST['pw'])) {
            die("<script>alert('请输入密码');window.history.back();</script>");
        }


        $id_st = $_POST['id_st'];
        $pw = $_POST['pw'];

        if ($id_st=='root' && $pw =='root') {
            session_start();
            unset($_SESSION['int']);
            $_SESSION['uid'] = 'root';
            header("Location:index_sup.php?myid=root&id=root");
        }


        //账号核对
        $sql = "SELECT *FROM student WHERE studyid='$id_st'";
        $stm = $pdo->query($sql);
        if ($stm->rowCount()) {
            $arr = $stm->fetch(PDO::FETCH_ASSOC);
        } else {
            die("<script>alert('用户不存在');window.history.back();</script>");
        }

        if ($pw == $arr['password']) {

            if ($arr['identity']=="root") {
                session_start();
                unset($_SESSION['int']);
                $_SESSION['uid'] = 'root';
                header("Location:index_sup.php?myid=root&id=root");
            }else{
                session_start();
                unset($_SESSION['int']);
                $_SESSION['uid'] = $arr['id'];
                header("Location:index.php?myid=$arr[id]&id=$arr[id]");
            }

        } else {
            echo "<script>alert('密码错误');window.history.back();</script>";
        }
        break;







    //修改密码
    case 'Edt_pw':

        if (empty($_POST['pw2']) or empty($_POST['pw2']) or empty($_POST['pw3'])) {
            die("<script>alert('请输入密码');window.history.back();</script>");
        }
        if ($_POST['pw2'] != $_POST['pw3']) {
            die("<script>alert('前后两次密码不一致');window.history.back();</script>");
        }


        //密码核对与修改
        $id = $_GET['id'];
        $pw1 = $_POST['pw1'];
        $pw2 = $_POST['pw2'];

        $sql = "SELECT *FROM student WHERE id='$id'";
        $stm = $pdo->query($sql);
        if ($stm->rowCount()) {
            $arr = $stm->fetch(PDO::FETCH_ASSOC);
        } else {
            die("<script>alert('用户信息出错');window.history.back();</script>");
        }

        if ($pw1 != $arr['password']) {
            die("<script>alert('原密码错误');window.history.back();</script>");
        } else {
            $sql_u = "UPDATE student SET password='$pw2' WHERE id=$id";
            $sre = $pdo->exec($sql_u);
            //超级用户和普通用户修改密码后的跳转
            if ($sre) {
                if ($_GET['myid'] == 'root') {
                    echo "<script>alert('修改成功');window.location='index_sup.php?id=$_GET[myid]&myid=$_GET[myid]';</script>";
                } else {
                    echo "<script>alert('修改成功');window.location='index.php?id=$_GET[myid]&myid=$_GET[myid]';</script>";
                }

            } else {
                echo "<script>alert('修改失败');window.history.back();</script>";
            }

        }
        break;





    //注销用户，消除session信息
    case 'Logo':
        session_start();
        unset($_SESSION['uid']);
        session_destroy();
        echo "<script>alert('退出成功');window.location='login.html';</script>";
        break;





    //审核信息
    case 'Tra':
        if (empty($_POST['name'])) {
            die("<script>alert('姓名为空');window.history.back();</script>");
        }
        if (empty($_POST['age'])) {
            die("<script>alert('年龄为空');window.history.back();</script>");
        }
        if (empty($_POST['class'])) {
            die("<script>alert('班级为空');window.history.back();</script>");
        }
        if (empty($_POST['sex'])) {
            die("<script>alert('未选定性别');window.history.back();</script>");
        }
        if (empty($_POST['idt'])) {
            die("<script>alert('未选定身份');window.history.back();</script>");
        }


        //待审核信息的录入
        $id = $_GET['myid'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $class = $_POST['class'];
        $idt = $_POST['idt'];
        $id_st=$_POST['id_st'];

        $birth = $_POST['birth'];
        $idtype = $_POST['idtype'];
        $idnub = $_POST['idnub'];
        $telenub = $_POST['telenub'];
        $nation = $_POST['nation'];
        $home = $_POST['home'];
        $award = $_POST['award'];
        $file = $_FILES['file'];

        if ($file['name']) {
            move_uploaded_file($file['tmp_name'], "tou/$file[name]");
        }

        //老师和学生的区别录入
        if ($_GET['id']=='teacher'){
            $sql = "INSERT INTO  edit_t  VALUE(NULL,'$id','$id_st','$name',$age,'$sex','$class' ,'$idt','$birth' ,'$idtype' ,'$idnub' ,'$telenub','$nation' ,'$home' ,'$award','$file[name]') ";
        }else{
            $sql = "INSERT INTO  edit    VALUE(NULL ,'$id','$id_st','$name',$age,'$sex','$class' ,'$idt','$birth' ,'$idtype' ,'$idnub' ,'$telenub','$nation' ,'$home' ,'$award','$file[name]') ";
        }

        $sre=$pdo->exec($sql);
        if($sre) {
            echo "<script>alert('等待审核');window.location='index.php?id=$_GET[myid]&myid=$_GET[myid]';</script>";
        }else {
            echo "<script>alert('请勿重复提交');window.history.back();</script>";
        }


        break;






    //审核结果处理
    case 'Etr':

        $id_tr=$_GET['id'];

        //老师审核
        if ($_GET['t']=='1'||$_GET['t']=='2'){
            $sql="SELECT *FROM edit_t WHERE id_tr='$id_tr'";

        }else{
            $sql="SELECT *FROM edit WHERE id_tr='$id_tr'";
        }

        $stm=$pdo->query($sql);
        $arr=$stm->fetch(PDO::FETCH_ASSOC);

        //通过审核，信息录入
        if ($_GET['t']=='1' or $_GET['t']=='3') {
            $id = $arr['id'];
            $name = $arr['name'];
            $age = $arr['age'];
            $sex = $arr['sex'];
            $class = $arr['class'];
            $idt = $arr['identity'];

            $birth = $arr['birth'];
            $idtype = $arr['idtype'];
            $idnub = $arr['idnub'];
            $telenub = $arr['telenub'];
            $nation = $arr['nation'];
            $home = $arr['home'];
            $award = $arr['award'];
            $image = $arr['image'];

            if ($image) {
                $sql = "UPDATE student SET image='$image' WHERE id=$id";
                $sre = $pdo->exec($sql);
                if ($sre) {
                } else {
                    die("<script>alert('修改头像失败');window.history.back();</script>");
                }
            }

            $sql = "UPDATE student SET name='$name',age=$age,sex='$sex',class='$class',identity='$idt',
              birth='$birth',idtype='$idtype',idnub='$idnub',telenub='$telenub',nation='$nation',home='$home',award='$award'  WHERE id=$id";
            $sre = $pdo->exec($sql);
            if ($sre) {
            } else {
                print_r($pdo->errorInfo());
                die("<script>alert('修改失败');window.history.back();</script>");
            }

        }

        //待审核信息的销毁
        if ($_GET['t']=='1'||$_GET['t']=='2'){
            $sql = "DELETE FROM edit_t WHERE id_tr=$id_tr";
        }else{
            $sql = "DELETE FROM edit WHERE id_tr=$id_tr";
        }

        $sre = $pdo->exec($sql);
        if ($sre) {
            if ($_GET['myid']=='root'){
                echo "<script>alert('审核成功');window.location='index_sup.php?id=$_GET[id]&myid=$_GET[myid]';</script>";
            }else{
                echo "<script>alert('审核成功');window.location='index.php?id=$_GET[id]&myid=$_GET[myid]';</script>";
            }

        } else {
            die("<script>alert('审核失败');window.history.back();</script>");
        }
        break;



}

?>
</body>
</html>