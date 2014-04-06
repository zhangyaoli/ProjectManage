<script type="text/javascript" language="javascript">
    var a=confirm("确定要删除该模块吗？");
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
$tname=$_SERVER['QUERY_STRING'];
$cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
$sql="delete from `thread` where `tcnamepro`='".$cnamepro."' and `tname`='".$tname."';";
$result=mysql_query($sql,$mysql);
$content="删除了项目 ".$_COOKIE['project']." 内部的模块 ".$tname;
$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project']."','".$content."',NOW(),'".$_COOKIE['name']."');";
mysql_query($sql,$mysql);
echo "<script> alert('删除成功');window.location.href='pnavigation.php';</script>";
?>