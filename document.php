
<?php
include("conn.php");
include("navigation.php");
//要输出的文件夹路径集合数组,其实可以用cookie传递这个OUTPUT_ARRAY的值，不用每个页面都写
/*写在别的页面了
$OUTPUT_ARRAY=array();
if(isset($_COOKIE['name'])){
$sql="select * from `user` where `username`='".$_COOKIE['name']."';";
$result=mysql_query($sql,$mysql);
$arrUser=mysql_fetch_array($result);
$username=$_COOKIE['name'];//获取用户名
$userPow=$arrUser['power'];//获取用户权限
$sql2="select * from `folder`;";
$resultFolder=mysql_query($sql2,$mysql);
while($arrFolder=mysql_fetch_array($resultFolder))//获取该用户可查看的文件夹
{
	if($userPow<$arrFolder['fpow']&&(strstr($arrFolder['fcnamepro'],$arrUser['cname'])!=""))
	{
		array_push($OUTPUT_ARRAY,$arrFolder['faddress']);
	}else if(strstr($arrFolder['fvp'],$username)&&(strstr($arrFolder['fcnamepro'],$arrUser['cname'])!=""))
	{
		array_push($OUTPUT_ARRAY,$arrFolder['faddress']);
	}
}
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>文档</title>
</head>
<div style="margin-top: 30px; margin-right: auto;margin-bottom: 0;margin-left: 10px;">
    <?php include("documentShow.php");  ?>
</div>
<div style="margin-top: 30px; margin-right: auto;margin-bottom: 0;margin-left: 810px;">
    <?php  include("documentSearch.php");  ?>
</div>
</body>
</html>

