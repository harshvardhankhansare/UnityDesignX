<?php include('includes/header.php');?>

<head>
    <style>
    .img-fluid{
        height:400px;
        width:5400px;
    }
    </style>
</head>

<div class="container mt-5">
    <h1 class="text-center mt-5">Design Sets</h1>
    <div class="border"></div>
    <div class="row mt-5">
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Home</h3>
            <a href="store.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="HomeDesign/Images/home.jpg" class="img-fluid rounded">
            </a>
        </div>
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Office</h3>
            <a href="officestore.php" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="HomeDesign/Images/office.jpg" class="img-fluid rounded">
            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Hospital</h3>
            <a href="https://unsplash.it/1200/768.jpg?image=254" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="HomeDesign/Images/hospital.jpg" class="img-fluid rounded">
            </a>
        </div>
        <div class="col-6 text-center">
                <h3 class="text-center mt-5">Industry</h3>
            <a href="https://unsplash.it/1200/768.jpg?image=255" data-toggle="lightbox" data-gallery="gallery" class="col-md-6">
            <img src="HomeDesign/Images/industry.jpg" class="img-fluid rounded">
            </a>
        </div>
    </div>
</div>
<?php include('includes/footer.php');?>