
<?php
include("conn.php");
$dir=urldecode($_SERVER['QUERY_STRING']);
$arr=explode("=",$dir);
@$project=$arr[1];
$a=explode("@",$project);
$a=$a[1];
$sql="select * from `plog` where `project`='".$project."'order by 3;";
$r=mysql_query($sql,$mysql);

?>
<meta charset="utf-8">
<table align="center">
    <tr><td><?php echo urldecode($a)."日志";?></td></tr>
</table>
<?php
while($arr=mysql_fetch_array($r))
{
    echo $arr['people']."在".$arr['time']." ".$arr[' content'];
    echo "<br>";
}

?>