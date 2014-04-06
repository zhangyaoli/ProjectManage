<?php
include("conn.php");
//include("projectTop.php");
$tmparr=explode("=",$_SERVER['QUERY_STRING']);
@$mid=$tmparr[1];
$sql="select * from `message` where `mid`='".$mid."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
$company1=$arr['mrec'];
$title1=$arr['mtitle'];
@$arrtitle=explode("@",$company1);
@$company1=$arrtitle[1]."@".$arrtitle[0];
?>
<html><head><title><?php echo $arr['mtitle'];?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
<table width=500 border="0" cellpadding="5" cellspacing="1" bgcolor="#add3ef" align="center">
    <tr bgcolor="#eff3ff">
        <td>标题：<?php echo $arr['mtitle']?></td>
        <td>用户：<?php echo $arr['msend']?> at<?php echo $arr['msendtime']?> </td>
    </tr>
    <tr bgColor="#ffffff">
        <td colspan="2">内容：<?php
            echo $arr['mcontent'];
            ?></td>
    </tr>
    <?php
    $sql2="select * from `reply` where `mid`='".$mid."';";
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
        $sql="INSERT INTO `reply`(`people`,`time`,`content`,`mid`)values('".$people."',NOW(),'".$content."','".$mid."');";
        mysql_query($sql,$mysql);
        $content="回复了  ".$title1;
        $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$company1."','".$content."',NOW(),'".$_COOKIE['name']."');";
        mysql_query($sql,$mysql);
        header("Location:pnavigation.php");
    }
    ?>
</table>
<form id="form" name="form" method="post">
    <table width="500" border="0" align="center" >
        <tr>
            <td  align="center">  <label for="textfield"></label>
                回复：
                <textarea name="content" id="content" cols="45" rows="5"></textarea></td>
        </tr>
        <tr>
            <td align="center"><input type="submit" name="submit"  value="提交" /></form></td>
</tr>
<tr>

</tr>
</table>
