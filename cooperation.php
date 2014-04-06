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
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <style>
    </style>
</head>
<body>
<table>
    <tr>
        <td>人员</td>
        <td>项目完成数</td>
        <td>进行中的项目</td>
    </tr>
    <?php

    while ($userRows = mysql_fetch_array($userSqlResult)){
        ?>
        <tr>
          <td><?php echo explode('@', $userRows['username'])[0]; ?></td>
            <td>
                <?php
                $projectSql = "select * from project where pspeed=100";
                echo countProject($userRows['username'], $projectSql);
                ?>
            </td>
            <td>
                <?php
                $projectSql = "select * from project where pspeed!=100";
                echo countProject($userRows['username'], $projectSql);
                ?>
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