<?php
session_start();
if(session_destroy())
{
    unset($_SESSION['id']);
    unset($_SESSION['type']);
    clearstatcache();
    header("Location: index.php");
}
?>