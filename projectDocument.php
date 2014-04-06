<style type="text/css">
    table
    {
        border-collapse: collapse;
        margin-bottom: 3em;
        font-size: 70%;
        line-height: 1;
    }

    tr:hover, td.start:hover, td.end:hover
    {
        background: #FF9;
    }

    th, td
    {
        padding: .3em .5em;
        font-size: 10px;
    }

    th
    {
        font-weight: normal;
        text-align: left;
        background: url(css/pic/tabletree-arrow.gif) no-repeat 2px 50%;
        padding-left: 15px;
    }

    th.name {  font-size:15px;}
    th.location { font-size:15px; }
    th.color {  font-size:15px; }

    thead th
    {
        background: #c6ceda;
        border-color: #fff #fff #888 #fff;
        border-style: solid;
        border-width: 1px 1px 2px 1px;
        padding-left: .5em;
    }

    tbody th.start
    {
        background: url(css/pic/tabletree-dots.gif) 18px 54% no-repeat;
        padding-left: 26px;
    }

    tbody th.end
    {
        background: url(css/pic/tabletree-dots2.gif) 18px 54% no-repeat;
        padding-left: 26px;
    }
</style>
<table align="left" id="show" height="100%">
    <thead>
    <tr>
        <th class="name">文件类型</th>
        <th class="name">文件名</th>
        <th class="name">文件大小</th>
        <th class="name">上传者</th>
        <th class="name">上传日期</th>
        <th class="location">文件备注</th>
        <th class="name">下载</th>
    </tr>
    </thead>
    <tbody>
    <th colspan="7">项目内部文档</th>
    <?php
    //include("conn.php");
    include("documentFunction.php");
    //include("projectTop.php");
    $sql="select * from `project` where `pname`='".$_COOKIE['project']."';";
    $result=mysql_query($sql,$mysql);
    $arr=mysql_fetch_array($result);
    $cname=$arr['cname'];
    $path="./document/".$cname."/".$_COOKIE['project'];
    $cnamepro=$cname."@".$_COOKIE['project'];
    showFolderNoPower($path);

    if(isset($_POST['mySubmitd']))
    {

        $tmparr2=$_FILES['update'];
        $discrible=$_POST['myText'];
        updateFile($path,$tmparr2,$_COOKIE['name'],$discrible,$cnamepro);
        $content="上传了文档  ".$_FILES['update']['name'];
        $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
        mysql_query($sql,$mysql);
        header("Location:pnavigation.php");
    }
    if(isset($_GET['folder']))
    {
        if(isset($_GET['foldername']))
            $newpath=$path."/".$_GET['foldername'];
        @mkdir($newpath);
        $content="创建了项目内部的文件夹".$_GET['foldername'];
        $sql="INSERT INTO `plog`(`project`, ` content`, `time`, `people`) VALUES('".$cnamepro."','".$content."',NOW(),'".$_COOKIE['name']."');";
        mysql_query($sql,$mysql);
        $sql="INSERT INTO `folder`(`fname`,`faddress`,`fcnamepro`) VALUES('".$_GET['foldername']."','".$newpath."','".$cnamepro."')";
        mysql_query($sql,$mysql);
        header("Location:pnavigation.php");
    }
    ?>
    <td colspan="7" align="center"><form name='myForm'method='post' enctype='multipart/form-data' >
            <table width="200" border="0">
                <tr>
                    <td colspan="2" align="center">文件上传</td>
                </tr>
                <tr>
                    <td colspan="2"><input type='file' name='update'><br></td>
                </tr>
                <tr>
                    <td>对该文件的描述:</td>
                    <td>  <textarea name="myText" rows="5" cols="30" wrap="off">
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="mySubmitd" value="提交"/>
                    </td>
                </tr>
            </table>
        </form></td>

    <form  method="get" name="folder">

        创建文件夹（输入文件夹名）: <input type="text" name="foldername" value="" size="10" maxlength="40"/>

        <input type="submit" name="folder" value="创建"/>



    </form>

    <tbody>
</table>

