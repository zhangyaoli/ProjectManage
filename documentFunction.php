<?php
function printTypePic($name)
{
    @$tmparr1=explode(".",$name);
    @$type=$tmparr1[1];
    switch($type){
        case 'jpg':
            return "<img src='.\images\ico\jpeg.ico' width='40' height='30' />";
            break;
        case 'jpeg':
            return "<img src='.\images\ico\jpeg.ico' width='40' height='30' />";
            break;
        case 'bmp':
            return "<img src='.\images\ico\bmp.ico' width='40' height='30' />";
            break;
        case 'png':
            return "<img src='.\images\ico\png.ico' width='40' height='30' />";
            break;
        case 'txt':
            return "<img src='.\images\ico\\txt.ico' width='40' height='30' />";
            break;
        case 'doc':
            return "<img src='.\images\ico\docx_win.ico' width='40' height='30' />";
            break;
        case 'htm':
            return "<img src='.\images\ico\html.ico' width='40' height='30' />";
            break;
        case 'php':
            return "<img src='.\images\ico\html.ico' width='40' height='30' />";
            break;
        case 'pdf':
            return "<img src='.\images\ico\pdf.ico' width='40' height='30' />";
            break;
        case 'ppt':
            return "<img src='.\images\ico\pptx_win.ico' width='40' height='30' />";
            break;
        case 'rar':
            return "<img src='.\images\ico\\rar.ico' width='40' height='30' />";
            break;
        case 'mp4':
            return "<img src='.\images\ico\mp3.ico' width='40' height='30' />";
            break;
        case 'mp3':
            return "<img src='.\images\ico\mp3.ico' width='40' height='30' />";
            break;
        case 'xls':
            return "<img src='.\images\ico\xlsx_win.ico' width='40' height='30' />";
            break;
        default:
            return "<img src='.\images\ico\url.ico' width='40' height='30' />";
            break;
    }
}
//将一个文件的信息转换为表格中的一行，flag用于判断是否为该项目的最后一个 若是则使用pic2
function printTr($filename,$flag)
{
    global $mysql;
    $sql="select * from `document` where `dname`='".$filename."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($flag==0)
    {
        echo "<tr id='tr2' style='display:none'>".
            "<th class='start'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>".$arr['dspace']."</td>".
            "<td>".$arr['dupdateuser']."</td>".
            "<td>".$arr['dtime']."</td>".
            "<td>".$arr['ddiscribe']."</td>".
            "<td><a href='download.php?fileDir=".$arr['daddress']."'>下载</a>"."<br></td>".
            "</tr>";
    }else if($flag==1)
    {
        echo "<tr id='tr2' style='display:none'>".
            "<th class='end'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>".$arr['dspace']."</td>".
            "<td>".$arr['dupdateuser']."</td>".
            "<td>".$arr['dtime']."</td>".
            "<td>".$arr['ddiscribe']."</td>".
            "<td><a href='download.php?fileDir=".$arr['daddress']."'>下载</a>"."<br></td>".
            "</tr>";
    }
}
function printTr2($filename,$flag)
{
    global $mysql;
    $sql="select * from `document` where `dname`='".$filename."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($flag==0)
    {
        echo "<tr>".
            "<th class='start'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>".$arr['dspace']."</td>".
            "<td>".$arr['dupdateuser']."</td>".
            "<td>".$arr['dtime']."</td>".
            "<td>".$arr['ddiscribe']."</td>".
            "<td><a href='download.php?fileDir=".$arr['daddress']."'>下载</a>";
        if(isset($_COOKIE['projectManager']))
        {
            if($_COOKIE['projectManager']==1)
            {
                echo " |  <a href='documentDelete.php?fileDir=".$arr['daddress']."'>删除</a>";
            }else if(isset($_COOKIE['name'])){
                if($_COOKIE['name']==$arr['dupdateuser'])
                {
                    echo " |  <a href='documentDelete.php?fileDir=".$arr['daddress']."'>删除</a>";
                }
            }
        }
        echo "</td>";
        echo "</tr>";
    }else if($flag==1)
    {
        echo "<tr>".
            "<th class='end'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>".$arr['dspace']."</td>".
            "<td>".$arr['dupdateuser']."</td>".
            "<td>".$arr['dtime']."</td>".
            "<td>".$arr['ddiscribe']."</td>".
            "<td><a href='download.php?fileDir=".$arr['daddress']."'>下载</a>";
        if(isset($_COOKIE['projectManager']))
        {
            if($_COOKIE['projectManager']==1)
            {
                echo " |  <a href='documentDelete.php?fileDir=".$arr['daddress']."'>删除</a>";
            }else if(isset($_COOKIE['name'])){
                if($_COOKIE['name']==$arr['dupdateuser'])
                {
                    echo " |  <a href='documentDelete.php?fileDir=".$arr['daddress']."'>删除</a>";
                }
            }
        }
        echo "</td>";
        echo "</tr>";
    }
}
function printTr3($filename,$flag)
{
    global $mysql;
    $sql="select * from `document` where `dname`='".$filename."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    if($flag==0)
    {
        $name=$arr['cnamepro'];
        $name=explode("@",$name);
        $name=@$name[1];
        echo "项目".$name."中的文件：";
        echo "<tr>".
            "<th class='start'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>| ".$arr['dspace']."</td>".
            "<td>| ".$arr['dupdateuser']."</td>".
            "<td>| ".$arr['dtime']."</td>".
            "<td>| ".$arr['ddiscribe']."</td>".
            "<td>| <a href='download.php?fileDir=".$arr['daddress']."'>下载</a>";

        echo "</td>";
        echo "</tr>";
        echo "<br>";
    }else if($flag==1)
    {
        echo "<tr>".
            "<th class='end'>".printTypePic($arr['dname'])."</th>".
            "<td>".$arr['dname']."</td>".
            "<td>".$arr['dspace']."</td>".
            "<td>".$arr['dupdateuser']."</td>".
            "<td>".$arr['dtime']."</td>".
            "<td>".$arr['ddiscribe']."</td>".
            "<td><a href='download.php?fileDir=".$arr['daddress']."'>下载</a>";
        echo "</td>";
        echo "</tr>";
    }
}
//用于需要获取权限的文件夹显示powerarr是该用户有权访问的文件夹集合数组,$modify=0表示不是文件夹的最后一个文件，1表示是最后一个，用于控制css样式中的图片选取
function showFile($filename,$powerarr,$modify)
{
    global $mysql;
    if(strstr($filename,".")){//该文件名不是文件夹
        if($filename!="."||$filename!=".."){
            printTr($filename,$modify);
        }
    }
    else//该文件名是文件夹
    {
        $sql2= "select * from `folder` where `fname` = '".$filename."';";
        $result2=mysql_query($sql2,$mysql);
        $arr2=mysql_fetch_array($result2);
        $address = $arr2['faddress'];
        echo "<tr id='tr2' style='display:none'>".
            "<th class='start'><img src='.\images\ico\\folder.png' width='40' height='40' /></th>".
            "<td>".$filename."</td>".
            "<td colspan='5'><a href='showdir.php?path=".$address."'target='_blank'>进入文件夹</a><br>".
            "</tr>";
    }
}
function showFileNoPower($filename,$flag)
{
    global $mysql;
    if(strstr($filename,".")){//该文件名不是文件夹,文件夹没后缀名，所以名字中不存在 '.'
        if($filename!="."||$filename!=".."){
            printTr2($filename,$flag);
        }
    }
    else//该文件名是文件夹
    {
        $sql2= "select * from `folder` where `fname` = '".$filename."';";
        $result2=mysql_query($sql2,$mysql);
        $arr2=mysql_fetch_array($result2);
        $address = $arr2['faddress'];
        echo "<tr>".
            "<th class='start'><img src='.\images\ico\\folder.png' width='40' height='40' /></th>".
            "<td>".$filename."</td>".
            "<td colspan='5'><a href='showdir.php?path=".$address."'target='_blank'>进入文件夹</a>";
        if(isset($_COOKIE['projectManager']))
        {
            if($_COOKIE['projectManager']==1)
            {
                echo "|<a href='deletedir.php?path=".$address."'>删除文件夹</a></td>";
            }
        }
        echo "</tr>";
    }
}
function showFileNoPower1($filename,$flag)
{
    global $mysql;
    if(strstr($filename,".")){//该文件名不是文件夹,文件夹没后缀名，所以名字中不存在 '.'
        if($filename!="."||$filename!=".."){
            printTr3($filename,$flag);
        }
    }
    else//该文件名是文件夹
    {
        $sql2= "select * from `folder` where `fname` = '".$filename."';";
        $result2=mysql_query($sql2,$mysql);
        $arr2=mysql_fetch_array($result2);
        $address = $arr2['faddress'];
        echo "<tr>".
            "<th class='start'><img src='.\images\ico\\folder.png' width='40' height='40' /></th>".
            "<td>".$filename."</td>".
            "<td colspan='5'><a href='showdir.php?path=".$address."'target='_blank'>进入文件夹</a><br>".
            "</tr>";
    }
}

