
<?php
include("conn.php");
include("documentFunction.php");
//可访问的文件夹路径 集合
$OUTPUT_ARRAY=array();
if(isset($_COOKIE['name'])){
$sql="select * from `user` where `username`='".$_COOKIE['name']."';";
$result=mysql_query($sql,$mysql);
$arrUser=mysql_fetch_array($result);
$username=$_COOKIE['name'];//获取用户名
$usercompany=$arrUser['cname'];
$userPow=$arrUser['power'];//获取用户权限
//$sql2="select * from `folder`;";
//$resultFolder=mysql_query($sql2,$mysql);
$sql2="select * from `project`;";
$result=mysql_query($sql2,$mysql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>项目文档</title>
    <link href="./css/documentTable1.css" rel="stylesheet" type="text/css" />
    <script language="javascript">
        function expand(obj) {
            var tbl = document.getElementById("table0");
            var len = tbl.rows.length;
            var tr1 = obj.parentNode.parentNode;
            var beginRow = tr1.rowIndex + 1;
            var img0 = obj;
            if (img0.alt == "点击展开") {
                img0.src = "./css/pic/tabletree-arrow2.gif";
                img0.alt = "点击收缩";
                for (index = beginRow; index < len && tbl.rows[index].id != "tr1"; index++) {
                    tbl.rows[index].style.display = 'block';
                }
            } else {
                img0.src = "./css/pic/tabletree-arrow.gif";
                img0.alt = "点击展开";
                for (index = beginRow; index < len && tbl.rows[index].id != "tr1"; index++) {
                    tbl.rows[index].style.display = 'none';
                }
            }
        }
    </script>
</head>
<body>
<table align="left" id="table0">
    <thead>
    <tr>
        <th class="name">文件类型</th>
        <th class="name">文件名</th>
        <th class="name">文件大小</th>
        <th class="name">上传者</th>
        <th class="name">上传日期</th>
        <th class="location">文件备注</th>
        <th class="name">下载</th>
    </tr>
    </thead>
    <tbody>

    <?php
    /*
    while($arrFolder=mysql_fetch_array($result))//获取该用户可查看的文件夹(只包括公司、项目文件夹),以下的文件夹能进具体文件夹就说明有权限了
    {  	  //   小于4指有进入项目文件夹的权限,指有权查看所有项目的管理人员 strstr cname那个条件指属于本公司的文件夹,fvp!=''表示这是一个项目文件夹
       if(strstr($arrFolder['fvp'],$username)!=false&&$arrFolder['fvp']!=''&&(strstr($arrFolder['fcnamepro'],$arrUser['cname'])!=""))
        {

                echo "<tr>".
                "<th colspan='7'>项目".$arrFolder['fname']."</th>".
            "</tr>";
            showFolder($arrFolder['faddress'],$arrFolder['faddress']);
            //array_push($OUTPUT_ARRAY,$arrFolder['faddress']);
            //如果没有进入文件夹的权限，查看是否是指定可以访问的人
        }
        else if(strstr($arrFolder['fvp'],$username)!=false&&(strstr($arrFolder['fcnamepro'],$arrUser['cname'])!=false))
        {
            showFolder("./document/".$usercompany,$arrFolder['faddress']);
            //array_push($OUTPUT_ARRAY,$arrFolder['faddress']);
        }
    //输出查看文件夹目录html页面
    }
    */
    ?>
    <?php
    while($arrFolder=mysql_fetch_array($result))//获取该用户可查看的文件夹(只包括公司、项目文件夹),以下的文件夹能进具体文件夹就说明有权限了
    {  	  //   小于4指有进入项目文件夹的权限,指有权查看所有项目的管理人员 strstr cname那个条件指属于本公司的文件夹,fvp!=''表示这是一个项目文件夹
        if(strstr($arrFolder['pstaff'],$username)!=false&&(strstr($arrFolder['cname'],$usercompany)!=""))
        {
            $address=dirname(__FILE__).DIRECTORY_SEPARATOR.'document'.DIRECTORY_SEPARATOR.iconv('utf-8','gb2312',$usercompany).DIRECTORY_SEPARATOR.iconv('utf-8','gb2312',$arrFolder['pname']);
            echo "<tr id='tr1'>".
                //"<th colspan='7'>项目".$arrFolder['pname']."</th>".
                "<td><img src='css/pic/tabletree-arrow.gif' id=img onClick=expand(this) align='left' alt='点击展开'/></td>".
                "<td>项目".$arrFolder['pname'].

                "</tr>";
            showFolder($address,$address);
            //array_push($OUTPUT_ARRAY,$arrFolder['faddress']);
            //如果没有进入文件夹的权限，查看是否是指定可以访问的人
        }

    }
    //输出查看文件夹目录html页面
    }
    ?>
    <tbody>
</table>
</html>

