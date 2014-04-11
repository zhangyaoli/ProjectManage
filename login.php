<?php
include("conn.php");
if(isset($_POST['indexSubmit'])){
    $username=$_POST['textUserName'];
    $userpw=$_POST['textPW'];
    $sql="select * from `user` where `username`='".$username."'and `userpw`='".$userpw."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);


    if($arr)
    {
        if($arr['power']==0){
            setcookie('projectManager',1);
        }else{
            setcookie('projectManager',2);
        }
        setcookie("name",$username);
        header("location:project.php");
    }else
    {
        echo "<script> alert('用户名或密码错误，请重新登录');</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        -->
    </style>
    <link href="./css/css.css" rel="stylesheet" type="text/css" />
</head>
<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="147" background="images/top02.gif"><img src="images/top03.gif" width="776" height="147" /></td>
    </tr>
</table>
<table width="562" border="0" align="center" cellpadding="0" cellspacing="0" class="right-table03">
    <tr>
        <td width="221"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="login-text01">

                <tr>
                    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="login-text01">
                            <tr>
                                <td align="center"><img src="images/ico13.gif" width="107" height="97" /></td>
                            </tr>
                            <tr>
                                <td height="40" align="center">&nbsp;</td>
                            </tr>

                        </table></td>
                    <td><img src="images/line01.gif" width="5" height="292" /></td>
                </tr>
            </table></td>
        <form name="indexForm" method="post">
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="31%" height="35" class="login-text02">用户名称：<br /></td>
                        <td width="69%"><input type="text" name="textUserName" size="15" value="系统账号/邮箱账号" onfocus="javacript:document.indexForm.textUserName.value='';"></td>
                    </tr>
                    <tr>
                        <td height="135" class="login-text02">密　码：<br /></td>
                        <td><input type="password" name="textPW" size="15"></td>
                    </tr>
                    <tr>
                        <td height="35">&nbsp;</td>
                        <td><input type="submit" name="indexSubmit"   class="right-button02" value="登陆">
                            <input name="Submit232" type="submit" class="right-button02" value="重 置" /></td>
                    </tr>
                    <tr><td colspan="2">没有账号？<a href="register.php">马上注册</a></td>
                    </tr>
                </table>  </form></td>
    </tr>
</table>
</body>
</html>