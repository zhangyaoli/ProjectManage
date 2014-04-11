<html>
<head>
    <meta charset="UTF-8"/>
</head>
<body>

<?php
include("conn.php");
//通过url传值，下面username取得url中的username
$arr=explode("=",$_SERVER['QUERY_STRING']);
@$username=$arr[1];
$sql="delete from `user` where `username`='".$username."';";
mysql_query($sql,$mysql);
echo "<script> alert('删除成功');window.location.href='setpeople.php';</script>";
?>
</body>
</html>