<?php
session_start();
include('config.php');

// if(!$conn){
//     // header("Location : config.php");
// }

if(!isset($_SESSION['uid']))
{
    header("location:login.html");
}

?>