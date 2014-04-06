<html><head><title>日志</title></head>
<?php
include("navigation.php");
?>
<table >
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
        while($arrFolder=mysql_fetch_array($result))//获取该用户可查看的文件夹(只包括公司、项目文件夹),以下的文件夹能进具体文件夹就说明有权限了
        {  	  //   小于4指有进入项目文件夹的权限,指有权查看所有项目的管理人员 strstr cname那个条件指属于本公司的文件夹,fvp!=''表示这是一个项目文件夹
            if(strstr($arrFolder['pstaff'],$username)!=false&&(strstr($arrFolder['cname'],$usercompany)!=""))
            {
                $peoject=$arrFolder['cname']."@".$arrFolder['pname'];
                echo "<tr >".
                    "<th </th>".
                    "<td ><a href='showlog.php?path=".$peoject."'target='_blank'>查看项目".$arrFolder['pname']."日志</a><br>".
                    "</tr>";
            }

        }
    }
    ?>
</table>
</html>