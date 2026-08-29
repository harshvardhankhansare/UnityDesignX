<?php
include('security.php');
if(isset($_POST['addcartbtn']))
{
    $pname = $_POST['p_name'];
    $pimg = $_POST['p_img'];
    $pprice = $_POST['p_price'];

    $uid = $_SESSION['uid'];

    $sql1 = "SELECT * FROM cart_info WHERE p_name ='$pname' AND u_id = '$uid'";
    $res1 = mysqli_query($conn,$sql1);

    if(mysqli_num_rows($res1) > 0)
    {
        echo "<script>
        alert('Product Already Added..!');
        window.location.href='cart_page.php';
        </script>";
    }
    else
    {
        $sql = "INSERT INTO cart_info (u_id, p_name, p_img, p_price, p_qty,p_total) VALUES ('$uid','$pname','$pimg','$pprice', '1','$pprice')";
        $res = mysqli_query($conn,$sql);

        if($res){
            echo "<script>
            alert('Product Added to Cart');
            window.location.href='cart_page.php';
            </script>";
        }
        else
        {
            echo "<script>
            alert('Product Not Added to Cart');
            window.location.href='product.php';
            </script>";
        }
    }

}
?>