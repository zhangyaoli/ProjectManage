<script type="text/javascript" language="javascript">
    var a=confirm("确定要删除该文件吗？");
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
$dir=urldecode($_SERVER['QUERY_STRING']);

$arr=explode("=",$dir);
$dir=@$arr[1];
$arr=explode("/",$dir);
$name=@$arr[count($arr)-1];
$project=@$arr[2];
$sql="delete from `document` where `daddress`='".$dir."';";
mysql_query($sql,$mysql);
@unlink(iconv('utf-8','gb2312',$dir));
$content="删除了项目 ".$project." 内部的文件 ".$name;
$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project']."','".$content."',NOW(),'".$_COOKIE['name']."');";
mysql_query($sql,$mysql);
echo "<script> alert('删除成功');window.location.href='pnavigation.php';</script>";
?>