<?php
include("conn.php");
include("navigation.php");
//获取用户所在公司，参数为登录用户名,$mysql为打开数据库的操作符
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
function getCompanyAddress($username,$mysql){
    $sql="select * from `user`where`username`='".$username."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($arr){
        $company=$arr['usercompany'];
    }else{
        $company="找不到该公司";
    }
    return $company;
}
//添加公司职员，参数是user表的字段以及数据库操作符
function createStaff($username,$userpw,$power,$useremail,$usercompany,$cname,$mysql)
{
    $sql="select * from `user`where`username`='".$username."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($arr)
    {  echo "<script> alert('该员工已存在!');</script>";}
    else{
        $sql="INSERT INTO `user`(`username`,`userpw`,`power`,`useremail`,`usercompany`,`cname`)values('".$username."','".$userpw."','".$power."','".$useremail."','".$usercompany."','".$cname."');";
        mysql_query($sql,$mysql);
        echo "<script> alert('成功添加员工!');</script>";
    }
}

?>
<?php
include("conn.php");
$sql="select * from `user` where `cname`='".getCompany(@$_COOKIE['name'],$mysql)."';";
$result=mysql_query($sql,$mysql);
echo "<table align='left' border='1'>".
    "<tr> <td>用户名</td><td>密码</td><td>职位</td><td>邮箱</td><td>操作</td></tr>";
while($arr=mysql_fetch_array($result))
{
    echo" <tr>" .
        "<td>".$arr['username']."</td>".
        "<td>".$arr['userpw']."</td>".
        "<td>".$arr['post']."</td>".
        "<td>".$arr['useremail']."</td>".
        "<td><a href='modifyStaff.php?username=".$arr['username']."'>编辑</a> <a href='selectdelete.php?username=".$arr['username']."'>删除</td>".
        "</tr>";
}
echo "</table><hr>"
?>
<form name="addForm" method="get" action="addStaff.php">
    <input type="submit" name="addSubmit" value="添加新员工">
</form>
