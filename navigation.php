<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
    <!--
    #demo-container{padding:25px 15px 0 15px;background:#67A897;}
    ul#simple-menu{list-style-type:none;width:100%;position:relative;height:27px;font-family:"Trebuchet MS",Arial,sans-serif;font-size:13px;font-weight:bold;margin:0;padding:11px 0 0 0;}
    ul#simple-menu li{display:block;float:left;margin:0 0 0 4px;height:27px;}
    ul#simple-menu li.left{margin:0;}
    ul#simple-menu li a{display:block;float:left;color:#fff;background:#4A6867;line-height:27px;text-decoration:none;padding:0 17px 0 18px;height:27px;}
    ul#simple-menu li a.right{padding-right:19px;}
    ul#simple-menu li a:hover{background:#2E4560;}
    ul#simple-menu li a.current{color:#2E4560;background:#fff;}
    ul#simple-menu li a.current:hover{color:#2E4560;background:#fff;}
    -->
</style>
</html>
<?php
include("conn.php");
//提示有新消息,参数是用户名
function showMessageNum($rec)
{
    global $mysql;
    $count=0;
    $sql="select * from `message` where `mrec`='".$rec."' and `mflag`=0;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        $count++;
    }
    if($count)
    {
        $str=$count."条新消息";
        return $str;
    }
    return "";
}
//提示有新回复，参数是用户名
function showRecNum($rec)
{
    global $mysql;
    $count=0;
    $sql="select * from `message` where `msend`='".$rec."' and `mreccontent`!='';";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        $count++;
    }
    if($count)
    {
        $str=$count."条回复";
        return$str;
    }
    return "";
}
?>
<div id="demo-container">
    <ul id="simple-menu">
        <?php echo "你好,".$_COOKIE['name'];?>
        <li><a href="project.php" title="项目">项目</a></li>
        <li><a href="document.php" title="文档">文档</a></li>
        <li><a href="message.php" title="交流"><?php echo "交流(".showMessageNum($_COOKIE['name']).showRecNum($_COOKIE['name']).")"; ?></a></li>
        <li><a href="log.php" title="工作计划">工作计划</a></li>

        <?php
        $sql="select * from `user` where `username`='".$_COOKIE['name']."';";
        $result=mysql_query($sql,$mysql);
        $arr=mysql_fetch_array($result);
        if($arr['power']==0)
        {
            echo "<li><a href='logP.php' title='日志'>日志</a></li>";
            echo "<li><a href='projectCreate.php' title='新建项目'>新建项目</a></li>";
            echo "<li><a href='setpeople.php' title='人员设置'>人员设置</a></li>";
            echo "<li><a href='cooperation.php' title='协作管理'>协作管理</a></li>";
        }
        ?>
        <li><a href="exit.php" title="退出">退出</a></li>
    </ul>
</div>
<script language="javascript">
    var myNav = document.getElementById("demo-container").getElementsByTagName("a");
    for(var i=0;i<myNav.length;i++)
    {
        var links = myNav[i].getAttribute("href");
        var myURL = document.location.href;
        if(myURL.indexOf(links) != -1)
        {
            myNav[i].className="current";
        }
    }


</script>


