<?php include('includes/header.php');?>

<head>
    <script src="Categories/product category/LIGHTING/store.js" async></script>
    <script src="Categories/product category/LIGHTING/sweetalert.min.js" async></script>
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
    <h1 class="text-center mt-5">Floor Products</h1>
        <div class="border"></div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Vetrified Floor Tile</h3>
                    <input type="hidden" value="Vetrified Floor Tile" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/floor6.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/floor6.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 500</h5>
                        <input type="hidden" value="500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Ceramic Floor Tile</h3>
                    <input type="hidden" value="Ceramic Floor Tile" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/foor1.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/foor1.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1500</h5>
                        <input type="hidden" value="1500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Anti Skid Floor</h3>
                    <input type="hidden" value="Anti Skid Floor" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/floor4.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/floor4.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 500</h5>
                        <input type="hidden" value="500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Rustik Tiles</h3>
                    <input type="hidden" value="Rustik Tiles" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/floor3.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/floor3.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 500</h5>
                        <input type="hidden" value="500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Premium Quality Tiles</h3>
                    <input type="hidden" value="Premium Quality Tiles" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/floor2.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/floor2.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1500</h5>
                        <input type="hidden" value="1500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Premium Quality Floor</h3>
                    <input type="hidden" value="Premium Quality Floor" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/TILES/Images/floor5.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/TILES/Images/floor5.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 500</h5>
                        <input type="hidden" value="500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>

</section>
<?php include('includes/footer.php');?>
