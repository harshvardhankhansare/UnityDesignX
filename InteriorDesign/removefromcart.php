<?php

include('security.php');

if(isset($_POST['delete_btn']))
{
    $cid = $_POST['cid'];

    $sql = "DELETE FROM cart_info WHERE cid='$cid'";
    $res = mysqli_query($conn, $sql);

    if($res)
    {
        echo "<script>
        alert('Product Removed From Cart');
        window.location.href='cart_page.php';
        </script>";
    }
    else
    {
        echo "<script>
        alert('Something went wrong..!');
        window.location.href='cart_page.php';
        </script>";
    }
}


?>