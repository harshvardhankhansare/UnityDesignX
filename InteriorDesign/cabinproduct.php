<?php include('includes/header.php');?>

<head>
    <script src="Categories/product category/FURNITURE/Cabinetry/store.js" async></script>
    <script src="Categories/product category/FURNITURE/Cabinetry/sweetalert.min.js" async></script>
    <style>
    .img-fluid{
        height:400px;
        width:5400px;
    }

    .explore-btn{
        background-color:black;
        padding: 10px;
        color:white;
    }

    .explore-btn a{
        text-decoration:none;
        color:white;
        font-weight:bold;
    }
    .explore-btn:hover{
        background-color:#ddb78e;
    }

    </style>
</head>

<body>
    <section class="container content-section">
    <h1 class="text-center mt-5">Cabinatory Products</h1>
        <div class="border"></div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">IKEA | KALLAX1</h3>
                    <input type="hidden" value="IKEA | KALLAX1" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Cabinetry/Images/cabin2.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabin2.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 500</h5>
                        <input type="hidden" value="500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">BRIMNES</h3>
                    <input type="hidden" value="BRIMNES" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img src="Categories/product category/FURNITURE/Cabinetry/Images/cabin3.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabin3.jpg" name="p_img">
                    <h5 class="text-black">Rs. 800</h5>
                    <input type="hidden" value="800" name="p_price">
                    <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                </form>
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">DASH SQUARE 7</h3>
                    <input type="hidden" value="DASH SQUARE 7" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                    <img src="Categories/product category/FURNITURE/Cabinetry/Images/cabinn.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabinn.jpg" name="p_img">
                    <h5 class="text-black">Rs. 900</h5>
                    <input type="hidden" value="900" name="p_price">
                    <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Drawers 31</h3>
                    <input type="hidden" value="Drawers 31" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Cabinetry/Images/cabin5.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabin5.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1000</h5>
                        <input type="hidden" value="1000" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Display Shelf</h3>
                    <input type="hidden" value="Display Shelf" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img src="Categories/product category/FURNITURE/Cabinetry/Images/cabin6.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabin6.jpg" name="p_img">
                    <h5 class="text-black">Rs. 1500</h5>
                    <input type="hidden" value="1500" name="p_price">
                    <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                </form>
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Wooden Street</h3>
                    <input type="hidden" value="Wooden Street" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                    <img src="Categories/product category/FURNITURE/Cabinetry/Images/cabin7.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Cabinetry/Images/cabin7.jpg" name="p_img">
                    <h5 class="text-black">Rs. 700</h5>
                    <input type="hidden" value="700" name="p_price">
                    <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
            </div>
        </div>
</section>
<?php include('includes/footer.php');?>
