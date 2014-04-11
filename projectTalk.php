<style type="text/css">
    td {
        line-height: 16pt;
        font-size: 10pt;
        font-family: "Verdana", "Arial", "Helvetica", "sans-serif";
    }
    body {
        font-size: 10pt;
        line-height: 13pt;
        background-color: #ECF5FF;
    }
    .border {
        border: 1px solid #1D5892;
    }
    textarea {
        font-size: 8pt;
        font-family: "Verdana", "Arial", "Helvetica", "sans-serif";
        border: 1px solid #999999;
        padding: 5px;


    }
    select {
        font-size: 8pt;
        padding: 1px;
        font-family: "Tahoma";
    }
    .a1:link {
        color: #FFFFFF;
    }
    .a1:visited {
        color: #FFFFFF;
    }
    .a1:hover {
        color: #FF9900;
    }
    .font14 {
        font-size: 14px;
        font-family: "Tahoma";
    }
    form {
        margin: 0px;
        padding: 0px;
    }
    .alpha {
        filter: Alpha(Opacity=20);
    }
    .filearea {
        font-size: 9pt;
    }
    .textdrow {
        color:#666666;
        filter: DropShadow(Color=white, OffX=1, OffY=1, Positive=1);
    }
    .font18 {
        font-size: 19px;
    }
    .p {
        text-indent: 24px;
    }
    .font16 {
        font-size: 16px;
    }
    .border2 {
        border: 1px solid #D5E4F4;
    }
    .xborder {
        border: 2px dotted #EBF5FE;
    }
</style>
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
$sql="SELECT * FROM `message` where `mrec`='".$_COOKIE['project']."@".getCompany($_COOKIE['name'],$mysql)."'order by 4 desc";
$query=mysql_query($sql,$mysql);
while($row=mysql_fetch_array($query)){
    ?>

    <table width=500 border="0" cellpadding="0" cellspacing="0" bgcolor="#add3ef" align="center">
        <tr bgcolor="#eff3ff">
            <td>标题：<?php echo "<a href='projectDetailTalk.php?mid=".$row['mid']."' target='_blank'>".$row['mtitle']."</a>" ?> </td>
            <td>用户：<?php echo $row['msend']?></td>
        </tr>
        <tr bgColor="#ffffff">
            <td colspan="2">内容：<?php
                echo substr($row['mcontent'],0,12)."...";
                echo "  at  ". $row['msendtime'];
                $sqlr="select * FROM `reply` where `mid`='".$row['mid']."';";
                $rr=mysql_query($sqlr,$mysql);
                echo " 有回复".mysql_num_rows($rr)."条";
                ?></td>
        </tr>
    </table>
<?php
}?>
<?php
if(isset($_GET['submitTalk']))
{
    $people=$_COOKIE['name'];
    $content=$_GET['content'];
    $sql="insert into `message`(`mtitle`,`msend`,`mrec`,`msendtime`,`mflag`,`mrectime`,`mcontent`) values ('".
        $_GET['text']."','".$_COOKIE['name']."','".$_COOKIE['project']."@".getCompany($_COOKIE['name'],$mysql)."',now(),0,now(),'".$_GET['content']."');";
    $result=mysql_query($sql,$mysql);
    $content="在项目交流中发表了  ".$_GET['text'];
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project']."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    if($result)
    {
        echo "<script> alert('消息发送成功!');</script>";
    }
    header("Location:pnavigation.php");
}
?>
<form id="form" name="formTalk" method="get">
    <table  border="0" align="center">
        <tr>
            <td  align="center">  发表内容：
                <input type="text" name="text"placeholder="请输入标题" /></td>
        </tr>
        <tr>
            <td align="center"><input  type="text" name="content" id="content" ></td>
        </tr>
        <tr>
            <td align="center"><input type="submit" name="submitTalk"  value="提交" /></td>
        </tr>
    </table>
</form>

