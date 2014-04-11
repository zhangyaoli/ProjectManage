<?php
include("conn.php");
if (isset($_POST['indexSubmit'])) {
    $username = $_POST['textUserName'];
    $userpw = $_POST['textPW'];
    $sql = "select * from `user` where `username`='" . $username . "'and `userpw`='" . $userpw . "';";
    $result = mysql_query($sql, $mysql);
    $arr = mysql_fetch_array($result);


    if ($arr) {
        if ($arr['power'] == 0) {
            setcookie('projectManager', 1);
        } else {
            setcookie('projectManager', 2);
        }
        setcookie("name", $username);
        header("location:project.php");
    } else {
        echo "<script> alert('用户名或密码错误，请重新登录');</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>项目管理系统</title>
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
.heading{
    height: 38px;
    padding-left: 7px;
    padding-right: 7px;
    border: 1px solid #DBDBDB;
    -webkit-border-radius: 7px 7px 0px 0px;
    -moz-border-radius: 7px 7px 0px 0px;
    -khtml-border-radius: 7px 7px 0px 0px;
    border-radius: 7px 7px 0px 0px;
}.content{
     adding: 10px;
     border-left: 1px solid #CCCCCC;
     border-right: 1px solid #CCCCCC;
     border-bottom: 1px solid #CCCCCC;
 }
        .box > .heading h1 {
            margin: 0px;
            padding: 11px 0px 0px 0px;
            color: #003A88;
            font-size: 16px;
            float: left;
        }
        input{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000000;
        }
        -->
    </style>
    <link href="./css/css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div style="background-image:url(images/login-background.jpg);height: 50px;width: 100%;background-size:cover;padding: 10px">
    <div style="text-align:center;font-size:40px;font-weight: 900;color: #1D5892">项目管理系统</div>
</div>
<div class="box" style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
        <h1><img src="images/lockscreen.png" alt=""> 请输入您的登录信息。</h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
        <form name="indexForm" method="post" enctype="multipart/form-data">
            <table style="width: 100%;">
                <tbody>
                <tr>
                    <td style="text-align: center;" rowspan="4"><img src="images/login.png" alt="请输入您的登录信息。"></td>
                </tr>
                <tr>
                    <td>用户名：<br>
                        <input type="text" name="textUserName" placeholder="系统账号/邮箱账号" value="" style="margin-top: 4px;">
                        <br>
                        <br>
                        密码：<br>
                        <input type="password" name="textPW" placeholder="请输入登录密码" value="" style="margin-top: 4px;">
                        <br>
                        没有账号？<a href="register.php">马上注册</a>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                        <input type="submit" name="indexSubmit" class="right-button02" value="登陆">
                        <input name="Submit232" type="submit" class="right-button02" value="重 置"/>
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>
</div>
</body>
</html>