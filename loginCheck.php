<?php
if(@$_COOKIE["name"]=='')
{
	print_r($_COOKIE);
	header("location:login.php");
}
?>
