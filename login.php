<?php
include("conn.php");

if (isset($_POST['regSubmit'])) {
    $username = 'admin@' . $_POST['textUserName'];
    $userpw = $_POST['textUserPW2'];
    $useremail = $_POST['textEmail'];
    $usercompany = $_POST['textCompanyName'];
    $cname = $_POST['textUserName'];
    $sql = "INSERT INTO `user`(`username`,`userpw`,`post`,`power`,`useremail`,`usercompany`,`cname`)values('" . $username . "','" . $userpw . "','管理员','0','" . $useremail . "','" . $usercompany . "','" . $cname . "');";
    mysql_query($sql, $mysql);
    $dir = iconv('utf-8', 'gb2312', "./document/" . $cname);
    mkdir($dir, 0777);
    setcookie("name", $username);
    header("location:project.php");
}
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
    <script src="js/jquery.js"></script>
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        .heading {
            height: 38px;
            padding-left: 7px;
            padding-right: 7px;
            border: 1px solid #DBDBDB;
            -webkit-border-radius: 7px 7px 0px 0px;
            -moz-border-radius: 7px 7px 0px 0px;
            -khtml-border-radius: 7px 7px 0px 0px;
            border-radius: 7px 7px 0px 0px;
        }

        .content {
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

        input {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000000;
        }

    </style>
    <script>
        var y, ny = 0, my = 90, rotYINT;
        var myArray = new Array();
        for (var i = 0; i < 3; i++) {
            myArray[i] = 0;
        }
        $(function () {
            var login = $("#login-hidden-form").clone();
            login.removeAttr("style");
            login.attr("id", "login-form");
            $(".content").append(login);
            $(".content").on("blur", "input[name=textUserName]",function () {
                var username = "admin@" + $(this).val();
                var span = $(this).parent().find("span");
                span.html("");
                var flag = 1;
                if ($(this).val() == '') {
                    span.html("公司名不能为空");
                    myArray[0] = 0;
                    flag = 0;
                }
                var url = "checkUserName.php";
                if (flag == 1) {
                    $.post(url, {username: username}, function (result) {
                        if (result == "0") {
                            span.html("该公司名可以注册");
                            myArray[0] = 1;
                        } else {
                            span.html("该公司名不可注册，请更换");
                            myArray[0] = 0;
                        }
                    })
                }
            }).on("blur", "input[name=textUserPW2]",function () {
                    var pw1 = $("input[name=textUserPW1]").val();
                    var pw2 = $("input[name=textUserPW2]").val();
                    var span = $(this).parent().find("span");
                    span.html("");
                    if (pw1.length) {
                        if (pw1 != pw2) {
                            span.html("前后两次密码不符合，请检查")
                            myArray[1] = 0;
                        }
                        else {
                            span.html("密码输入正确");
                            myArray[1] = 1;
                        }
                    } else {
                        span.html("请输入密码");
                        myArray[1] = 0;
                    }
                }).on("blur", "input[name=textEmail]",function () {
                    var email = $(this);
                    var span = $(this).parent().find("span");
                    span.html("");
                    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
                    if (reg.test(email.val())) {
                        myArray[2] = 1;
                        span.html("邮箱可以使用");

                    } else {
                        span.html("邮箱格式不正确，请输入正确的邮箱地址");
                        myArray[2] = 0;
                    }
                }).on("blur", "input[name=textCompanyName]", function () {
                    var company = $(this);
                    var span = $(this).parent().find("span");
                    span.html("");
                    if (company.length) {
                        span.html("公司名可以使用");
                        myArray[3] = 1;
                    }
                    else {
                        span.html("公司名不可为空");
                        myArray[3] = 0;
                    }
                });
        });
        function rotateYDIV(x) {
            y = document.getElementById("box")
            clearInterval(rotYINT)
            if(x==1)
                rotYINT = setInterval("startYRotate(1)", 5);
            else{
                rotYINT = setInterval("startYRotate(0)", 5);
            }
        }
        function rotateLogin(loginY) {
            y.style.transform = "rotateY(" + loginY + "deg)"
            y.style.webkitTransform = "rotateY(" + loginY + "deg)"
            y.style.OTransform = "rotateY(" + loginY + "deg)"
            y.style.MozTransform = "rotateY(" + loginY + "deg)"
        }
        function rotateRegister(registerY) {
            y.style.transform = "rotateY(" + registerY + "deg)"
            y.style.webkitTransform = "rotateY(" + registerY + "deg)"
            y.style.OTransform = "rotateY(" + registerY + "deg)"
            y.style.MozTransform = "rotateY(" + registerY + "deg)"
        }
        var tn = 0;
        function startYRotate(x) {
            if (ny < 90 && tn == 0) {
                ny = ny + 1;
                if(x==1){
                rotateLogin(ny);
                }else{
                    rotateRegister(ny)
                }
            } else {
                tn = 1;
            }
            if (tn == 1 ) {
                ny = ny - 1;
                if(x==1){
                if (!$("#register-form").length) {
                    var regiseter = $("#register-hidden-form").clone();
                    regiseter.attr("id", "register-form");
                    regiseter.removeAttr("style")
                    $("#login-form").remove();
                    $(".content").append(regiseter);
                    $("#title").html("请输入注册信息。");
                }
                rotateRegister(ny);
                }
                else{
                    if (!$("#login-form").length) {
                        var login = $("#login-hidden-form").clone();
                        login.attr("id", "login-form");
                        login.removeAttr("style")
                        $("#register-form").remove();
                        $(".content").append(login);
                        $("#title").html("请输入登录信息。");
                    }
                    rotateLogin(ny);
                }
                if (ny <= 0) {
                    clearInterval(rotYINT)
                    {
                        ny = 0;
                        tn=0;
                    }
                }
            }
            }

        function check() {
            if (myArray[0] == 1 && myArray[1] == 1 && myArray[2] == 1 && myArray[3] == 1) {
                alert("注册信息提交成功！");
                $(".content").find("form").submit();
            } else {
                alert("提交失败，请检查注册信息是否正确！");
            }
        }
        function reset() {
            $(".content").find("input").each(function () {
                $(this).val("");
            })
        }
    </script>
    <link href="./css/css.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div
    style="background-image:url(images/login-background.jpg);height: 50px;width: 100%;background-size:cover;padding: 10px">
    <div style="text-align:center;font-size:40px;font-weight: 900;color: #1D5892">项目管理系统</div>
</div>
<div id="box" class="box"
     style="width: 400px; min-height: 300px; margin-top: 40px; margin-left: auto; margin-right: auto;">
    <div class="heading">
        <h1><img src="images/lockscreen.png" alt=""> <span id="title">请输入您的登录信息。</span></h1>
    </div>
    <div class="content" style="min-height: 150px; overflow: hidden;">
    </div>

</div>
<form name="indexForm" method="post" enctype="multipart/form-data" id="login-hidden-form" style="display: none">
    <table style="width: 100%;">
        <tbody>
        <tr>
            <td style="text-align: center;" rowspan="4"><img src="images/login.png" alt="请输入您的登录信息。"></td>
        </tr>
        <tr>
            <td>用户名：<br>
                <input type="text" name="textUserName" placeholder="系统账号/邮箱账号" value=""
                       style="margin-top: 4px;">
                <br>
                <br>
                密码：<br>
                <input type="password" name="textPW" placeholder="请输入登录密码" value="" style="margin-top: 4px;">
                <br>

            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="indexSubmit" class="right-button02" value="登陆">
                <input name="Submit232" type="submit" class="right-button02" value="重 置"/>
            </td>
        </tr>
        </tbody>
    </table>
    <div style="text-align: right;margin-bottom: 5px;margin-right: 5px;">没有账号？<a href="#"
                                                                                 onclick="rotateYDIV(1)">马上注册</a></div>
</form>
<div id="register-hidden-form" style="display: none">
    <form method="post" name="regForm">
        <div>公&nbsp司&nbsp名：<input type="text" name="textUserName" size="20"><span class="error-message"></span></div>
        <div>密&nbsp&nbsp&nbsp&nbsp码：<input type="password" name="textUserPW1" size="20"><span
                class="error-message"></span></div>
        <div>密码确认：<input type="password" name="textUserPW2" size="20"><span class="error-message"></span></div>
        <div>邮&nbsp&nbsp&nbsp&nbsp箱：<input type="text" name="textEmail" size="20"><span class="error-message"></span>
        </div>
        <div>公司地址：<input type="text" name="textCompanyName" size="20"><span class="error-message"></span></div>
    </form>
    <button name="regSubmit" onclick="check()">注册</button>
    <button name="name" onclick="reset()">清空</button>
    <button onclick="rotateYDIV(0)">返回</button>
</div>
</body>
</html>