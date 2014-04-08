<?php
include("conn.php");
$userSql = "select * from `user`";
$userSqlResult = mysql_query($userSql);
$projectSql='select * from project';
$projectSqlResult = mysql_query($projectSql);
$projects=array();
while($rows=mysql_fetch_array($projectSqlResult)){
    $projects[]=$rows;
}
function findUser($username,$project){

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
    <title>项目管理系统</title>
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
        .user_list td div{
            font-size:20px ;
            text-align: center;
        }
        .user_head td{
            text-align: center;
            width: 200px;
            font-size: 22px;

        }
        .user_table{
            margin-left: 20px;
            border: 1px solid #000000;
            border-collapse: collapse;
        }
        .user_table tr td {
            border: 1px solid #888888;
        }
    </style>
    <link href="css/css.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../js/xiangmu.js"></script>
</head>
</html>
<body>
<table class="user_table">
    <tr class="user_head">
        <td>人员</td>
        <td>项目完成数</td>
        <td>进行中的项目</td>
    </tr>
    <?php
    while ($userRows = mysql_fetch_array($userSqlResult)){
        ?>
        <tr class="user_list">
          <td><div><?php echo explode('@', $userRows['username'])[0]; ?></div></td>
            <td><div>
                <?php
                $projectSql = "select * from project where pspeed=100";
                echo countProject($userRows['username'], $projectSql);
                ?></div>
            </td>
            <td><div>
                <?php
                $projectSql = "select * from project where pspeed!=100";
                echo countProject($userRows['username'], $projectSql);
                ?></div>
            </td>
        </tr>
    <?php } ?>
</table>
<table>
    <tr>
        <th>项目</th>
        <th>完成进度</th>
        <th>负责人</th>
        <th>参与人员</th>
        <th>日期</th>
    </tr>
    <?php  foreach($projects as $project){ ?>
        <tr>
            <td><?php echo $project['pname'] ?></td>
            <td>
                <?php echo $project['pspeed'] ?>%
            </td>
            <td>
                <?php $projectStaffs=explode(',',$project['pstaff']);
                echo $projectStaffs[0];
                ?>
            </td><td>
            <?php  foreach($projectStaffs as $projectStaff){
                if($projectStaff!=$projectStaffs[0]){
                    echo $projectStaff;
                }
            }?>
            </td>
            <td>
                <?php echo $project['pstarttime'] ?> 到 <?php echo $project['pendtime'] ?>
            </td>
        </tr>
    <?php } ?>
</table>
<?php  foreach($projects as $project){ ?>
<table>
    <tr>
        <th>参与人员</th>
        <th>任务分配</th>
        <th>完成状况</th>
    </tr>
 <?php  $projectStaffs=explode(',',$project['pstaff']);
    foreach($projectStaffs as $projectStaff){
        ?>
<tr>
        <td>
            <?php echo $projectStaff;?>
        </td>
        <td colspan="2">thread没有此字段，无法查询</td>

        </tr>
    <?php }?>
</table>
<?php } ?>
</body>
</html>