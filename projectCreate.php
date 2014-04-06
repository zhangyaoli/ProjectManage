<title>新建项目</title>
<script language="javascript" type="text/javascript" src="js/Calendar1.js"></script>
<script language="javascript" type="text/javascript">
    function moveLeft() {
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
    function moveRight() {
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
    function selectAll(){
        var rBox = document.getElementById("rightBox");
        for (var i = 0, len = rBox.length; i < len; i++) {//>
            rBox.options[i].selected=true;
        }
    }
</script>
<?php
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
function createFolder($path,$name,$pow,$cnamepro,$visitPeople)
{
    global $mysql;
    $path1=$path."/".$name;
    mkdir($path1);
    $sql="insert into `folder`(`fname`,`faddress`,`fpow`,`fvp`,`fcnamepro`) values('".$name."','".$path1."','".$pow."','".$visitPeople.
        "','".$cnamepro."');";
    mysql_query($sql,$mysql);
}
?>
<?php
include("conn.php");
include("navigation.php");
if(isset($_GET['mySubmit']))
{
    $pstaff=$_GET['PM'];
    foreach(@$_GET['rightBox'] as $value)
    {
        $pstaff.=",".$value;
    }
    //将上传的时间转化为可存入mysql的格式
    $stime=strtotime($_GET['textST']);
    $stime=date("Y-m-d H:i:s",$stime);
    $etime=strtotime($_GET['textET']);
    $etime=date("Y-m-d H:i:s",$etime);
    $sql="insert into `project`(`pname`,`pdiscrible`,`pstarttime`,`pendtime`,`pstaff`,`pspeed`,`cname`) values('".$_GET['textName']."','"
        .$_GET['area']."','".$stime."','".$etime."','".$pstaff."','0','".getCompany($_COOKIE['name'],$mysql)."');";
    $result=mysql_query($sql,$mysql);
    createFolder("./document/".getCompany($_COOKIE['name'],$mysql),$_GET['textName'],3,getCompany($_COOKIE['name'],$mysql)."@".$_GET['textName'],$pstaff);
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$_GET['textName']."','创建了项目',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    if($result)
    {
        echo "<script> alert('创建项目成功!');";
        header("Location:project.php");
    }
}
?>
<html>
<body>
<form name="myForm"method="get">

    项目名称:<input type="text" name="textName"><br>
    项目描述:
    <textarea name="area" rows="10" cols="40" wrap="on">
    </textarea><br>
    开始时间:<input  name="textST" type="text" onfocus="calendar()" ><br>
    结束时间:<input  name="textET" type="text" onfocus="calendar()" ><br>
    项目经理:<select name="PM" size="1">
        <?php
        $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";

        $result3=mysql_query($sql3,$mysql);
        while($tmparr3=mysql_fetch_array($result3))
        {
            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option>";
        }
        ?>
    </select><br>
    参与人员:
    <select  name="leftBox" id="leftBox" multiple="multiple">
        <?php
        $sql3="select * from `user` where `cname`='".getCompany($_COOKIE['name'],$mysql)."';";

        $result3=mysql_query($sql3,$mysql);
        while($tmparr3=mysql_fetch_array($result3))
        {
            echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."(".$tmparr3['post'].")</option>";
        }
        ?>
    </select>
    <input type="button" value="添加&gt;&gt;" onclick="moveLeft()"/>
    <input type="button" value="&lt;&lt;撤销" onclick="moveRight()"/>
    <select  name="rightBox[]" id="rightBox" multiple="multiple">
    </select><br>
    <input type="submit" name="mySubmit" value="提交"onclick="selectAll()">
</form>
</body>
</html>
