<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>无标题文档</title>
    <link href="./css/documentTable1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table align="left" id="show">
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
    include("conn.php");
    include("documentFunction.php");
    $tmparr1=explode("=",urldecode($_SERVER['QUERY_STRING']));
    if(@$path=$tmparr1[1]){//文件夹路径
        showFolderNoPower(iconv('utf-8','gb2312',$path));
        $sql1="select * from `folder` where `faddress`='".$path."';";
        $result1=mysql_query($sql1,$mysql);
        $arr=mysql_fetch_array($result1);
        $cnamepro=$arr['fcnamepro'];
        $username=$_COOKIE['name'];
    }
    echo "<hr>";
    if(isset($_POST['mySubmit']))
    {
        $tmparr2=$_FILES['update'];
        $discrible=$_POST['myText'];
        updateFile(iconv('utf-8','gb2312',urldecode($path)),$tmparr2,$username,$discrible,$cnamepro);
        echo '<script>location.reload()</script>';
    }
    ?>
    <tbody>
</table>

文件上传
<form name='myForm'method='POST' enctype='multipart/form-data'>
    <input type='file' name='update'><br>
    <input type='text' name='myText'>对该文件的描述<br>
    <input type='submit' name='mySubmit' value='上传'>
</form>
</html>

