<?php
include("draw.php");
// 根据开始、结束时间和完成度判断项目状态，0未开始，1在进行中，2完成 3失败
function projectStatus($stime,$etime,$speed){
    if(strtotime(date("Y-m-d H:i:s"))-strtotime($stime)<0){
        return "未开始";
    }else if($speed<100&&strtotime(date("Y-m-d H:i:s"))-strtotime($etime)<=0)
    {
        return "在进行中";}else if($speed>=100&&strtotime(date("Y-m-d H:i:s"))-strtotime($etime)<=0)
    {
        return "项目完成";
    }else if($speed<100&&strtotime(date("Y-m-d H:i:s"))-strtotime($etime)>0)
    {
        return "项目失败";
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
        .font051 {font-family: "宋体";
            font-size: 12px;
            color: #333333;
            text-decoration: none;
            line-height: 20px;
        }
        .font201 {font-family: "宋体";
            font-size: 12px;
            color: #FF0000;
            text-decoration: none;
        }
        .button {
            font-family: "宋体";
            font-size: 14px;
            height: 37px;
        }
        html { overflow-x: auto; overflow-y: auto; border:0;}
        -->
    </style>

    <link href="css/css.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../js/xiangmu.js"></script>
</head>
<body>

<table width="900" border="1" >
    <tr colspan="2"><td><img src="images/tishi.jpg"></td></tr>
    <?php
    include("conn.php");
    if(isset($_COOKIE['name'])){
        $sql="select * from `project`";
        $result=mysql_query($sql,$mysql);
        //查找所属项目，并列出,判断是否为管理员等到进入项目之后在判断
        while($arr=mysql_fetch_array($result))
        {
            if(strstr($arr['pstaff'],$_COOKIE['name']))
            {
                echo " <tr>".
                    "<td width='44%'>". showSpeedImage($arr['pname'],$arr['cname'])."</td>".
                    "<td width='56%'><a href=projectShow.php?pname=".$arr['pname']." target='_blank'>进入".$arr['pname']."项目(".projectStatus($arr['pstarttime'],$arr['pendtime'],$arr['pspeed']).") </a></td>".
                    "</tr>";
            }
        }
    }
    ?>
</table>
</body>
</html>