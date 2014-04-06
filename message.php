<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>无标题文档</title>
<style type="text/css">
    body{
        font-size:12px;
        background-image: url(images/bg.gif);
        background-repeat: repeat;
    }
    ul,li,h2{margin:0;padding:0;}
    ul{list-style:none;}
    #top{
        width:909px;
        height:26px;
        background-image: url(images/images/h2bg.gif);
        margin-top: 50px;
        margin-right: auto;
        margin-bottom: 0;
        margin-left: auto;
        background-repeat: repeat-x;
    }
    #top h2{
        width:150px;
        height:24px;
        float:left;
        font-size:12px;
        text-align:center;
        line-height:20px;
        color: #FFFFFF;
        font-weight: bold;
        padding-top: 2px;
        border-right-width: 1px;
        border-left-width: 1px;
        border-right-style: solid;
        border-left-style: solid;
        border-right-color: #99BBE8;
        border-left-color: #99BBE8;
    }
    #top .jg {
        width: 5px;
        float: left;
        background-color: #DCE6F5;
        height: 26px;
    }
    #topTags{
        width:740px;
        height:24px;
        float:left;
        margin-top: 0;
        margin-right: auto;
        margin-bottom: 0;
        margin-left: auto;
        padding-top: 2px;
        border-right-width: 1px;
        border-left-width: 1px;
        border-right-style: solid;
        border-left-style: solid;
        border-right-color: #99BBE8;
        border-left-color: #99BBE8;
        padding-left: 10px;
    }
    #topTags ul li{
        float:left;
        width:100px;
        height:21px;
        margin-right:4px;
        display:block;
        text-align:center;
        cursor:pointer;
        padding-top: 3px;
        color: #15428B;
        font-size: 12px;
    }
    #main{
        width:909px;
        height:501px;
        background-color:#F5F7E6;
        margin-top: 0;
        margin-right: auto;
        margin-bottom: 0;
        margin-left: auto;
    }
    #main .jg {
        width: 5px;
        float: left;
        background-color: #DFE8F6;
        height: 500px;
    }
    #leftMenu{
        width:150px;
        height:500px;
        background-color:#DAE7F6;
        float:left;
        border-right-width: 1px;
        border-left-width: 1px;
        border-right-style: solid;
        border-left-style: solid;
        border-right-color: #99BBE8;
        border-left-color: #99BBE8;
    }
    #leftMenu ul{margin:10px;}
    #leftMenu ul li{
        width:130px;
        height:22px;
        display:block;
        cursor:pointer;
        text-align:center;
        margin-bottom:5px;
        background-color: #D9E8FB;
        background-image: url(images/images/tabbg01.gif);
        background-repeat: no-repeat;
        background-position: 0px 0px;
        padding-top: 2px;
        line-height: 20px;
    }
    #leftMenu ul li a{
        color:#000000;
        text-decoration:none;
        background-image: url(images/images/tb-btn-sprite_03.gif);
        background-repeat: repeat-x;
    }
    #content{
        width:750px;
        height:500px;
        float:left;
        border-right-width: 1px;
        border-left-width: 1px;
        border-right-style: solid;
        border-left-style: solid;
        border-right-color: #99BBE8;
        border-left-color: #99BBE8;
        background-color: #DAE7F6;
    }
    .content{
        width:740px;
        height:490px;
        display:none;
        padding:5px;
        overflow-y:auto;
        line-height:30px;
        background-color: #FFFFFF;
    }
    #footer{
        width:907px;
        height:26px;
        background-color:#FFFFFF;
        line-height:20px;
        text-align:center;
        margin-top: 0;
        margin-right: auto;
        margin-bottom: 0;
        margin-left: auto;
        border-right-width: 1px;
        border-left-width: 1px;
        border-right-style: solid;
        border-left-style: solid;
        border-right-color: #99BBE8;
        border-left-color: #99BBE8;
        background-image: url(images/images/h2bg.gif);
        background-repeat: repeat-x;
    }
    .content1 {width:740px;height:490px;display:block;padding:5px;overflow-y:auto;line-height:30px;}
