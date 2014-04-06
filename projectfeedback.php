
<?php
//include("conn.php");
//include("projectTop.php");
/*function getCompany($username,$mysql){
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
*/
$sql="SELECT * FROM `feedback` where `recieve`='".$_COOKIE['project']."@".getCompany($_COOKIE['name'],$mysql)."'order by 4 desc";
$query=mysql_query($sql,$mysql);
while($row=mysql_fetch_array($query)){
    ?>

    <table width=500 border="0" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
        <tr bgcolor="#eff3ff">
            <td>标题：<?php echo "<a href='projectfeedbackre.php?mid=".$row['mid']."' target='_blank'>".$row['title']."</a>" ?> </td>
            <td>用户：<?php echo $row['send']?></td>
        </tr>
        <tr bgColor="#ffffff">
            <td colspan="2">内容：<?php
                echo substr($row['content'],0,12)."...";
                echo "  at  ". $row['time'];
                $sqlrr="select * FROM `refeedback` where `mid`='".$row['mid']."';";
                $rrr=mysql_query($sqlrr,$mysql);
                echo " 有回复".mysql_num_rows($rrr)."条";
                ?></td>
        </tr>
    </table>
<?php
}
if(mysql_num_rows($query)==0&&$_COOKIE['projectManager']!=3)
{
    echo "<tr><td>暂时没有反馈人员的信息，请等待</td></tr>";
}
?>
<?php
if(isset($_POST['submit']))
{
    $people=$_COOKIE['name'];
    $content=$_POST['content'];
    $sql="insert into `feedback`(`send`, `recieve`, `time`, `title`, `content`)  values ('".
        $_COOKIE['name']."','".$_COOKIE['project']."@".getCompany($_COOKIE['name'],$mysql)."',now(),'".$_POST['text']."','".$_POST['content']."');";
    $result=mysql_query($sql,$mysql);
    $content="发布了项目反馈".$_POST['text'];
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    if($result)
    {
        echo "<script> alert('消息发送成功!');</script>";
    }
    header("Location:pnavigation.php");
}
?>
<?php
if($_COOKIE['projectManager']==3)
{
    echo " <form id='form' name='form' method='post'>
      <label for='textfield'></label>
        发表内容：
<input type='text' name='text' value='标题' />
<textarea name='content' id='content' cols='45' rows='5'></textarea>
<input type='submit' name='submit'  value='提交' /></form>";
}
?>

</html>