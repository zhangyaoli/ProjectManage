<?php
$daysOfMonth=array(31,28,31,30,31,30,31,31,30,31,30,31);
$daysOfMonthLY=array(31,29,31,30,31,30,31,31,30,31,30,31);
$DofW=array('日','一','二','三','四','五','六');
$Year=(int)isset($_GET['year'])?$_GET['year']:date('Y');
$Month=(int)isset($_GET['month'])?$_GET['month']:date('m');
$Day=(int)isset($_GET['myHidden'])?$_GET['myHidden']:date('d');
$cYear=$Year;
//在Windows系统中函数string date(string format[,int timestamp])范围限制为从1970年1月1日到2038年1月19日。
//日历循环周期为28年，以下两个循环进行范围调整
while($cYear<1971) $cYear+=28;
while($cYear>2037) $cYear-=28;
$Week=(int)date('w',strtotime($cYear*100+$Month.'01'));//月初是星期几
if ((($Year%4==0)&&($Year%100!=0))||($Year%400==0))
    $DayOfMonth=$daysOfMonthLY[$Month-1];
else
    $DayOfMonth=$daysOfMonth[$Month-1];
?>
<html>
<head>
    <title>日历</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Author" content="HuangJian">
    <style type="text/css"><!--
        BODY,TH,TD,Select {
            font-family: 宋体;
            font-size: 9pt;
            color:#003399;
        }
        A:link {
            color:#003399;
            text-decoration:none;
        }
        A:visited {
            color:#003399;
            text-decoration:none;
        }
        A:hover {
            color:#FFA500;
            text-decoration:none;
        }
        --></style>
</head>
<body>
<form name="form_cal" action="#" method="get">
    <input type="hidden" name="myHidden" id="myHidden">
    <table border="1" cellpadding="2" cellspacing="0" width="200" align="center">
        <tr bgcolor="#CCEEFF">
            <td colspan="7" align="right">
                <a href="cal.php" title="转到今天">日历</a>       <select name="year" onChange="javascript:form_cal.submit()">
                    <?php
                    for($i=1901;$i<=2100;$i++)
                        printf("<option value=\"%d\" %s >%d</option>\n",$i,$i==$Year?'selected':'',$i);
                    echo '</select>年 <select name="month" onChange="javascript:form_cal.submit()">';
                    for($i=1;$i<=12;$i++)
                        printf("<option value=\"%02d\"%s>%02d</option>\n",$i,$i==$Month?' selected ':'',$i);
                    echo '</select>月</td></tr><tr align="center">';
                    for($i=0;$i<7;$i++)
                        echo '<th>'.$DofW[$i].'</th>';
                    echo '</tr><tr align="center">';
                    for($i=0;$i<$Week;$i++)
                        echo '<td>&nbsp </td>';
                    for($day=1;$day<=$DayOfMonth;$day++)
                    {
                        echo '<td';
                        if($day==$Day) echo ' bgcolor="#CCEEFF"';
                        printf("><a href=\"#)\"onClick=\"javascript: var hidden=getElementById('myHidden');hidden.value=%d;form_cal.submit()\">%d</a></td>\n",$day,$day);
                        if(($day+$Week)%7==0&&$day!=$DayOfMonth) echo '</tr><tr align="center">';
                    }
                    for($day--;($day+$Week)%7!=0;$day++)
                        echo '<td>&nbsp </td>';
                    ?>
        </tr></table></form></body></html>