<script type="text/javascript" language="javascript">
var a=confirm("删除该文件夹会同时删除目录下的文件，确定要删除吗");
if(!a)
{
	//window.location.href="setpeople.php";
	window.history.back(-1);
}
</script>

<?php
include("conn.php");
function getCompany($username,$mysql){
	$sql="select * from `user`where`username`='".$username."';";
	$result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($arr){
    $company=$arr['cname'];
    }else{
    	$company="找不到该公司";
    }
    return $company;
}
$dir=$_SERVER['QUERY_STRING'];
$dir=explode("=",$dir);
@$dir=$dir[1];
$a=explode("/",$dir);
@$project=$a[3];
$name=$a[count($a)-1];
@$project=getCompany($_COOKIE['name'],$mysql)."@".$project;
$arr=scandir($dir);
$content="删除了文件夹".$name;
	$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$project."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
foreach($arr as $value)
{
	$filedir=$dir."/".$value;
	$sql="delete from `document` where `daddress`='".$filedir."';";
	mysql_query($sql,$mysql);
	@unlink($filedir);
	$content="ͬ同时删除了文件件内的文件".$value;
	$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$project."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
}
rmdir($dir);
echo "<script> alert('删除成功');window.location.href='pnavigation.php';</script>";

?>
