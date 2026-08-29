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
    <h1 class="text-center mt-5">Lighting Products</h1>
        <div class="border"></div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Twintown Light</h3>
                    <input type="hidden" value="Twintown Light" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image3.png" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image3.png" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 2000</h5>
                        <input type="hidden" value="2000" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Alian BlackGold</h3>
                    <input type="hidden" value="Alian BlackGold" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image4.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image4.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1500</h5>
                        <input type="hidden" value="1500" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Tino Gold</h3>
                    <input type="hidden" value="Tino Gold" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image2.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image2.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1000</h5>
                        <input type="hidden" value="1000" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Lisma Brown</h3>
                    <input type="hidden" value="Lisma Brown" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image1.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image1.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 200</h5>
                        <input type="hidden" value="200" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Brown Town</h3>
                    <input type="hidden" value="Brown Town" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image5.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image5.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1000</h5>
                        <input type="hidden" value="1000" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
            <div class="col-4 text-center">
                <form action="cart.php" method="POST">
                    <h3 class="text-center mt-5">Lumim Decoration</h3>
                    <input type="hidden" value="Tino Gold" name="p_name">
                    <a href="#" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                        <img name="p_img" src="Categories/product category/LIGHTING/LightImage/image6.jpg" class="img-fluid rounded">
                    </a>
                    <input type="hidden" value="Categories/product category/LIGHTING/LightImage/image6.jpg" name="p_img">
                    <div>
                        <h5 name="p_price" class="text-black">Rs. 1000</h5>
                        <input type="hidden" value="1000" name="p_price">
                        <button type="submit" name="addcartbtn" class="btn explore-btn">Add to Cart</button>
                    </div> 
                <form> 
            </div>
        </div>

</section>
<?php include('includes/footer.php');?>
