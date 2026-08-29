<?php 
include('security.php');

if(isset($_POST['login']))
{
    $s_email = $_POST['uemail'];
    $s_pass = $_POST['upassword'];

    if(empty($s_email)){
        header("location: login.html?error=Email is required");
        exit();
    }
    else if(empty($s_pass)){
        header("location: login.html?error=Password is required");
        exit();
    }
    else{
         //hashing the password
        $sql = "SELECT * FROM user_info WHERE uemail = '$s_email' AND upass = '$s_pass'";
        $result = mysqli_query($conn , $sql);

        if(mysqli_num_rows($result) === 1)
        {
            $row  = mysqli_fetch_assoc($result);
            if($row['uemail'] === $s_email)
            {
                $_SESSION['uemail'] = $row['uemail'];
                $_SESSION['uname'] = $row['uname'];
                $_SESSION['uid'] = $row['uid'];
                header("location: index.php");
                exit();
            }
            else
            {
                header("location: login.html?error=Incorrect Username or Password");
                exit();
            }
        }
        else
        {
            header("location: login.html?error=Incorrect Username or Password");
            exit();
        }
    }
}
else{
    header("location: login.html");
    exit();
}
?>