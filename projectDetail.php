<style type="text/css">
    table{border-left: 1px solid #666; border-bottom: 1px solid #666;}
    td{border-right:1px solid #666;border-top: 1px solid #666;}
</style>
<?php
//include("conn.php");
//include("projectTop.php");
/*function getCompany($username,$mysql){
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
*/
$sql="select * from `project` where `pname`='".$_COOKIE['project']."';";
$result=mysql_query($sql,$mysql);
$arr=mysql_fetch_array($result);
?>

<table width="80%"  width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td  >项目名称：<?php echo $arr['pname'];?></td>
    </tr>
    <tr>
        <td><?php echo $arr['pdiscrible'];?></td>
    </tr>
    <tr>
        <td>启动时间：<?php echo $arr['pstarttime'];?> 规定结束时间：<?php echo $arr['pendtime'];?></td>
    </tr>
    <tr>
        <td>项目参与人员：</td>
    </tr>
    <tr>
        <td><table    border="0" cellspacing="0" cellpadding="0" align="left">
                <?php
                $array=explode(',',$arr['pstaff']);
                $m=$array[0];
                foreach($array as $value)
                {
                    $sql="select * from `user` where `username`='".$value."';";
                    $result=mysql_query($sql,$mysql);
                    $resultarr=mysql_fetch_array($result);
                    if($value==$m){
                        echo "<tr>
        <td width='12%' bgcolor='#FF0000'>".$value."</td>
        <td width='88%' bgcolor='#FF0000'>".$resultarr['post']."</td>
      </tr>";
                    }
                    if($value!=$m){
                        echo "<tr>
        <td width='12%'>".$value."</td>
        <td width='88%'>".$resultarr['post']."</td>
      </tr>";
                    }
                }
                ?>
            </table></td>
    </tr>
</table>
<table width="80%"  width="100%" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr><td colspan="2" bgcolor="#9999CC">已完成模块：</td></tr>
    <?php
    $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
    $sql="select * from `thread` where `tcnamepro`='".$cnamepro."' order by 5;";
    $result=mysql_query($sql,$mysql);
    $level=-1;
    while($arr=mysql_fetch_array($result))//输出该项目下的所有模块
    {
        if($arr['tflag']==1){
            echo "<tr>";
            echo "<td>".$arr['tname']."</td>";
            echo "<td>".$arr['tdis']."</td>";
            echo "</tr>";
            $level=$arr['tlevel'];
        }
    }
    if($level==-1)
    {
        echo "<tr><td>";
        echo "没有已完成的模块!";
        echo "</td></tr>";
        $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
        $sql="select * from `thread` where `tcnamepro`='".$cnamepro."' order by 5;";
        $result=mysql_query($sql,$mysql);
        $arr=mysql_fetch_array($result);
        $level=$arr['tlevel']-1;
    }
    ?>
    <tr><td colspan="2"  bgcolor="#99FF66">正在进行的模块：</td></tr>
    <?php
    $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
    $sql="select * from `thread` where `tcnamepro`='".$cnamepro."' order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))//输出该项目下的所有模块
    {
        if($arr['tflag']==0&&$arr['tlevel']==$level+1){
            echo "<tr>";
            echo "<td>".$arr['tname']."</td>";
            echo "<td>".$arr['tdis']."</td>";
            echo "</tr>";
        }
    }
    ?>
    <tr><td colspan="2" border="1" bgcolor="#FFCC00">以后才能进行的模块：</td></tr>
    <?php
    $cnamepro=getCompany($_COOKIE['name'],$mysql)."@".$_COOKIE['project'];
    $sql="select * from `thread` where `tcnamepro`='".$cnamepro."' order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))//输出该项目下的所有模块
    {
        if($arr['tflag']==0&&$arr['tlevel']>$level+1){
            echo "<tr>";
            echo "<td>".$arr['tname']."</td>";
            echo "<td>".$arr['tdis']."</td>";
            echo "</tr>";
        }
    }
    ?>
</table>