<?php
include("conn.php");
function level($num)
{
    switch ($num)
    {
        case 1:
            return "需求分析阶段";
            break;
        case 2:
            return "概要设计阶段";
            break;
        case 3:
            return "详细设计阶段";
            break;
        case 4:
            return "编码阶段";
            break;
        case 5:
            return "测试阶段";
            break;
    }
    return ;
}
function drawArrow($im,$x,$max)
{
    //$arr=array($x+10,90,$x+30,90,$x+30,80,$x+40,100,$x+30,120,$x+30,110,$x+10,110,$x+10,90);
    //$green=imagecolorallocate($im,0,255,0);
    //imagefilledpolygon($im,$arr,7,$green);
    //$black=imagecolorallocate($im,0,0,0);
    //imageline($im,$x+20,0,$x+20,50*($max+1),$black);
}
function showSpeedImage($name,$company)
{
    global $mysql;
    $thread=array(1,1,1,1,1,1);// 用于定位每一优先度下的模块图y轴位置,1*一个定量就是 y轴的位置
    $x=0;//记录下一个模块矩形x轴的位置
    $prelevel=-1;//记录上一个模块的优先度
    $i=-1;//调用larry中的第i个值
    $prex=0;//记录上一层模块最大距离
    $sql="select * from `thread` where `tcnamepro`='".$company."@".$name."'order by 5;";
    $result=mysql_query($sql,$mysql);
    $max=0;
    $temp=1;
    $pretlevel=0;
    while($arr=mysql_fetch_array($result))//确定最多有几项模块并列，从而确定图像的高度
    {
        if($arr['tlevel']==$pretlevel)
        {
            $temp++;
        }else
        {
            if($temp>$max)
            {
                $max=$temp;
                $temp=1;
            }
            $pretlevel=$arr['tlevel'];
        }
    }
    $im=imagecreate(800,50*($max+2));
    //$grey1=imagecolorallocate($im,64,64,255);
    $white=imagecolorallocate($im,255,255,255);
    $grey=imagecolorallocate($im,144,144,144);
    $blue=imagecolorallocate($im,0,0,255);
    $black=imagecolorallocate($im,0,0,0);
    $skyblue=imagecolorallocate($im,128,128,255);
    imagefilledrectangle($im,0,0,800,20,$skyblue);
    $sql="select * from `thread` where `tcnamepro`='".$company."@".$name."'order by 5;";
    $result=mysql_query($sql,$mysql);
    while($arr=mysql_fetch_array($result))
    {
        if($arr['tlevel']!=$prelevel){
            $i++;
            $x=$x+$prex;
            if($prelevel>-1)
            {
                drawArrow($im,$x,$max);
            }
        }else
        {
            $thread[$i]++;
        }
        $numi=$i+1;
        $stage="阶段".$numi;
        $stage=level($numi);
        $str= $stage;
        imagettftext($im,11,0,$x+50,15,$black,"simfang.ttf",$str);
        if($arr['tflag']==0)
        {
            $red=imagecolorallocate($im,255,0,0);
            imagefilledrectangle($im,$x+50,50*$thread[$i]-15,$x+50+5*$arr['tcontribution'],50*$thread[$i]+15,$red);
            $white=imagecolorallocate($im,255,255,255);
            $black=imagecolorallocate($im,0,0,0);
            $str =$arr['tname'];
            imagettftext($im,11,0,$x+50,50*$thread[$i]-15,$black,"simfang.ttf",$str);
        }else{
            $blue=imagecolorallocate($im,0,0,255);
            imagefilledrectangle($im,$x+50,50*$thread[$i]-15,$x+50+5*$arr['tcontribution'],50*$thread[$i]+15,$blue);
            $white=imagecolorallocate($im,255,255,255);
            $black=imagecolorallocate($im,0,0,0);
            $str = $arr['tname'];
            imagettftext($im,11,0,$x+50,50*$thread[$i]-15,$black,"simfang.ttf",$str);
        }
        if($prex<100+5*$arr['tcontribution'])
        {
            $prex=5*$arr['tcontribution']+70;//在原先位置加上模块矩形的长度再加50是下一个图形的起始位置
        }
        $prelevel=$arr['tlevel'];
    }
    //imageline($im,0,50*($max+1),800,50*($max+1),$black);
    //$ay=50*($max+1);
    //$arrow=array(0,$ay-20,750,$ay-20,750,$ay-40,780,$ay,0,$ay,0,$ay-20);
    //$green=imagecolorallocate($im,0,255,0);
    //imagefilledpolygon($im,$arrow,6,$green);
    $sql2="select * from `project` where `pname`='".$name."' AND `cname`='".$company."';";
    $result2=mysql_query($sql2,$mysql);
    $arr2=mysql_fetch_array($result2);
    $str1="项目  ".$name."  完成度为".$arr2['pspeed']."%";
    imagettftext($im,15,0,150,50*($max+2)-34,$black,"simfang.ttf",$str1);
    imagerectangle($im,148,50*($max+2)-32,452,50*($max+2)-8,$black);
    imagefilledrectangle($im,150,50*($max+2)-30,150+300*$arr2['pspeed']/100,50*($max+2)-10,$grey);
    imagegif($im,$name.".jpg");
    return "<img src='".$name.".jpg'>";
}

?>
