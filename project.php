<?php
include("draw.php");
// 根据开始、结束时间和完成度判断项目状态，0未开始，1在进行中，2完成 3失败
function projectStatus($stime, $etime, $speed)
{
    if (strtotime(date("Y-m-d H:i:s")) - strtotime($stime) < 0) {
        return "未开始";
    } else if ($speed < 100 && strtotime(date("Y-m-d H:i:s")) - strtotime($etime) <= 0) {
        return "在进行中";
    } else if ($speed >= 100 && strtotime(date("Y-m-d H:i:s")) - strtotime($etime) <= 0) {
        return "项目完成";
    } else if ($speed < 100 && strtotime(date("Y-m-d H:i:s")) - strtotime($etime) > 0) {
        return "项目失败";
    }
}
function Progress($p){
    return -$p*$p+2*$p;//抛物线 y=-(x-1)^2+1
}
function SetTdTag($tlevel,$level){
    for($i=$level;$i<$tlevel;$i++){
        echo '</td><td>';
    }
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
    </style>

    <link href="css/css.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../js/xiangmu.js"></script>
</head>
<body>

<table width="100%" border="1">
    <tr colspan="2">
        <td><img src="images/tishi.jpg"></td>
    </tr>
    <?php
    include("conn.php");
    if (isset($_COOKIE['name'])) {
        $sql = "select * from `project`";
        $result = mysql_query($sql);
        //查找所属项目，并列出,判断是否为管理员等到进入项目之后在判断
        while ($arr = mysql_fetch_array($result)) {
            if (stristr($arr['pstaff'], $_COOKIE['name'])) {
                $threadSql="select * from `thread` where `tcnamepro`='".$arr['cname']."@".$arr['pname']."'";
                $threadResult=mysql_query($threadSql);
                ?>
                <tr>
                    <td width='75%'>
                        <table class="tab_data">
                            <tr>
                                <th>需求分析阶段</th>
                                <th>概要设计阶段</th>
                                <th>详细设计阶段</th>
                                <th>编码阶段</th>
                                <th>测试阶段</th>
                            </tr>
                            <tr>
                                <td>
                               <?php $level=1;
                               while($threadArr=mysql_fetch_array($threadResult)){
                                   if($threadArr['tlevel']!=$level){
                                       SetTdTag($threadArr['tlevel'],$level);
                                $level=$threadArr['tlevel']; }?>
                                <div><?php echo $threadArr['tname']?></div>
                                    <div style="background-color:<?php if( $threadArr['tflag']==1) echo 'blue';else echo 'red' ?> ;width:<?php echo  Progress($threadArr['tcontribution']/100)*100?>%;height:30px "></div>
                                <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div style="width: 50%;margin: auto">
                                        <div style="text-align: center;font-size: 17px">项目 <?php if($arr['pspeed']>100) $arr['pspeed']=100; echo $arr['pname'].' 完成度为 '.$arr['pspeed'].'%'?></div>
                                <div style="border: 1px solid #000000;height: 25px;padding: 2px;">
                                    <div  style="width: <?php echo $arr['pspeed'] ?>%;background-color: #808080;height: 18px"></div>
                                </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width='25%'><a style="font-size: 20px"
                            href="projectShow.php?pname=<?php echo $arr['pname']?>" target='_blank'>进入<?php echo $arr['pname'] . "项目(" . projectStatus($arr['pstarttime'], $arr['pendtime'], $arr['pspeed']) ?>
                        )</a></td>
                </tr>
            <?php
            }
        }
    }
    ?>
</table>
</body>
</html>