<?php
include("conn.php");
if(isset($_POST['username']))
{
$username=$_POST['username'];
if($username=='')
{
	echo 1;
}
else{
$sql="select * from `user`where`username`='".$username."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
if($arr)
{  echo 1;}
	else{
		echo 0;
	}
}
}


?>