</style>
<script type="text/javascript">
    window.onload=function(){
        function $(id){return document.getElementById(id)}
        var menu=$("topTags").getElementsByTagName("ul")[0];//顶部菜单容器
        var tags=menu.getElementsByTagName("li");//顶部菜单
        var ck=$("leftMenu").getElementsByTagName("ul")[0].getElementsByTagName("li");//左侧菜单
        var j;
//点击左侧菜单增加新标签
        for(i=0;i<ck.length;i++){
            ck[i].onclick=function(){
                $("welcome").style.display="none"//欢迎内容隐藏
                clearMenu();
                this.style.background='url(images/images/tabbg02.gif)'
//循环取得当前索引
                for(j=0;j<8;j++){
                    if(this==ck[j]){
                        if($("p"+j)==null){
                            openNew(j,this.innerHTML);//设置标签显示文字
                        }
                        clearStyle();
                        $("p"+j).style.background='url(images/images/tabbg1.gif)';
                        clearContent();
                        $("c"+j).style.display="block";
                    }
                }
                return false;
            }
        }
//增加或删除标签
        function openNew(id,name){
            var tagMenu=document.createElement("li");
            tagMenu.id="p"+id;
            tagMenu.innerHTML=name+"&nbsp;&nbsp;"+"<img src='images/images/off.gif' style='vertical-align:middle'/>";
//标签点击事件
            tagMenu.onclick=function(evt){
                clearMenu();
                ck[id].style.background='url(images/images/tabbg02.gif)'
                clearStyle();
                tagMenu.style.background='url(images/images/tabbg1.gif)';
                clearContent();
                $("c"+id).style.display="block";
            }
//标签内关闭图片点击事件
            tagMenu.getElementsByTagName("img")[0].onclick=function(evt){
                evt=(evt)?evt:((window.event)?window.event:null);
                if(evt.stopPropagation){evt.stopPropagation()} //取消opera和Safari冒泡行为;
                this.parentNode.parentNode.removeChild(tagMenu);//删除当前标签
                var color=tagMenu.style.backgroundColor;
//设置如果关闭一个标签时，让最后一个标签得到焦点
                if(color=="#ffff00"||color=="yellow"){//区别浏览器对颜色解释
                    if(tags.length-1>=0){
                        clearStyle();
                        tags[tags.length-1].style.background='url(images/images/tabbg1.gif)';
                        clearContent();
                        var cc=tags[tags.length-1].id.split("p");
                        $("c"+cc[1]).style.display="block";
                        clearMenu();
                        ck[cc[1]].style.background='url(images/images/tabbg1.gif)';
                    }
                    else{
                        clearContent();
                        clearMenu();
                        $("welcome").style.display="block"
                    }
                }
            }
            menu.appendChild(tagMenu);
        }
//清除菜单样式
        function clearMenu(){
            for(i=0;i<ck.length;i++){
                ck[i].style.background='url(images/images/tabbg01.gif)';
            }
        }
//清除标签样式
        function clearStyle(){
            for(i=0;i<tags.length;i++){
                menu.getElementsByTagName("li")[i].style.background='url(images/images/tabbg2.gif)';
            }
        }
//清除内容
        function clearContent(){
            for(i=0;i<7;i++){
                $("c"+i).style.display="none";
            }
        }
    }
</script>
</head>

<?php
include("navigation.php");
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
?>
<body>
<div id="top">
    <h2>管理菜单</h2>
    <div class=jg></div>
    <div id="topTags">
        <ul>
        </ul>
    </div>
</div>
<div id="main">
    <div id="leftMenu">
        <ul>
            <li>未读信息</li>
            <li>读取回复</li>
            <li>已读信息</li>
            <li>发送信息</li>
        </ul>
    </div>
    <div class=jg></div>
    <div id="content">
        <div id="welcome" class="content" style="display:block;">
            <div align="center">
                <p>&nbsp;</p>
                <p><strong>欢迎使用用户管理系统！</strong></p>
                <p>&nbsp;</p>
            </div>
        </div>
        <div id="c0" class="content"><?php readMessage($_COOKIE['name'],1);  ?></div>
        <div id="c1" class="content"><?php readMessage($_COOKIE['name'],3);  ?></div>
        <div id="c2" class="content"><?php  readMessage($_COOKIE['name'],2); ?></div>
        <div id="c3" class="content"><script language="JavaScript" type="text/javascript" src="js/select.js"></script>

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
            //$_COOKIE['name']="admin@A";
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
            ?></div>
        <div id="c4" class="content">风格管理</div>
        <div id="c5" class="content">系统管理</div>
        <div id="c6" class="content">帮助信息</div>
    </div>
</div>
<div id="footer">copyright for lalasxc 美化 by myhero</div>
</body>
</html>
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
