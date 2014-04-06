<?php
if(isset($_COOKIE['name']))
{
	$name=$_COOKIE['name'];
	setcookie($name);
	header("location:login.php");
}
?>
