<?php
$sname = "localhost";
$db_usname = "root";
$db_password = "";
$db_name = "unity";

$conn = mysqli_connect($sname, $db_usname, $db_password, $db_name, 3307);

if($conn)
{
    // echo "Coonection passed";
}
?>