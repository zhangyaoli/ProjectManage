<html>
<head>
    <meta charset="UTF-8"/>
</head>
<body>
<?php
include("conn.php");
$staff=$_GET['username'];
echo'<script type="text/javascript" language="javascript">
var a=confirm("确定要删除该员工吗？");
if(!a)
{
	//window.location.href="setpeople.php";
	window.history.back(-1);
}
else window.location.href="deleteStaff.php?staff='.$staff.'";

</script>';
?>
<body/>
</html>