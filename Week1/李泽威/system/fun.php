<?php


    define('MYSQL_HOST' , "localhost");
    define('MYSQL_NAME' , "test");
    define('MYSQL_USER' , "root");
    define('MYSQL_PASS' , "");



    function logTest()
    {

        if (empty(@$_GET['id']) or empty(@$_GET['myid'])) {
            die("<script>alert('非法登入！！');window.history.back();</script>");
        }
        session_start();
        if (empty(@$_SESSION['uid'])) {
            die("<script>alert('登陆超时！');window.location='login.html';</script>");
        }
        if ($_GET['myid'] != $_SESSION['uid']) {
            header("Location:index.php?myid=$_SESSION[uid]");
        }
    }

    function  getTest($get){
        if(empty($_GET["$get"])){
            die("<script>alert('非法登入！！');window.history.back();</script>");
        }
    }

    function connect()
    {
        try {
            $pdo = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_NAME , MYSQL_USER , MYSQL_PASS);
            $pdo->query("SET NAMES UTF8");
        } catch (PDOException $e) {
            die("<script>alert('\"链接数据失败\" . $e->getMessage()');window.history.back();</script>");
        }
        return($pdo);
    }


?>