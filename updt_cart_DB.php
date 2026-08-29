<?php
include('security.php');

if(isset($_POST['updtqty_btn']))
{
    $cid = $_POST['cid'];
    $pprice = $_POST['pprice'];
    $p_qty = $_POST['updt_qty'];

    $total = $pprice * $p_qty;

    $query = "UPDATE cart_info SET p_qty='$p_qty',p_total='$total' WHERE cid='$cid' ";  
    $query_run = mysqli_query($conn,$query);

    if($query_run)
    {
        echo "<script>
        alert('Qunatity Updated..!');
        window.location.href='cart_page.php';
        </script>";
    }
    else{
        echo "<script>
        alert('Something went wrong..!');
        window.location.href='cart_page.php';
        </script>";
    }
 
}

?>