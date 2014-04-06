<?php
function  modifyStaffName($username,$newname,$mysql)
{
    $sql="update `user` set `username`='".$newname."'where`username`='".$username."';";
    mysql_query($sql,$mysql);
}
//函数复制修改的，参数内容别看名字
function  modifyStaffPW($username,$newname,$mysql)
{
    $sql="update `user` set `userpw`='".$newname."'where`username`='".$username."';";
    mysql_query($sql,$mysql);
}
function  modifyStaffEmail($username,$newname,$mysql)
{
    $sql="update `user` set `useremail`='".$newname."'where`username`='".$username."';";
    mysql_query($sql,$mysql);
}
function  modifyStaffPower($username,$newname,$mysql)
{
    $sql="update `user` set `power`='".$newname."'where`username`='".$username."';";
    mysql_query($sql,$mysql);
}
include("conn.php");
//通过url传值，下面username取得url中的username
$arr=explode("=",$_SERVER['QUERY_STRING']);
@$username=$arr[1];
$sql="select * from `user`where`username`='".$username."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
if(isset($_POST['mySubmit']))
{
    $name=$_POST['textname'];
    $pw=$_POST['textpw'];
    $email=$_POST['textemail'];
    $post=$_POST['textpower'];
    $sql="update `user` set `username`='".$name."',`userpw`='".$pw."',`post`='".$post."',`useremail`='".$email."'where`username`='".$username."';";
    mysql_query($sql,$mysql);
    header("location:setpeople.php");

}

?>
<html>
<head><title></title>
</head>
<form  name="myForm" method="POST">
    用户名:<input type="text" name="textname" value="<?php echo $arr['username']?>"><br>
    密&nbsp&nbsp码:<input type="text" name="textpw" value="<?php echo $arr['userpw']?>"><br>
    邮&nbsp&nbsp箱:<input type="text" name="textemail" value="<?php echo $arr['useremail']?>"><br>
    职&nbsp&nbsp位:
    <select name="textpower" size="1">
        <option value="项目开发员">项目开发员</option>
        <option value="项目反馈员">项目反馈员</option>
        <option value="项目架构员">项目架构员</option>
    </select>
    <input type="submit" name="mySubmit" value="修改">
</form>

