<?php

include('security.php');

if(isset($_POST['check_btn']))
{
    $uid = $_POST['u_id'];
    $total = $_POST['total'];

    $sql = "INSERT INTO order_info (u_id,order_price) VALUES ('$uid','$total')";
    $res = mysqli_query($conn, $sql);

    if($res)
    {
        $sql2 = "DELETE FROM cart_info WHERE u_id='$uid'";
        $res2 = mysqli_query($conn, $sql2);
        if(mysqli_affected_rows($conn) > 0)
        {
            echo "<script>
            alert('Order Booked Successfully..!!');
            window.location.href='cart_page.php';
            </script>";
        }
        else
        {
            echo "<script>
            alert('Add item first..');
            window.location.href='cart_page.php';
            </script>";
        }
    }
    else
    {
        echo "<script>
            alert('Something went wrong..2!');
            window.location.href='cart_page.php';
            </script>";
    }
}

?>