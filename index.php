<?php
session_start();
ob_start();
require_once "klasy.php";
include "template/head.php";

if(isset($_SESSION["id"])&& isset($_SESSION["user_type"]))
{
	include "template/menu_".$_SESSION['user_type'].".php";
	include "body/body_".$_SESSION['user_type'].".php";
}else
{
	include "template/menu_unlogged.php";
    include "body/body_unlogged.php";
}

include "template/footer.php";
ob_end_flush();
?>