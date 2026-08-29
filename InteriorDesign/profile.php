<?php
include('includes/header.php');
?>

<head>
    <link rel="stylesheet" href="Profile/index.css">
</head>
<body>
        <div class="container light-style flex-grow-1 container-p-y">
        <h1 class="text-center mt-5">My Profile</h1>
        <div class="border"></div>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-connections">Order History</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <hr class="border-light m-0">
                                <?php
                                    $id= $_SESSION['uid'];

                                    $sql = "SELECT * FROM user_info WHERE uid='$id'";
                                    $res = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($res);

                                ?>
                                <form action="update_profile.php" method="POST">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control mb-1" name="uname" value="<?php echo $row['uname']; ?>">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label class="form-label">E-mail</label>
                                            <input type="text" class="form-control mb-1" name="uemail" value="<?php echo $row['uemail']; ?>">
                                            <!-- <div class="alert alert-warning mt-3">
                                            Your email is not confirmed. Please check your inbox.<br>
                                            <a href="javascript:void(0)">Resend confirmation</a>
                                        </div> -->
                                        </div>
                                        <div class="form-group mt-3">
                                            <button type="submit" class="btn btn-primary" name="general_btn">Save changes</button>&nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <form action="update_profile.php" method="POST">
                                    <div class="card-body pb-2">
                                        <div class="form-group">
                                        <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
                                            <label class="form-label">Current password</label>
                                            <input type="text" class="form-control" name="old_pass" value="<?php echo($row['upass']); ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">New password</label>
                                            <input type="password" class="form-control" name="new_pass">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Repeat new password</label>
                                            <input type="password" class="form-control" name="new_cnf_pass">
                                        </div>
                                        <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary" name="pass_btn">Change Password</button>&nbsp;
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="account-connections">
                                <div class="card-body">
                                    <section class="container content-section">
                                        <h2 class="text-center">Previous Order</h2>
                                        <div class="border"></div>
                                        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Order Price</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sql = "SELECT * FROM order_info WHERE u_id='$id'";
                    $result = mysqli_query($conn , $sql);

                    $count = 1;
                    if(mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                        ?>
                        <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['order_price'];?></td>                
                            <td><?php echo $row['order_date'];?></td>                
                            <td><?php echo $row['time'];?></td>                
                        </tr>
                        <?php
                        $count = $count + 1;
                        }
                    }
                    else{
                    echo "No Record Found..!!";
                    }
                    ?>
            </tbody>
        </table>
                                        <!-- <button class="btn btn-primary btn-purchase" type="button">PURCHASE</button> -->
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="Profile/index.js"></script>
    </body>

<?php
include('includes/footer.php');

?>