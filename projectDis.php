<?php
include("conn.php");
$tmparr=explode("&",$_SERVER['QUERY_STRING']);
$username='';
$pname='';
$userarr=explode("=",$tmparr[0]);
$username=$userarr[1];
if(isset($tmparr[1])){
    $projectarr=explode("=",urldecode($tmparr[1]));
    $pname=$projectarr[1];
}
$userSql = "select * from `user`";
$userSqlResult = mysql_query($userSql);
if(!isset($tmparr[1])){
$projectSql="select * from project where pstaff like '%".$username."%' and pspeed!=100";
}else {
    $projectSql="select * from project where pname='".$pname."' ";
}
$projectSqlResult = mysql_query($projectSql);
$projects=array();
while($rows=mysql_fetch_array($projectSqlResult)){
    $projects[]=$rows;
}
function countProject($username, $sql)
{
    $count = 0;
    $projectSqlResult = mysql_query($sql);
    while ($projectRows = mysql_fetch_array($projectSqlResult)) {
        $projectStaffs = explode(',', $projectRows['pstaff']);
        foreach ($projectStaffs as $projectStaff) {
            if ($username == $projectStaff) {
                $count++;
            }
        }
    }
    return $count;
}
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>项目列表</title>
    <?php
    include("navigation.php");
    ?>
    <style type="text/css">
        <!--
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }

        .tabfont01 {
            font-family: "宋体";
            font-size: 9px;
            color: #555555;
            text-decoration: none;
            text-align: center;
        }

        .font051 {
            font-family: "宋体";
            font-size: 12px;
            color: #333333;
            text-decoration: none;
            line-height: 20px;
        }

        .font201 {
            font-family: "宋体";
            font-size: 12px;
            color: #FF0000;
            text-decoration: none;
        }

        .button {
            font-family: "宋体";
            font-size: 14px;
            height: 37px;
        }

        html {
            overflow-x: auto;
            overflow-y: auto;
            border: 0;
        }
        table.tab_data {
            width: 100%;
            border-collapse: collapse;
        }

        .tab_data th {
            background: skyblue;
            font-size: 12px;
            font-weight: 100;
            height: 28px;
            text-align: left;
            width:20%;
        }

        .tab_data tr td {
            padding: 7px;
            background: #fff;
            color: #333;
            text-align: left;
        }
        .tab_data tr td div{
            padding: 3px;
        }
        -->
        .user_list td{
            border-spacing: 0px 0px;
            color: #333;
            font-family: "ff-tisa-web-pro-1","ff-tisa-web-pro-2","Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","WenQuanYi Micro Hei",sans-serif;
            font-size: 14px;
            line-height: 20px;
            -moz-box-sizing: border-box;

            text-align: center;
        }
        .user_list:nth-child(odd)>td{
            background-color:#dff0d8;
        }
        .user_head td{
            background-color: #FFCC00;
            text-align: center;
            font-size: 22px;

        }
        .user_table{
            text-align: center;
            margin: 20px;
            /*margin-left: 20px;*/
            border: 1px solid #000000;
            border-collapse: collapse;
        }
        .user_table tr td {
            border: 1px solid #888888;
        }
        .active-user{
            background-color: #32C1EC;
        }
    </style>
    <link href="css/css.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../js/xiangmu.js"></script>
</head>
</html>

<?php
    foreach($projects as $project){ ?>
    <div style="margin-top: 10px;font-size: 15px"><a href="projectShow.php?pname=<?php echo $project['pname'] ?>"target="_blank"><?php echo $project['pname'] ?></a></div>
    <table class="user_table">
        <tr class="user_head">
            <td style="width: 25%">任务分配</td>
            <td style="width: 10%">所属模块</td>
            <td  style="width:20%">参与人员</td>
            <td  style="width: 5%">完成状况</td>
        </tr>
        <?php
        $project_name=$project['pname'].'@'.$project['cname'];
        $taskSql="select * from `task` where project='".$project_name."'";
        $taskResult= mysql_query($taskSql);
        $flag=0;
        while($taskRow=mysql_fetch_array($taskResult)){?>
        <tr class="<?php if($taskRow['receive']==$username) {$flag=1;echo 'active-user';}?>">
            <td><?php echo $taskRow['content']?></td>
            <td><?php
            $threadSql="select * from thread where id='".$taskRow['thread_id']."'";
                $threadResult =mysql_query($threadSql);
                $threadRow=mysql_fetch_array($threadResult);
                echo $threadRow['tname'];
?></td>
            <td><?php  echo $taskRow['receive']?></td>
            <td><?php if($taskRow['complete']==0)echo "未完成";else echo "完成"; ?></td>
        </tr><?php }
        if($flag==0){
            echo '<tr class="active-user"style="height:40px"><td colspan="4">'.$username."尚未得到任务</td></tr>";
        }?>
    </table>
    <td></td>
<?php }
?>