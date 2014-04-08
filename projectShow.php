<?php
include("conn.php");
include("projectTop.php");
$tmparr=explode("=",$_SERVER['QUERY_STRING']);
$pname=$tmparr[1];
$sql="select * from `project` where `pname`='".$pname."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
$tmparr=explode(",",$arr['pstaff']);
setcookie("project",urldecode($pname));
//我把项目管理存在了pstaff的第一个名字中，没设置项目管理人的字段。。。。判断用户是否是项目管理人
if($_COOKIE['name']==$tmparr[0])
{
    setcookie("projectManager",1);
//include("projectTop.php");
    header("location:pnavigation.php");
// header("location:projectMine.php");
}
else
{
    $sql2="select * from `user` where `username`='".$_COOKIE['name']."';";
    $result2=mysql_query($sql2,$mysql);
    $arr2=mysql_fetch_array($result2);
    $post=$arr2['post'];
    switch($post)
    {
        case '项目开发员':
            setcookie("projectManager",2);
            break;
        case '项目反馈员':
            setcookie("projectManager",3);
            break;
        case '项目架构员':
            setcookie("projectManager",2);
            break;
        default:
            break;
    }
    header("location:pnavigation.php");
    //header("location:projectMine.php");
}
?>

