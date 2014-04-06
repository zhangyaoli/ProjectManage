<?php
include("conn.php");
$tmparr=explode("=",$_SERVER['QUERY_STRING']);
$mid=$tmparr[1];
$sql="select * from `feedback` where `mid`='".$mid."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
$title=$arr['title'];
$company1=$arr['recieve'];
@$arrtitle=explode("@",$company1);
@$company1=$arrtitle[1]."@".$arrtitle[0];
?>
<html><head><title><?php echo $arr['title'];?></title></head>
<table width=500 border="0" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
    <tr bgcolor="#eff3ff">
        <td>标题：<?php echo $arr['title']?></td>
        <td>用户：<?php echo $arr['send']?> at<?php echo $arr['time']?> </td>
    </tr>
    <tr bgColor="#ffffff">
        <td colspan="2">内容：<?php
            echo $arr['content'];
            ?></td>
    </tr>
    <?php
    $sql2="select * from `refeedback` where `mid`='".$mid."';";
    $result2=mysql_query($sql2,$mysql);
    while($arr2=mysql_fetch_array($result2))
    {
        ?>
        <tr bgcolor="#eff3ff">
            <td colspan="2">re：<?php echo $arr2['content']?>by <?php echo $arr2['people']?> at<?php echo $arr2['time']?> </td>
        </tr></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if(isset($_POST['submit']))
    {
        $people=$_COOKIE['name'];
        $content=$_POST['content'];
        $sql="INSERT INTO `refeedback`(`people`,`time`,`content`,`mid`)values('".$people."',NOW(),'".$content."','".$mid."');";
        mysql_query($sql,$mysql);
        $content="回复了项目反馈  ".$title;
        $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$company1."','".$content."',NOW(),'".$_COOKIE['name']."');";
        mysql_query($sql,$mysql);
        header("Location:pnavigation.php");
    }
    ?>
</table>
<form id="form" name="form" method="post">
    <label for="textfield"></label>
    回复：
    <textarea name="content" id="content" cols="45" rows="5"></textarea>
    <input type="submit" name="submit"  value="提交" /></form>