<table>
    <tr><form  method="post" >
            <td><input type='radio' name='radio'value='1' checked>同意完成<input type='radio' name='radio'value='0'>未完成</td></tr>
    <tr><td> 回复：<textarea name="content" rows="2" cols="30" wrap="off"></textarea></td></tr>
    <tr><td>
            <input type="submit" name="submit" value="提交 "/>

        </td></tr>
    </form>
</table>
<?php
include("conn.php");
//通过url传值，下面username取得url中的username
$arr=explode("=",$_SERVER['QUERY_STRING']);
@$tid=$arr[1];
if(isset($_POST['submit']))
{
    $sql="update `task` SET `apply` = '0',`complete`='".$_POST['radio']."',`recontent`='".$_POST['content']."' where `tid`='".$tid."'";
    mysql_query($sql,$mysql);
    $sql="select * from `task` where `tid`='".$tid."';";
    $r=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($r);
    $content="回应了 ".$arr['content']."任务的申请完成 回应结果为 ".$_POST['radio']." 留言为 ".$_POST['content'];
    $company1=$arr['project'];
    @$arrtitle=explode("@",$company1);
    @$company1=$arrtitle[1]."@".$arrtitle[0];
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$company1."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    echo "<script> alert('提交成功');window.location.href='pnavigation.php';</script>";
}
?>