
<?php
include("conn.php");
//读取消息，rec收件人,type为读取方式，1未读信息2 已读信息 3读回复
function readMessage($rec,$type)
{
    global $mysql;
    if($type==1)
    {
        echo "<form name='myForm' method='get'>";
        $sql="select * from `message` where `mrec`='".$rec."' and `mflag`=0;";
        $result=mysql_query($sql,$mysql);
        echo "<table border='1'><tr><th>消息状态</th><th>标题</th><th>发件人</th><th>内容</th><th>发送时间</th></tr>";
        while($arr=mysql_fetch_array($result))
        {
            echo "<tr><td><input type='checkbox' name='".$arr['mtitle']."' value=1/>已读</td><td>".$arr['mtitle']."</td><td>".$arr['msend']."</td>" .
                "<td>".$arr['mcontent']."</td><td>".$arr['msendtime']."</td></tr>";
            echo "<tr><td colspan='5'> 回复信息:<input type='text' name='text".$arr['mtitle']."' size='30'></td></tr>";
        }
        echo "</table>";
        echo "<input type='submit' name='mySubmit' value='提交'></form>";
    }
    else if($type==2)
    {
        $sql="select * from `message` where `mrec`='".$rec."' and `mflag`=1;";
        $result=mysql_query($sql,$mysql);
        echo "<table border='1'><tr><th>消息状态</th><th>标题</th><th>发件人</th><th>内容</th><th>发送时间</th></tr>";
        while($arr=mysql_fetch_array($result))
        {
            echo "<tr><td>已读</td><td>".$arr['mtitle']."</td><td>".$arr['msend']."</td>" .
                "<td>".$arr['mcontent']."</td><td>".$arr['msendtime']."</td></tr>";
        }
        echo "</table>";
    }
    else if ($type==3)
    {
        $sql="select * from `message` where `msend`='".$rec."' and `mreccontent`!='';";
        $result=mysql_query($sql,$mysql);
        echo "<table border='1'><tr><th>标题</th><th>发送时间</th><th>收件人</th><th>回复时间</th><th>回复内容</th></tr>";
        while($arr=mysql_fetch_array($result))
        {
            echo "<tr><td>".$arr['mtitle']."</td><td>".$arr['msendtime']."</td><td>".$arr['mrec']."</td>" .
                "<td>".$arr['mrectime']."</td><td>".$arr['mreccontent']."</td></tr>";
        }
        echo "</table>";
    }
}
readMessage($_COOKIE['name'],1);
readMessage($_COOKIE['name'],3);
?>

<?php
//更新表中消息的mflag
if(isset($_GET['mySubmit']))
{
    $sql="select * from `message` where `mrec`='".$_COOKIE['name']."' and `mflag`=0;";
    $result=mysql_query($sql,$mysql);
    while(@$arr=mysql_fetch_array($result))
    {
        if(isset($_GET[$arr['mtitle']]))
        {
            $sql2="update `message` set `mflag`=1 where `mtitle`='".$arr['mtitle']."'and `mrec`='".$_COOKIE['name']."';";
            $result2=mysql_query($sql2,$mysql);
        }
        $text="text".$arr['mtitle'];
        if(isset($_GET[$arr['mtitle']])&&isset($_GET[$text]))
        {
            $sql3="update `message` set `mreccontent`='".$_GET[$text]."',`mrectime`=NOW() where `mtitle`='".$arr['mtitle']."'and `mrec`='".$_COOKIE['name']."';";
            $result3=mysql_query($sql3,$mysql);
        }//不设置消息状态就不提交回复更新
        else if(!isset($_GET[$arr['mtitle']])&&isset($_GET[$text]))
        {
            echo "<script>alert('先设置已读再回复！')</script>";
            $result=0;
        }
    }
    if($result)
    {
        echo "<script> alert('更新成功!');</script>";
    }

}
?>
