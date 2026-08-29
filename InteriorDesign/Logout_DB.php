<?php
include('security.php');

unset($_SESSION['uemail']);
unset($_SESSION['uname']);
unset($_SESSION['uid']);
session_destroy();
header("location:index.php");

?>