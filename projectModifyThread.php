<head><title>模块修改</title></head>
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
if(isset($_SERVER['QUERY_STRING']))
{

    $tname=$_SERVER['QUERY_STRING'];
    $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
    $sql="select * from `thread` where `tcnamepro`='".$cnamepro."'order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        if($arr['tflag']==0)
        {
            $lastLevel=$arr['tlevel'];
            break;
        }
    }
    $sql="select * from `thread` where `tname`='".$tname."' and `tcnamepro`='".$cnamepro."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    echo "<form name='myForm' method='post'>".
        "模块名:<input type='text' name='textName' value='".$arr['tname']."'><br>".
        "模块描述:<textarea name='area' rows='5' cols='30' wrap='off'>".$arr['tdis']."</textarea><br>";
    echo "模块是否完成:";
    if(($arr['tlevel']==$lastLevel)||($arr['tlevel']==$lastLevel-1)){
        if($arr['tflag']){echo "<input type='radio' name='radio'value='1' checked>完成<input type='radio' name='radio'value='0' >未完成";
        }else{echo "<input type='radio' name='radio'value='1' >完成<input type='radio' name='radio'value='0'checked >未完成";
        }
    }
    else
    {
        if($arr['tflag']){echo "<input type='radio' name='radio'value='1' checked  disabled='true'>完成<input type='radio' name='radio'value='0'disabled='true' >未完成";
        }else{echo "<input type='radio' name='radio'value='1' disabled='true'>完成<input type='radio' name='radio'value='0'checked disabled='true'>未完成";
        }
    }
    echo "<br>";
    echo "<input type='submit' name='mySubmit' value='修改'>";
}
?>
<?php
if(isset($_POST['mySubmit']))
{
    $tmpsql="select * from `thread` where `tname`='".$tname."' and `tcnamepro`='".$cnamepro."';";
    $tmpr=mysql_query($tmpsql,$mysql);
    $arrr=mysql_fetch_array($tmpr);
    $content=" 修改了模块 ".$_POST['textName'];
    if($_POST['textName']!=$arrr['tname'])
    {
        $content.=" 项目名改为 ".$_POST['textName'].",";
    }
    if($_POST['area']!=$arrr['tdis'])
    {
        $content.=" 项目介绍改为 ".$_POST['area'].",";
    }
    if($_POST['radio']!=$arrr['tflag'])
    {
        $content.=" 项目完成度改为 ".$_POST['radio'].",";
    }
    $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
    mysql_query($sql,$mysql);
    $sql2="update `thread` set `tname`='".$_POST['textName']."',`tdis`='".$_POST['area']."',`tflag`='".$_POST['radio']."'
 where `tname`='".$tname."' and `tcnamepro`='".$cnamepro."';";
    $result2=mysql_query($sql2,$mysql);
    $sqlT="select * from `thread` where `tname`='".$tname."' and `tcnamepro`='".$cnamepro."';";
    $resultT=mysql_query($sqlT,$mysql);
    $arrT=mysql_fetch_array($resultT);
//修改项目完成度,speed为完成度参数
    if($_POST['radio']!=$arrr['tflag'])
    {
        if($arrT['tflag']==1){
            $sql3="select * from `project` where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
            $result3=mysql_query($sql3,$mysql);
            $arr3=mysql_fetch_array($result3);
            $speed=$arr3['pspeed'];
            $speed+=$arrT['tcontribution'];
            $sql4="update `project` set `pspeed`='".$speed."'where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
            mysql_query($sql4,$mysql);
        }else
        {
            $sql3="select * from `project` where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
            $result3=mysql_query($sql3,$mysql);
            $arr3=mysql_fetch_array($result3);
            $speed=$arr3['pspeed'];
            $speed-=$arrT['tcontribution'];
            $sql4="update `project` set `pspeed`='".$speed."'where `pname`='".$_COOKIE['project']."'and `cname`='".getCompany($_COOKIE['name'],$mysql)."';";
            mysql_query($sql4,$mysql);
        }
    }
    if($result2){

        echo "<script> alert('修改成功!');window.location.href='pnavigation.php';</script>";
    }
}
?>
