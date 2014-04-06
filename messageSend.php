<script language="JavaScript" type="text/javascript" src="js/select.js"></script>

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
$_COOKIE['name']="admin@A";
?>
<form name="myForm" method="get">
    标题: <input type="text" name="textTitle"  size="15"> <br>
    收件人: <select  name="leftBox" id="leftBox" multiple="multiple">
        <?php
        $sql="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
        $result=mysql_query($sql,$mysql);
        while($tmparr=mysql_fetch_array($result))
        {      //添加的名单剔除登陆用户本身
            if($tmparr['username']!=$_COOKIE['name'])
            {
                echo "<option value='".$tmparr['username']."'>".$tmparr['username']."</option>";
            }
        }
        ?>
    </select>
    </select>
    <input type="button" value="添加&gt;&gt;" onclick="moveLeft()"/>
    <input type="button" value="&lt;&lt;撤销" onclick="moveRight()"/>
    <select  name="rightBox[]" id="rightBox" multiple="multiple">
    </select><br>
    消息内容:
    <textarea name="area" rows="5" cols="30" wrap="off"></textarea><br>

    <input type="submit" name="mySubmit1" value="发送"onclick="selectAll()">
</form>
</form>
<?php
if(isset($_GET['mySubmit1']))
{
    $rec='';
    foreach($_GET['rightBox'] as $value)
    {
        $sql="insert into `message`(`mtitle`,`msend`,`mrec`,`msendtime`,`mflag`,`mrectime`,`mcontent`) values ('".
            $_GET['textTitle']."','".$_COOKIE['name']."','".$value."',now(),0,now(),'".$_GET['area']."');";
        $result=mysql_query($sql,$mysql);
    }
    if($result)
    {
        echo "<script> alert('消息发送成功!');</script>";
    }
}
?>