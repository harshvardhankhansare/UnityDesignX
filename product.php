<?php include('includes/header.php');?>

<head>
    <title>The Generics | Store</title>
    <meta name="description" content="This is the description">
    <!-- <link rel="stylesheet" href="styles.css" /> -->
    <style>
    .img-fluid{
        height:400px;
        width:5400px;
    }
    </style>
</head>

<section class="container content-section">
    <h1 class="text-center mt-5">Our Categories</h1>
    <div class="border"></div>
    <div class="row mt-5">
        <div class="col-6 text-center">
            <h3 class="text-center mt-5">Furniture</h3>
            <a href="furnitureproduct.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                <img src="Categories/Images/Furniture.jpg" class="img-fluid rounded">
            </a>
        </div>
        <div class="col-6 text-center">
            <h3 class="text-center mt-5">Lighting</h3>
            <a href="lightproduct.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
                <img src="Categories/Images/lighting.jpg" class="img-fluid rounded">
            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Floor</h3>
            <a href="floorproduct.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="Categories/Images/Floor.jpg" class="img-fluid rounded">
            </a>
        </div>
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Walls/Ceiling</h3>
            <a href="officestore.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="Categories/Images/wall.jpeg" class="img-fluid rounded">
            </a>
        </div>
    </div>
</section>

<?php include('includes/footer.php');?>