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
function judgeType($name)
{
    $arr=explode(".",$name);
    @$name=$arr[1];
    switch ($name)
    {
        case 'txt':
            return header('Content-type:text/plain');
            break;
        case 'gif':
            return header('Content-type:image/gif');
            break;
        case 'jpg':
            return header('Content-type:application/x-jpg');
            break;
        case 'jpeg':
            return header('Content-type:image/jpeg');
            break;
        case 'jpeg':
            return header('Content-type:application/msword');
            break;
        case 'pdf':
            return header('Content-type: application/pdf');
        case 'html':
            return header('Content-type: text/html');
            break;
        case 'htm':
            return header('Content-type: text/html');
            break;
    }
}
function downloadFile($file_dir,$file_name)
{
    $file = fopen($file_dir,"r"); // 打开文件

    echo judgeType($file_name);
    Header("Accept-Ranges: bytes");
    Header("Accept-Length: ".filesize($file_dir));
    Header("Content-Disposition: attachment; filename=" . $file_name);
// 输出文件内容
    echo fread($file,filesize($file_dir));
    fclose($file);
    exit();
}


$dir=$_SERVER['QUERY_STRING'];
$arr=explode("/",$dir);
$name=$arr[count($arr)-1];
$project=@$arr[3];
$arrd=explode("=.",$dir);
$dir=$arrd[1];
$dir="D:/PHP/wamp/www/bysj".$dir;
$content="下载了项目 ".$project." 内部的文件 ".$name;
$sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".getCompany($_COOKIE['name'],$mysql)."@".$project."','".$content."',NOW(),'".$_COOKIE['name']."');";
mysql_query($sql,$mysql);
downloadFile($dir,$name);

?>
