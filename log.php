<script language="javascript" type="text/javascript">
    function showDiv(id)
    {
        document.getElementById(id).style.display="";
    }
    function hidDiv(id)
    {
        document.getElementById(id).style.display="none";
    }
</script>
<?php
include("navigation.php");
function showFileNoPower($filename,$name)
{
    global $mysql;
    global $today;
    if(strstr($filename,".")){//该文件名不是文件夹
        if($filename!="."||$filename!=".."){
            $sql="select * from `logfile` where `lfilename`='".$filename."' and `luser`='".$name."' and `ltime`='".$today."';";
            $result=mysql_query($sql,$mysql);
            $arr=mysql_fetch_array($result);
            if($arr){
            echo $arr['lfilename']." ".$arr['ltime'];
            echo " <a href='download.php?fileDir=".$arr['lfileway']."'>下载</a>"."<br>";
            }
        }
    }
    else//该文件名是文件夹
    {
        $sql="select * from `folder` where `fname`='".$filename."';";
        $result=mysql_query($sql,$mysql);
        $arr=mysql_fetch_array($result);
        echo $filename."  ";
        echo "<a href='showdir.php?path=".$arr['faddress']."'target='_blank'>进入文件夹</a>"."<br>";
    }
}
function showFolderNoPower($folder,$name)
{
    $arr=scandir($folder);
    echo "文件名  上传日期  下载"."<br>";
    foreach($arr as$key=>$value)
    {
        if($key>1){
            showFileNoPower($value,$name);
        }
    }
}
function updateFile($arrFile,$username,$today)
{
    global $mysql;
    $path="./logfile/";
    $fileway=$path."/".$arrFile['name'];
    if($arrFile['error']==0)
    {
        move_uploaded_file($arrFile['tmp_name'],$fileway);
        $sql="insert into `logfile`(`luser`,`ltime`,`lfilename`,`lfileway`)values('".$_COOKIE['name'].
            "','".$today."','".$arrFile['name']."','".$fileway."');";
        $result=mysql_query($sql,$mysql);
    }
}
include("conn.php");
include("time.php");
//$_COOKIE['name']="admin@A";
//day才是今天日期 today是日历上的日期，当时写反了
$day=date("Y-m-d");
$today=$Year."-".$Month."-".$Day;
?>

<?php
$sql="select * from `log` where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
?>
<div id="jh">工作计划:
    <?php  if(strtotime($day)-strtotime($today)==0){?>
    <div id="addjh" style="display:none">
        <form name="form1" method="post">
            添加
            <textarea name="area1" rows="5" cols="30" wrap="off"></textarea>
            <input type="submit" name="mySubmit1" value="添加"/>
        </form>
    </div>
    <div id="mjh" style="display:none">
        <form name="form11" method="post">
            修改
            <textarea name="area11" rows="5" cols="30" wrap="off"><?php echo $arr['ljh'];?></textarea>
            <input type="submit" name="mySubmit11" value="修改"/>
        </form>
    </div>
    <div id="m10" style="display:'none'"><a href='#' onClick="javascript:showDiv('addjh');">添加计划</a></div>
    <div id="m11" style="display:'none'"><a href='#' onClick="javascript:showDiv('mjh');">修改计划</a></div>
    <?php
//    if(strtotime($day)-strtotime($today)==0)
//    {
        if($arr)
        {
            echo $arr['ljh'];
            echo "<script> showDiv('m11')</script>";

        }else{
            echo "<script> showDiv('m10')</script>";
            echo "<script> hidDiv('m11')</script>";
        }
    }else if(strtotime($day)-strtotime($today)>0)
    {
       // echo "过去的日志不能修改"."<br>";
        if($arr)
        {
            echo $arr['ljh'];
        }
    }else if(strtotime($day)-strtotime($today)<0)
    {
        echo "到了再说";
    }
    ?>

