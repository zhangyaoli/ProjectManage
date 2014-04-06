<?php
include("conn.php");
//获取用户所在公司，参数为登录用户名,$mysql为打开数据库的操作符
function getCompany($username,$mysql){
	$sql="select * from `user`where`username`='".$username."';";
	$result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($arr){
    $company=$arr['cname'];
    }else{
    	return false;
    }
    return $company;
}
function getCompanyAddress($username,$mysql){
	$sql="select * from `user`where`username`='".$username."';";
	$result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($arr){
    $company=$arr['usercompany'];
    }else{
    	$company="找不到该公司˾";
    }
    return $company;
}
//添加公司职员，参数是user表的字段以及数据库操作符
function createStaff($username,$userpw,$post,$useremail,$usercompany,$cname,$mysql)
{
$sql="select * from `user`where`username`='".$username."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
//switch($post)
//{
//	case ""
//}
if($arr)
{  echo "<script> alert('该员工已存在!');</script>";}
	else{
		$sql="INSERT INTO `user`(`username`,`userpw`,`post`,`power`,`useremail`,`usercompany`,`cname`)values('".$username."','".$userpw."','".$post."',5,'".$useremail."','".$usercompany."','".$cname."');";
		mysql_query($sql,$mysql);
		echo "<script> alert('成功添加员工!');</script>";
	}
}
?>
<?php
@$username=$_COOKIE['name'];
$cname=getCompany($username,$mysql);
if(isset($_POST['mySubmit']))
{

	$name=$_POST['textname']."@".$cname;
	$pw=$_POST['textpw'];
	$email=$_POST['textemail'];
	$power=$_POST['textpower'];
	$company=getCompanyAddress($username,$mysql);
	$cname=getCompany($username,$mysql);
	createStaff($name,$pw,$power,$email,$company,$cname,$mysql);
	header("location:setpeople.php");

}

?>
<html>
<head><title></title>
</head>
<form  name="myForm" method="POST">
    用户名:<input type="text" name="textname" value=""><span><?php echo "@".$cname;?></span><br>
    密&nbsp&nbsp码:<input type="text" name="textpw" value=""><br>
    邮&nbsp&nbsp箱:<input type="text" name="textemail" value=""><br>
    职&nbsp&nbsp位:
  <select name="textpower" size="1">
    <option value="项目开发员">项目开发员</option>
    <option value="项目反馈员">项目反馈员</option>
    <option value="项目架构员">项目架构员</option>
  </select>
  <br>
<input type="submit" name="mySubmit" value="添加员工">
</form>
</html>

