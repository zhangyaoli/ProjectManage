<script type="text/javascript" language="javascript">
    var a=confirm("确定要提交完成任务吗？");
    if(!a)
    {
        window.history.back(-1);
    }
</script>

<?php
include("conn.php");
//通过url传值，下面username取得url中的username
$arr=explode("=",$_SERVER['QUERY_STRING']);
@$tid=$arr[1];
echo $arr[1];
$sql="update `task` SET `apply` = 1 where `tid`='".$tid."';";
mysql_query($sql,$mysql);
$sql="select  * from `task` where `tid`='".$tid."';";
$r=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($r);
$content="申请完成 ".$arr['content']." 任务";
$company1=$arr['project'];
@$arrtitle=explode("@",$company1);
@$company1=$arrtitle[1]."@".$arrtitle[0];
$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$company1."','".$content."',NOW(),'".$_COOKIE['name']."');";
mysql_query($sql,$mysql);
echo "<script> alert('提交成功');window.location.href='pnavigation.php';</script>";
?>