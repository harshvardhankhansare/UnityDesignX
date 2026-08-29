<?php
include "security.php";
 
if(isset($_POST['register'])){

    $s_name = $_POST['u_name'];
    $s_email = $_POST['u_email'];
    $s_pass = $_POST['u_password'];

    $uppercase = preg_match('@[A-Z]@', $s_pass);
    $lowercase = preg_match('@[a-z]@', $s_pass);
    $number    = preg_match('@[0-9]@', $s_pass);
    $specialChars = preg_match('@[^\w]@', $s_pass);

    $s_cpass = $_POST['u_cnf_password'];


    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($s_pass) < 8) {
        header("location: signup.html?error= Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.");
        exit();
    }
    else if($s_pass !== $s_cpass){
        header("location: signup.html?error=Confirm Password Does not Matched");
        exit();
    }
    else
    {
        $sql2 = "INSERT INTO user_info (uname, uemail, upass) Values ('$s_name','$s_email','$s_pass')";  
        
        $result2 = mysqli_query($conn , $sql2);

            if($result2)
            {
                header("location: signup.html?success=Your Account has been Registered Successfully");
                exit();
            }
            else
            {
                header("location: signup.html?error=Something Went Wrong");
                exit();
            }
        }
    }
else{
    header("location: signup.html");
    exit();
}
?>