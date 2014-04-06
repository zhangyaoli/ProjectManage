<title>新建模块</title>
<?php
include("conn.php");
?>
<html>
<body>

<form name="myForm" method="get">
    模块名: <input type="text" name="textName"><br>
    模块描述:
    <textarea name="area" rows="5" cols="40" wrap="on"></textarea><br>
    模块所属阶段:
    <select name="select" size="1">
        <option value="1">需求分析</option>
        <option value="2">概要设计</option>
        <option value="3">详细设计</option>
        <option value="4">编码</option>
        <option value="5">测试</option>
    </select><br>
    项目贡献度：<input type="text" name="textCon" size="3"> 其余项目(贡献度总和请设置成100,小于100项目总不能完成，大于100当做100)<?php
    //获取该项目的所有模块贡献度,并单击可修改,确保贡献度之和为100
    $sql="select * from `project` where `pname`='".$_COOKIE['project']."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    $cnamepro=$arr['cname']."@".$_COOKIE['project'];//取到thread表中属于公司项目的标记
    $sql2="select * from `thread` where `tcnamepro`='".$cnamepro."';";
    $result2=mysql_query($sql2,$mysql);
    $ss=0;
    while($arr2=mysql_fetch_array($result2))
    {
        $ss=$ss+$arr2['tcontribution'];
        echo $arr2['tname'].": <input type='text' name='".$arr2['tname']."' value='".$arr2['tcontribution']."'size='3'>";
    }
    echo "<br>";
    echo "目前总贡献度为".$ss;
    ?>
    <input type="submit" name="mySubmit" value="提交">
</form>
</body>
</html>
<?php
if(isset($_GET['mySubmit']))
{
    $sql3="insert into `thread`(`tname`,`tdis`,`tflag`,`tcontribution`,`tlevel`,`tcnamepro`) values('".$_GET['textName']."','".$_GET['area']."',0,'".
        $_GET['textCon']."','".$_GET['select']."','".$cnamepro."');";
    $result3=mysql_query($sql3,$mysql);
//修改其他模块的贡献度，保持100
    $result2=mysql_query($sql2,$mysql);
    $content="创建了模块".$_GET['textName'].",优先度为".$_GET['select'].",贡献度为".$_GET['textCon'].",";
    while($arr2=mysql_fetch_array($result2))
    {
        if(isset($_GET[$arr2['tname']])){
            $sql4="update `thread` set `tcontribution`='".$_GET[$arr2['tname']]."' where `tname`='".$arr2['tname']."' and `tcnamepro`='".$cnamepro."';";
            mysql_query($sql4,$mysql);
            $content.="模块".$arr2['tname']."的贡献度更改为".$_GET[$arr2['tname']].",";
        }
    }

    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    if($result3){echo "<script> alert('创建成功!');window.location.href='pnavigation.php';</script>";}
}
?>