</div>
<div id="jl">工作记录: <?php  if(strtotime($day)-strtotime($today)==0){?>
    <div id="addjl" style="display:none">
        <form name="form2" method="post">
            添加
            <textarea name="area2" rows="5" cols="30" wrap="off"></textarea>
            <input type="submit" name="mySubmit2" value="添加"/>
        </form>
    </div>
    <div id="mjl" style="display:none">
        <form name="form22" method="post">
            修改
            <textarea name="area22" rows="5" cols="30" wrap="off"><?php echo $arr['ljl'];?></textarea>
            <input type="submit" name="mySubmit22" value="修改"/>
        </form>
    </div>
    <div id="m20" style="display:'none'"><a href='#' onClick="javascript:showDiv('addjl');">添加记录</a></div>
    <div id="m21" style="display:'none'"><a href='#' onClick="javascript:showDiv('mjl');">修改记录</a></div>
    <?php }
    $sql="select * from `log` where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
    $result2=mysql_query($sql,$mysql);
    $arr2=mysql_fetch_array($result2);
    if(strtotime($day)-strtotime($today)==0){
        if($arr2['ljl']!='')
        {
            echo $arr2['ljl'];
            echo "<script> showDiv('m21')</script>";

        }else{
            echo "<script> showDiv('m20')</script>";
            echo "<script> hidDiv('m21')</script>";
        }
    }else if(strtotime($day)-strtotime($today)>0)
    {
    //    echo "过去的日志不能修改"."<br>";
        if($arr2['ljl']!='')
        {
            echo $arr['ljl'];
        }
    }else if(strtotime($day)-strtotime($today)<0)
    {
        echo "到了再说";
    }
    ?>
</div>
<div id="fj"><?php  $path="./logfile"; if(strtotime($day)-strtotime($today)==0){?>上传附件:
    <div id="upfile" style="display:''"><form name="form3" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" name="mySubmit3" value="上传"/>
        </form></div>
    <?php
        echo "<script> showDiv('upfile');</script>";
        showFolderNoPower($path,$_COOKIE['name']);
    }
    else if(strtotime($day)-strtotime($today)>0)
    {
        echo "<script> hidDiv('upfile');</script>";
      //  echo "过去的日志不能修改"."<br>";
        showFolderNoPower($path,$_COOKIE['name']);
    }else if(strtotime($day)-strtotime($today)<0)
    {
    //    echo "到了再说";
        echo "<script> hidDiv('upfile');</script>";
    }

    ?>

</div>
<?php
if(isset($_POST['mySubmit1']))
{
    $sql="insert into`log`(`luser`,`ltime`,`ljh`) values ('".$_COOKIE['name']."','".$today."','".$_POST['area1']."');" ;
    $result=mysql_query($sql,$mysql);
    echo "<script>alert('添加计划完毕，刷新页面可查看');</script>";
    //下面注释后来发现更麻烦，还是直接刷新一遍算了。。
    //刷新页面显示提交内容会导致表单重复提交，可以用session阻止，但会跳提示框，这样直接显示方便点
    //$sql="select * from `log` where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
//$result=mysql_query($sql,$mysql);
//$arr=mysql_fetch_array($result);
//echo "<script> document.getElementById('jh').innerHTML='工作计划:".$arr['ljh']."';hidDiv('addjh');</script>";
//echo "<script> showDiv('m11');</script>";
//echo "<script> showDiv('m10');</script>";
}
if(isset($_POST['mySubmit11']))
{
    $sql="update `log` set `ljh`='".$_POST['area11']."' where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
    $result=mysql_query($sql,$mysql);
    //下面注释后来发现更麻烦，还是直接刷新一遍算了。。
    echo "<script>alert('修改计划完毕，刷新页面可查看');</script>";
    //刷新页面显示提交内容会导致表单重复提交，可以用session阻止，但会跳提示框，这样直接显示方便点
//echo "<script> document.getElementById('jh').innerHTML='工作计划:".$arr['ljh']."';hidDiv('mjh');</script>";
}
if(isset($_POST['mySubmit2']))
{
    $sql="update `log` set `ljl`='".$_POST['area2']."' where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
    $result=mysql_query($sql,$mysql);
    echo "<script>alert('添加记录完毕，刷新页面可查看');</script>";
}
if(isset($_POST['mySubmit22']))
{
    $sql="update `log` set `ljl`='".$_POST['area22']."' where `luser`='".$_COOKIE['name']."' and `ltime`='".$today."';";
    $result=mysql_query($sql,$mysql);
    echo "<script>alert('添加记录完毕，刷新页面可查看');</script>";
}
if(isset($_POST['mySubmit3']))
{
    updateFile($_FILES['file'],$_COOKIE['name'],$today);
    echo "<script>alert('文件上传完毕，刷新页面可查看');</script>";
}
