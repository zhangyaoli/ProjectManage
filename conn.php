<?php
$HOST='localhost';
$USER='root';
$PASSWORD='';
$DB_NAME='ProjectManage';
$mysql=@mysql_connect($HOST,$USER,$PASSWORD)or die('数据库连接失败');
mysql_select_db($DB_NAME,$mysql);
mysql_query("set names utf8");

?>