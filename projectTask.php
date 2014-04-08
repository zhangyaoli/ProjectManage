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
<script language="javascript" type="text/javascript">
    function moveLeft1() {
        var lBox = document.getElementById("leftBox");
        var rBox = document.getElementById("rightBox");
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
    function moveRight1() {
        var lBox = document.getElementById("leftBox");
        var rBox = document.getElementById("rightBox");
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
    function selectAll1(){
        var rBox = document.getElementById("rightBox");
        for (var i = 0, len = rBox.length; i < len; i++) {//>
            rBox.options[i].selected=true;
        }


    }
</script>
<?php
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
?>
<form id="formTask" name="formTask" method="get" action="">
    <table width="200" border="0" align="center">
        <tr>
            <td>&nbsp;</td>
            <td>发布任务:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input  type="text" name="content" id="content" ></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>接收人:</td>
        </tr>
        <tr>
            <td colspan="2" >
                <select  name="leftBox[]" id="leftBox" multiple="multiple">
                    <?php
                    $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
                    $result3=mysql_query($sql3,$mysql);
                    while($tmparr3=mysql_fetch_array($result3))
                    {
                        //将该公司属于该项目的名单显示
                        if(strstr($arr['pstaff'],$tmparr3['username'])){
                            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option>";
                        }
                    }
                    ?>
                </select>
                <input type="button" value="添加&gt;&gt;" onclick="moveLeft1()"/>
                <input type="button" value="&lt;&lt;撤销" onclick="moveRight1()"/>
                <select  name="rightBox[]" id="rightBox" multiple="multiple"></select>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>所属模块:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="submitTask" id="submitTask" value="发布" onclick="selectAll1()"/>
            </td>
        </tr>
    </table>
</form>
<?php
if(isset($_GET['submitTask']))
{
    $r="";
    $content=$_GET['content'];
    $project=$_COOKIE['project']."@".getCompany($_COOKIE['name'],$mysql);
    if(isset($_GET['rightBox'])){
        foreach($_GET['rightBox'] as $value)
        {
            $r.=$value;
            $sql="INSERT INTO `task` (`receive`, `content`, `time`, `project`,`complete`,`apply`,`recontent`) VALUES ('".$value."','".$content."',NOW(),'".$project."',0,0,'');";
            mysql_query($sql,$mysql);
        }
    }
    $content="向 ".$r." 发布了任务 ".$content;
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project']."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    header("Location:pnavigation.php");

}

?>