//通过scandir获取文件夹中的文件,并通过showfile将数据库中对此文件的信息显示出来。folder是文件路径，后面2个为了给showfile传参数用的
function showFolder($folder,$powerarr,$modify=0)
{
    $arr=scandir($folder);
    foreach($arr as$key=>$value)
    {
        if($key>1&&$key<count($arr)-1){
            showFile($value,$powerarr,$modify);
        }else if($key==count($arr)-1&&$key>1)
        {
            showFile($value,$powerarr,1);
        }
    }
    if(count($arr)<3)
    {
        //echo "<tr><td>当前没有文件!</td></re>";
    }
}
function showFolderNoPower($folder)
{
    @$arr=scandir($folder);
    if(count($arr)!=1)
    {
        foreach($arr as$key=>$value)
        {
            if($key>1&&$key<count($arr)-1){
                showFileNoPower($value,0);
            }else if($key==count($arr)-1&&$key>1)
            {
                showFileNoPower($value,1);
            }
        }
    }
    if(count($arr)<3)
    {
        //echo "<tr><td>当前没有文件!</td></re>";
    }
}
//fold是上传的文件夹路径,$arrfile是$_FILES[]那个接收表单之后的数组
function updateFile($folder,$arrFile,$username,$discribe,$cnamepro)
{
    global $mysql;
    $path=$folder."/".$arrFile['name'];
    if($arrFile['error']==0)
    {
        move_uploaded_file($arrFile['tmp_name'],$path);
        $sql="insert into `document`(`dname`,`daddress`,`dspace`,`dupdateuser`,`dtime`,`ddiscribe`,`dtype`,`cnamepro`)values('".$arrFile['name'].
            "','".$path."','".$arrFile['size']."','".$username."',NOW(),'".$discribe."','".$arrFile['type']."','".$cnamepro."');";
        $result=mysql_query($sql,$mysql);
    }
}
function createFolder($path,$name,$pow,$cnamepro,$visitPeople)
{
    global $mysql;
    $path1=$path."/".$name;
    //mkdir($path1);
    $sql="insert into `folder`(`fname`,`faddress`,`fpow`,`fvp`,`fcnamepro`) values('".$name."','".$path1."','".$pow."','".$visitPeople.
        "','".$cnamepro."');";
    mysql_query($sql,$mysql);
}
//搜索功能，前4个为搜索条件 文件名，类型，上传时间，上传人,fileArray是搜索文件范围
function searchFile($name,$type,$uptime,$upuser,$discrible,$fileArray)
{
    global $mysql;
    $flag=0;
    $sql="select * from `document` where";
    if($name)
    {
        $sql.="`dname` like '%".$name."%'";
        $flag=1;
    }
    if($type&&$flag==1)
    {
        $sql.=" and `dtype`like '%".$type."%'";
    }
    else if($type&&$flag==0)
    {
        $sql.=" `dtype`like '%".$type."%'";
        $flag=1;
    }
    if($uptime)
    {
        $sql.=" and `dtime`>'".$uptime."'";
    }
    else if($uptime&&$flag==0)
    {
        $sql.=" `dtime`>'".$uptime."'";
        $flag=1;
    }
    if($upuser)
    {
        $sql.=" and `dupdateuser`='".$upuser."'";
    }
    else if($upuser&&$flag==0)
    {
        $sql.=" `dupdateuser`='".$upuser."'";
        $flag=1;
    }
    if($discrible)
    {
        $sql.=" and `ddiscribe` like '%".$discrible."%'";
    }
    else if($discrible&&$flag==0)
    {
        $sql.=" `ddiscribe` like '%".$discrible."%'";
        $flag=1;
    }
    echo $sql;
    $result=mysql_query($sql,$mysql);
    if(!$result){echo "没有找到符合要求的文件....";}
    else{
        while($arr=mysql_fetch_array($result))
        {
            $flag=0;
            if(in_array($arr['dname'],$fileArray))
            {
                showFileNoPower1($arr['dname'],0);
                $flag++;

            }

        }
    }
}
?>

