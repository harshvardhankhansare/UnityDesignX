<?php
include('security.php');

if(isset($_POST['general_btn']))
{
    $uname = $_POST['uname'];
    $uemail = $_POST['uemail'];
    $id = $_POST['uid'];
    
    $sql = "UPDATE user_info SET uname='$uname' WHERE uid='$id'";
    $res = mysqli_query($conn, $sql);

    $sql2 = "UPDATE user_info SET uemail='$uemail' WHERE uid='$id'";
    $res2 = mysqli_query($conn, $sql2);

    if($res)
    {
        if($res2)
        {
            echo "<script>
            alert('Genreal Info Updated');
            window.location.href='profile.php';
            </script>";
        }
    }
    else
    {
        echo "<script>
        alert('Something went wrong');
        window.location.href='profile.php';
        </script>";
    }
}

if(isset($_POST['pass_btn']))
{

    $new_pass = $_POST['new_pass'];
    $new_cnf_pass = $_POST['new_cnf_pass'];
    $id = $_POST['uid'];

    if($new_pass === $new_cnf_pass)
    {
        echo($new_pass);
        $sql = "UPDATE user_info SET upass='$new_pass' WHERE uid='$id'";
        $res = mysqli_query($conn, $sql);
        if($res)
        {
            echo "<script>
            alert('Password Updated');
            window.location.href='profile.php';
            </script>";
        }   
        else
        {
            echo "<script>
            alert('Something went wrong');
            window.location.href='profile.php';
            </script>";
        }
    }
    else
        {
            echo "<script>
            alert('password not match');
            window.location.href='profile.php';
            </script>";
        }
    
}

?>