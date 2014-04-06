<style type="text/css">
    table{border-left: 1px solid #666; border-bottom: 1px solid #666;}
    td{border-right:1px solid #666;border-top: 1px solid #666;}
</style>
<?php
include("conn.php");
//include("projectTop.php");
?>
<table width="732" height="80"border="1" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td colspan="4" align="center" bgcolor="#99CCCC">我的任务</td>
    </tr>
    <tr>
        <td width="56" height="26">序号</td>
        <td width="448" height="26" align="center">内容</td>
        <td width="101" height="26">状态</td>
        <td width="109" height="26">反馈意见</td>
    </tr>
    <?php
    $name=$_COOKIE['name'];
    $project=$_COOKIE['project'];
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
    $sql="select * from `task` where `receive`='".$_COOKIE['name']."'AND `project`='".$project."@".getCompany($name,$mysql)."'order by 3;";
    $result=mysql_query($sql,$mysql);
    $i=1;
    $num=mysql_num_rows($result);
    if($num==0)
    {
        echo "<tr><td colspan='4'>当前没有任务！</td></tr>";
    }
    while($arr=mysql_fetch_array($result))
    {
        echo "<tr> ";
        echo "<td >".$i++."</td>";
        echo "<td align='center'>".$arr['content']."</td>";
        if($arr['complete']!=1&&$arr['apply']==0){echo "<td > <a href='projectsubmit.php?project=".$arr['tid']."'>申请完成</a></td>";}
        if($arr['complete']!=1&&$arr['apply']==1){echo "<td >正在审核</td>";}
        if($arr['complete']==1){echo "<td >任务完成</td>";}
        if($arr['recontent']!=''){echo "<td align='center'> ".$arr['recontent']."</td>";}
        if($arr['recontent']==''){echo "<td>暂无</td>";}
        echo "</tr>";
    }

    if($_COOKIE['projectManager']==1)
    {
        echo  " <tr><td colspan='4' align='center' bgcolor='#99CCCC'>申请结算的任务</td></tr>";
        echo "  <tr>
    <td>申请人</td>
    <td colspan='2' align='center'>申请的任务</td>
    <td>你的回应</td>
  </tr>";
        $sql2="select * from `task` where `apply`=1 AND `project`='".$project."@".getCompany($name,$mysql)."';";
        $result2=mysql_query($sql2,$mysql);
        while(@$arr2=mysql_fetch_array($result2))
        {    echo "<tr>";
            echo "<td >".$arr2['receive']."</td>";
            echo "<td colspan='2' align='center'>".$arr2['content']."</td>";
            echo "<td  align='center'><a href='projectreply.php?tid=".$arr2['tid']."'>回应</a></td>";
            echo "</tr>";
        }
        $num2=mysql_num_rows($result2);
        if($num2==0)
        {
            echo "<tr ><td colspan='4' align='center'>当前没有新的申请！</td></tr>";
        }
    }
    ?>
    <tr>
        <td colspan="4" align="center" bgcolor="#99FF66">当前阶段开发模块</td>
    </tr>
    <?php
    $sql="select * from `thread` where `tcnamepro`='".getCompany($name,$mysql)."@".$project."'order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        if($arr['tflag']==1){
            $level=$arr['tlevel'];//优先度最高的已做完模块，可以用于确定接下来要做的模块
        }
        if($arr['tflag']==0&&$arr['tlevel']==@$level+1){
            echo "<tr>".
                "<td colspan='4' align='center'>".$arr['tname']."(".$arr['tdis'].")</td>".
                "</tr>";
        }
    }
    ?>
    <tr>
        <td colspan="4" align="center" bgcolor="#FFCC00" >下一阶段开发模块</td>
    </tr>
    <?php
    $sql="select * from `thread` where `tcnamepro`='".getCompany($name,$mysql)."@".$project."'order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        if($arr['tflag']==1){
            $level=$arr['tlevel'];//优先度最高的已做完模块，可以用于确定接下来要做的模块
        }
        if($arr['tflag']==0&&$arr['tlevel']==@$level+2){
            echo "<tr>".
                "<td colspan='4' align='center'>".$arr['tname']."(".$arr['tdis'].")</td>".
                "</tr>";
        }
    }
    ?>
</table>
