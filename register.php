<?php
include("conn.php");
if(isset($_POST['regSubmit']))
{
//    var_dump($_POST);
//    die;
    $username='admin@'.$_POST['textUserName'];
    $userpw=$_POST['textUserPW2'];
    $useremail=$_POST['textEmail'];
    $usercompany=$_POST['textCompanyName'];
    $cname=$_POST['textUserName'];
    $sql="INSERT INTO `user`(`username`,`userpw`,`post`,`power`,`useremail`,`usercompany`,`cname`)values('".$username."','".$userpw."','管理员','0','".$useremail."','".$usercompany."','".$cname."');";
    mysql_query($sql,$mysql);
    $dir=iconv('utf-8','gb2312',"./document/".$cname);
    mkdir($dir,0777);
    setcookie("name",$username);
    header("location:project.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <script language="javascript" type="text/javascript">
        var submitFlag=false;
        function createAjax()
        {
            var ajax;
        if(window.XMLHttpRequest)
        {
            ajax=new XMLHttpRequest();
            return ajax;
        }
            alert("您的浏览器不支持AJAX，请换个浏览器再注册");

        }
        function checkUserName()
        {
            var username="admin@"+document.regForm.textUserName.value;
            var ajax=createAjax();
            var span=document.getElementById('idcheck');
            if(username=='')
            {
                span.innerText="公司名不能为空";
                return false;
            }
            var url="checkUserName.php";
            ajax.open("POST",url,false);//最后一个参数改成true异步发送readyState就一直为1 靠
            ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            var str="username="+username;
            ajax.send(str);
            if(ajax.readyState==4)
            {
                if(ajax.status==200||ajax.status==0)
                {
                    var backStr=ajax.responseText;
                    if(backStr==0)
                    {
                        span.innerText="该公司名可以注册"
                        return true;
                    }else{
                        span.innerText="该公司名不可注册，请更换"
                        return false;
                    }
                }
            }
        }
        function checkPW()
        {
            var pw1=document.regForm.textUserPW1.value;
            var pw2=document.regForm.textUserPW2.value;
            var span=document.getElementById('pwcheck');
            if(pw1!=pw2)
            {
                span.innerText="前后两次密码不符合，请检查";
                return false;
            }
            else{
                span.innerText="密码输入正确";
                return true;
            }
        }
        function checkEmail()
        {
            var email=document.regForm.textEmail.value;
            var span=document.getElementById('emailcheck');
            var reg=/^[\w-_\.]+@([\w-]+\.)+[\w-]+$/;
            if(reg.test(email))
            {
                span.innerText="邮箱可以使用";
                return true;
            }else{
                span.innerText="邮箱格式不正确，请输入正确的邮箱地址";
                return false;
            }
        }
        function checkCompany()
        {
            var company=document.regForm.textCompanyName.value;
            var span=document.getElementById('companycheck');
            if(company)
            {span.innerText="公司名可以使用";
                return true;
            }
            else
            {
                span.innerText="公司名不可为空";
                return false;
            }
        }
        function check()
        {
            if(checkUserName()&&checkPW()&&checkEmail()&&checkCompany())
            {
                alert("注册信息提交成功！");
                submitFlag=true;
            }else
            {
                alert("提交失败，请检查注册信息是否正确！");
            }
        }
        function submitCheck()
        {
            return submitFlag;
        }
    </script>
    <title>项目管理系统注册</title>
    <style type="text/css">
        <!--
        body,td,th {
            font-size: 12px;
            color: #3791cf;
        }
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
        -->
    </style>
    <link href="user2/css/bg.css" rel="stylesheet" type="text/css" />
</head>

<body>


<font color="#FF0000" size="3">注册之后您的登陆账号（公司管理员）为admin+@+公司名，如注册公司为ST,您的登陆账号为admin@ST</font>
<form name="regForm" method="post" onclick="return submitCheck()">
    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0" >

        <tr>
            <td width="45" valign="top"><img src="images/user2/images/register_03.gif" width="45" height="386" /></td>
            <td width="623" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><img src="images/user2/images/register_04.gif" width="623" height="135" /></td>
                    </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td background="images/user2/images/register_28.gif"><form id="form1" name="form1" method="post" action="">
                                <table width="100%" height="158" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center"><table width="272" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="123" height="25" align="left">公司名:</td>
                                                    <td width="268" align="left"><label>
                                                            <input type="text" name="textUserName"  size="20" onblur="checkUserName()"><span id="idcheck"></span>
                                                        </label></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="left">密 码：</td>
                                                    <td align="left"><input type="password" name="textUserPW1" size="20"></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="left">密码确认:</td>
                                                    <td align="left"><input type="password" name="textUserPW2" size="20" onblur="checkPW()"><span id="pwcheck"></span></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="left">邮箱:</td>
                                                    <td align="left"><input type="text" name="textEmail" size="20" onblur="checkEmail()"><span id="emailcheck"></span></td>
                                                </tr>
                                                <tr>
                                                    <td height="25" align="left">公司地址:</td>
                                                    <td align="left"><input type="text" name="textCompanyName" size="20"onblur="checkCompany()"><span id="companycheck"></span></td>
                                                </tr>
                                            </table></td>
                                        <td width="232" align="right" valign="top"><img src="images/user2/images/register_08.gif" width="232" height="172" /></td>
                                    </tr>
                                </table>
                                <table width="623" height="41" border="0" cellpadding="0" cellspacing="0">
                                    <table width="623" height="41" border="0" cellpadding="0" cellspacing="0">
                                        <tr align="center">
                                            <td width="39">&nbsp;</td>
                                            <td width="37"><input type="submit" name="regSubmit" onclick="check()"/ value="注册"></td>
                                            <td width="09"> <input type="reset" name="name" value="清空"/>   </td>
                                            <td width="119">&nbsp;</td>
                                        </tr>
                                    </table>
                                    </td>
                                    </tr>
                                </table>
                            </form>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="9"><img src="images/user2/images/register_31.gif" width="9" height="44" /></td>
                                    <td background="images/user2/images/register_32.gif">&nbsp;</td>
                                    <td width="11"><img src="images/user2/images/register_34.gif" width="11" height="44" /></td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table></td>
                        <td class="bg">&nbsp;</td>
                    </tr>
                </table>
                <iframe id="ifr" name="ifr" style="display:none" ></iframe>
</body>
</html>


