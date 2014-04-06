<script type="text/javascript" language="javascript" >
    //这段js建立一个二级联动菜单
    var typeDoc=new Array();
    typeDoc[0]=["WORD","application/msword"];
    typeDoc[1]=["EXECL","application/vnd.ms-e"];
    typeDoc[2]=["PPT","application/vnd.ms-p"];
    typeDoc[3]=["PDF"," application/pdf"];
    typeDoc[4]=["TXT","text/plain"];
    typeDoc[5]=["HTML","text/html"];
    typeDoc[6]=["PHP","application/octet-st"];
    var type=new Array(typeDoc,0,0,0);
    function createSecond(num)
    {
        for(var i=document.myForm.selectType2.length;i>-1;i--)//>
        {document.myForm.selectType2.remove(i);}
        theArray=type[num];
        if(theArray!=0){
            for(i=0;i<theArray.length;i++)//>
            {
                document.myForm.selectType2.options[i]=new Option(theArray[i][0],theArray[i][1]);
            }
        }
    }
</script>
<?php
include("conn.php");
//include("documentFunction.php");
//要输出的文件夹路径集合数组
$OUTPUT_ARRAY=array();
if(isset($_COOKIE['name'])){
    $sql="select * from `user` where `username`='".$_COOKIE['name']."';";
    $result=mysql_query($sql,$mysql);
    $arrUser=mysql_fetch_array($result);
    $username=$_COOKIE['name'];//获取用户名
    $userPow=$arrUser['power'];//获取用户权限
    $usercompany=$arrUser['cname'];
    $sql2="select * from `project`;";
    $resultFolder=mysql_query($sql2,$mysql);
    while($arrFolder=mysql_fetch_array($resultFolder))//获取该用户可查看的文件夹(只包括公司、项目文件夹),以下的文件夹能进具体文件夹就说明有权限了
    {  	  //   小于4指有进入项目文件夹的权限,指有权查看所有项目的管理人员 strstr cname那个条件指属于本公司的文件夹,fvp!=''表示这是一个项目文件夹
        if(strstr($arrFolder['pstaff'],$username)!=false&&(strstr($arrFolder['cname'],$usercompany)!=""))
        {
            $address="./document/".$usercompany."/".$arrFolder['pname'];
            $cp=$arrFolder['cname']."@".$arrFolder['pname'];
            $sql="select * from `folder` where `fcnamepro`='".$cp."';";
            $result=mysql_query($sql,$mysql);
            while(@$arr=mysql_fetch_array($result))
            {
                if($arr['fvp']=='')
                {
                    array_push($OUTPUT_ARRAY,$arr['faddress']);
                }
            }

            array_push($OUTPUT_ARRAY,$address);
            //如果没有进入文件夹的权限，查看是否是指定可以访问的人
        }

    }
    $FILE_ARRAY=array();//从可查看文件夹中获取所有可查看的文件放入数组中
    foreach($OUTPUT_ARRAY as $value)
    {
        $tmparr1=scandir($value);
        for($i=0;$i<count($tmparr1);$i++)
        {
            array_push($FILE_ARRAY,$tmparr1[$i]);
        }
    }
//接收搜索表单上传内容
    if(isset($_GET['mySubmit']))
    {
        $searchName=$_GET['textName'];
        $searchType=(isset($_GET['selectType2']))?$_GET['selectType2']:$_GET['selectType1'];
        $searchTime=date("Y-m-d H:i:s",time()-$_GET['selectTime']*7*86400);//获取N周前的时间
        $searchUser=$_GET['selectPeople'];
        $searchDis=$_GET['textDis'];
        searchFile($searchName,$searchType,$searchTime,$searchUser,$searchDis,$FILE_ARRAY);
    }
}
?>
<html>
<body onload='createSecond(0)'>
<form name='myForm' method='get'>
    文件名关键字：<br>
    <input type='text' name='textName'>
    <hr>
    文档类型选择：<br>
    <select name='selectType1' size='1' onChange='createSecond(this.selectedIndex)'>
        <option value='value1'>文档文件</option>
        <option value='image'>图片文件</option>
        <option value='application/octet-st'>压缩文件</option>
        <option value='video'>视频文件</option>
        <option value=''>所有文件</option>
    </select>
    <select name='selectType2' size='1'>
    </select>
    <hr>
    上传时间选择：<br>
    <select name='selectTime' size='1'>
        <option value='1'>一周内</option>
        <option value='2'>两周内</option>
        <option value='4'>一个月内</option>
        <option value='52'>一年内</option>
    </select>
    <hr>
    <?php
    echo "上传人选择：<br>".
        "<select name='selectPeople' size='1'>";
    $sql3="select * from `user` where `cname`='".$arrUser['cname']."';";
    echo "<option value=''>所有人</option> <br>";
    $result3=mysql_query($sql3,$mysql);
    while($tmparr3=mysql_fetch_array($result3))
    {
        echo "<option value='".$tmparr3['username']."'>".$tmparr3['username']."</option> <br>";
    }
    echo "</select> <hr>";
    ?>
    文件描述关键字： <br>
    <input type='text' name='textDis'>
    <hr>
    <input type='submit' name='mySubmit' value='搜索'>
</form>
</body>
</html>
