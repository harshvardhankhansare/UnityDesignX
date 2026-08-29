<?php
include "security.php";
 
if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];

    $sql2 = "INSERT INTO contact_info (cname, cemail, cmsg) Values ('$name','$email','$msg')";  
        
    $result2 = mysqli_query($conn , $sql2);

    if($result2)
    {
        header("location: index.php?success=Message Send..!");
        exit();
    }
    else
    {
        header("location: index.php?error=Something Went Wrong");
        exit();
    }
}
else{
    header("location: index.php");
    exit();
}
?>