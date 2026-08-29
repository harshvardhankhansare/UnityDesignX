<?php include('includes/header.php');?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <style>
        .profile-image-pic{
  height: 170px;
  width: 170px;
  object-fit: cover;
}
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">My Cart</h1>
        <div class="border"></div>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = "SELECT * FROM cart_info WHERE u_id='$id' AND c_time = '$today'";
                    $result = mysqli_query($conn , $sql);

                    $count = 1;
                    $total = 0;
                    $uid=0;
                    if(mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $uid=$row['u_id'];
                        ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo '<img class="img-fluid profile-image-pic img-thumbnail rounded-circle" alt="profile" src="'.$row['p_img'].'">'?></td>
                            <td><?php echo $row['p_name']; ?></td>
                            <td>Rs. <?php echo $row['p_price']; ?> /-</td>
                            <td>
                                <form action="updt_cart_DB.php" method="POST">
                                    <input type="hidden" name="cid" value="<?php echo $row['cid']; ?>">    
                                    <input type="hidden" name="pprice" value="<?php echo $row['p_price']; ?>">    
                                    <input type="number" id="quantity" name="updt_qty" min='1' value="<?php echo $row['p_qty']; ?>" max="20">
                                    <button type="submit" name="updtqty_btn" class="btn btn-success">Update</button>
                                </form> 
                            </td>
                            <td>Rs. <?php echo $row['p_price'] * $row['p_qty']; ?> /- </td>
                            <td>
                                <form class="text-center" action="removefromcart.php" method="POST">
                                    <input type="hidden" name="cid" value="<?php echo $row['cid']; ?>">
                                    <button type="submit" name="delete_btn" class="btn btn-danger">Remove</button>
                                </form>
                            </td>                 
                        </tr>
                        <?php
                        $count = $count + 1;
                        $total = $total + $row['p_total'];
                        }
                    }
                    else{
                    echo "No Record Found..!!";
                    }
                    ?>
                    <tr>
                        <td>Total :- </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Rs. <?php echo $total;?> /-</td>
                        <td>
                            <form class="text-center" action="checkout.php" method="POST">
                                <input type="hidden" name="u_id" value="<?php echo $uid; ?>">
                                <input type="hidden" name="total" value="<?php echo $total; ?>">
                                <button type="submit" name="check_btn" class="btn btn-success">Check Out</button>
                            </form>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script>
        new DataTable('#example');
    </script>
<?php include('includes/footer.php');?>
