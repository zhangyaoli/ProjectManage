<style type="text/css">
    table{border-left: 1px solid #666; border-bottom: 1px solid #666;}
    th,td{border-right:1px solid #666;border-top: 1px solid #666;}

    tr:hover, td.start:hover, td.end:hover
    {
        background: #FF9;
    }
    th
    {
        border-right:1px solid #666;border-top: 1px solid #666;
    }

    thead th
    {
    }
</style>
<script language="javascript" type="text/javascript" src="js/Calendar1.js"></script>
<script language="javascript" type="text/javascript">
    function moveLeft() {
        var lBox = document.getElementById("leftBox1");
        var rBox = document.getElementById("rightBox1");
        var count = 0;;
        for (var i = 0, len = lBox.length; i < len; i++) { //>
            if (lBox[i].selected) {
                rBox.options.add(new Option(lBox.options[i].text, lBox[i].value));
                count++;
            }
        }
        for (var i = 0; i < count; i++) {   //>
            lBox.remove(lBox.selectedIndex);
        }
    }
    function moveRight() {
        var lBox = document.getElementById("leftBox1");
        var rBox = document.getElementById("rightBox1");
        var count = 0;;
        for (var i = 0, len = rBox.length; i < len; i++) {//>
            if (rBox[i].selected) {
                lBox.options.add(new Option(rBox.options[i].text, rBox[i].value));
                count++;
            }
        }
        for (var i = 0; i < count; i++) {   //>
            rBox.remove(rBox.selectedIndex);
        }
    }
    function selectAll(){
        var rBox = document.getElementById("rightBox1");
        for (var i = 0, len = rBox.length; i < len; i++) {//>
            rBox.options[i].selected=true;
        }


    }
</script>
<?php
function level($num)
{
    switch($num)
    {
        case 1:
            return "需求分析阶段";
        case 2:
            return "概要分析阶段";
        case 3:
            return "详细分析阶段";
        case 4:
            return "编码阶段";
        case 5:
            return "测试阶段";
            break;
    }
}
/*include("conn.php");
include("projectTop.php");
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
*/
$cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
$sql="select * from `project` where `pname`='".$_COOKIE['project']."' and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);//获得该项目信息
$manager=explode(",",$arr['pstaff']);
$manager=$manager[0];//项目经理id
?>
<form name="FormUp"method="get">
    <table weight="600" align="center"  >
        <tr><td colspan="4">项目名称:<?php echo $arr['pname'];?></td></tr>
        <tr><td colspan="4">项目描述:
                <textarea name="area" rows="10" cols="40" wrap="on"><?php echo $arr['pdiscrible'];?>
                </textarea></td></tr>
        <tr><td colspan="4"> 开始时间:<input  name="textST" type="text" onfocus="calendar()"<?php echo "value='".$arr['pstarttime']."'";?> ></td></tr>
        <tr><td colspan="4">结束时间:<input  name="textET" type="text" onfocus="calendar()" <?php echo "value='".$arr['pendtime']."'";?>></td></tr>
        <tr><td colspan="4">项目经理:<select name="PM" size="1">
                    <?php
                    $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";

                    $result3=mysql_query($sql3,$mysql);
                    while($tmparr3=mysql_fetch_array($result3))
                    {
                        if($tmparr3['username']==$manager)
                        {
                            echo "<option value='".$tmparr3['username']."'selected='true'>".$tmparr3['username']."</option>";
                        }else{
                            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option>";
                        }
                    }
                    ?>
                </select></td></tr>
        <tr><td colspan="4">参与人员：</td></tr>
        <tr><td colspan="4" align="center">
                <select  name="leftBox1[]" id="leftBox1" multiple="multiple">
                    <?php
                    $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
                    $result3=mysql_query($sql3,$mysql);
                    while($tmparr3=mysql_fetch_array($result3))
                    {      //将该公司不属于该项目的名单显示
                        if(!strstr($arr['pstaff'],$tmparr3['username'])){
                            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option>";
                        }
                    }
                    ?>
                </select>
                <input type="button" value="添加&gt;&gt;" onclick="moveLeft()"/>
                <input type="button" value="&lt;&lt;撤销" onclick="moveRight()"/>
                <select  name="rightBox1[]" id="rightBox1" multiple="multiple">
                    <?php
                    $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
                    $result3=mysql_query($sql3,$mysql);
                    while($tmparr3=mysql_fetch_array($result3))
                    {
                        //将该公司属于该项目的名单显示,项目经理不显示
                        if(strstr($arr['pstaff'],$tmparr3['username'])&&$tmparr3['username']!=$manager){
                            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option>";
                        }
                    }
                    ?>
                </select></td></tr>
        <tr><td colspan="4"> 项目完成度<input type="text" name="textSpeed" <?php echo "value='".$arr['pspeed']."'";?>  ></td></tr>
        <tr><td colspan='4' align="center">项目模块</td></tr>
        <?php
        echo " <tr><td>模块名称</td><td>模块介绍</td><td>模块所属阶段</td><td>操作</td></tr>";
        $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
        $sql="select * from `thread` where `tcnamepro`='".$cnamepro."' order by 5;";
        $result=mysql_query($sql,$mysql);
        while($arr=mysql_fetch_array($result))//输出该项目下的所有模块
        {
            echo "<tr>";
            echo "<td>".$arr['tname'];
            if($arr['tflag'])
            {
                echo "(已完成)";
            }else
            {
                echo "(未完成)";
            }
            echo "</td>";
            echo "<td>".$arr['tdis']."</td>";
            echo "<td>".level($arr['tlevel'])."</td>";
            echo " <td><a href='projectModifyThread.php?".$arr['tname']."'>修改</a>";
            if(isset($_COOKIE['projectManager']))
            {
                if($_COOKIE['projectManager']==1 &&$arr['tflag']!=1)
                {
                    echo "| <a href='projectDeleteThread.php?".$arr['tname']."'>删除</a>";
                }
            }
            echo "</td></tr>";
        }
        echo "<tr><td align='center' colspan='4'><a href='projectCreateThread.php'>创建新模块</a></td></tr>";
        ?>
        <tr><td colspan='4'>模块贡献度设置(贡献度总和请设置成100)</td></tr><?php
        //获取该项目的所有模块贡献度,并单击可修改,确保贡献度之和为100
        $sql="select * from `project` where `pname`='".$_COOKIE['project']."';";
        $result=mysql_query($sql,$mysql);
        $arr=mysql_fetch_array($result);
        $cnamepro=$arr['cname']."@".$_COOKIE['project'];//取到thread表中属于公司项目的标记
        $sql2="select * from `thread` where `tcnamepro`='".$cnamepro."'order by 5;";
        $result2=mysql_query($sql2,$mysql);
        $s=0;
        while($arr2=mysql_fetch_array($result2))
        {
            $s=$s+$arr2['tcontribution'];
            echo "<tr><td colspan='4' align='center'>";
            echo $arr2['tname'].": <input type='text' name='".$arr2['tname']."' value='".$arr2['tcontribution']."'size='3'>";
        }
        echo "目前总贡献度为".$s;
        echo "</td></tr>";
        ?>
        </tr>
        </td>
        <tr><td colspan='4' align='center'><input type="submit" name="submitUp" value="提交"onclick="selectAll()"></td></tr>
    </table>

</form>
<?php
if(isset($_GET['submitUp']))
{
    $pstaff=$_GET['PM'];
    if(isset($_GET['rightBox1'])){
        foreach($_GET['rightBox1'] as $value)
        {
            $pstaff.=",".$value;
        }
    }
    //将上传的时间转化为可存入mysql的格式
    $stime=strtotime($_GET['textST']);
    $stime=date("Y-m-d H:i:s",$stime);
    $etime=strtotime($_GET['textET']);
    $etime=date("Y-m-d H:i:s",$etime);
    $sql="select * from `project` where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
    $r=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($r);
    $content="";
    if($arr['pdiscrible']!=$_GET['area'])
    {
        $content.="项目描述更改为 ".$_GET['area'].",";
    }
    if($arr['pstarttime']!=$stime)
    {
        $content.="项目开始时间更改为 ".$stime.",";
    }
    if($arr['pendtime']!=$etime)
    {
        $content.="项目结束时间更改为 ".$etime.",";
    }
    if($arr['pstaff']!=$pstaff)
    {
        $content.="项目参与人员更改为 ".$pstaff.",";
    }
    if($arr['pspeed']!=$_GET['textSpeed'])
    {
        $content.="项目进度更改为 ".$_GET['textSpeed'].",";
    }
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    $sql="update `project` set `pdiscrible`='".$_GET['area']."',`pstarttime`='".$stime."',`pendtime`='".$etime."',`pstaff`='".$pstaff.
        "',`pspeed`='".$_GET['textSpeed']."' where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
    $result=mysql_query($sql,$mysql);
    $sql2="select * from `thread` where `tcnamepro`='".$cnamepro."'order by 5;";
    $result2=mysql_query($sql2,$mysql);
    while($arr2=mysql_fetch_array($result2))
    {
        $sql="update `thread` SET `tcontribution`='".$_GET[$arr2['tname']]."' where `tcnamepro`='".$cnamepro."'AND `tname`='".$arr2['tname']."';";
        mysql_query($sql,$mysql);
    }

    if($result)
    {
        echo "<script> alert('更新成功');window.location.href='pnavigation.php';</script>";
    }
}

?>
