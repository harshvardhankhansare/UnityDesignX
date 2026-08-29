<?php include('includes/header.php');?>

<head>
    <script src="Categories/product category/FURNITURE/Beds/store.js" async></script>
    <script src="Categories/product category/FURNITURE/Beds/sweetalert.min.js" async></script>
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
    <h1 class="text-center mt-5">Bed Products</h1>
        <div class="border"></div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">IKEA | KALLAX2</h3>
                    <input type="hidden" value="IKEA | KALLAX2" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed1.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed1.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 560</h5>
                        <input type="hidden" value="560" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">BRIMNES Bookcase</h3>
                    <input type="hidden" value="BRIMNES Bookcase" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed2.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed2.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 870</h5>
                        <input type="hidden" value="870" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Dash Square</h3>
                    <input type="hidden" value="Dash Square" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed3.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed3.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 800</h5>
                        <input type="hidden" value="800" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Drawers 32</h3>
                    <input type="hidden" value="Drawers 32" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed4.png" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed4.png" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1200</h5>
                        <input type="hidden" value="1200" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Shelf 29</h3>
                    <input type="hidden" value="Shelf 29" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed5.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed5.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 475</h5>
                        <input type="hidden" value="475" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Plush Homes</h3>
                    <input type="hidden" value="Plush Homes" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/FURNITURE/Beds/Images/bed7.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/FURNITURE/Beds/Images/bed7.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1100</h5>
                        <input type="hidden" value="1100" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>

</section>
<?php include('includes/footer.php');?>
