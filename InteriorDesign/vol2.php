<?php
include('includes/header.php');
?>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Yatra+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="HomeDesign/imagesSideShowFloor/home2/style.css">
</head>
<body>
  
    <div class="product-container">
        <div class="product-image">    
          <div class="container">
                <div class="mySlides">
                  <div class="numbertext">1 / 4</div>
                  <img src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr1 1.jpg" style="width:100%" >
                </div>
              
                <div class="mySlides">
                  <div class="numbertext">2 / 4</div>
                  <img src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr2 1.jpg" style="width:100%">
                </div>
              
                <div class="mySlides">
                  <div class="numbertext">3 / 4</div>
                  <img src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr3 1.jpg" style="width:100%">
                </div>
                  
                <div class="mySlides">
                  <div class="numbertext">4 / 4</div>
                  <img src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr4 1.jpg" style="width:100%">
                </div>
                  
                <a class="prev" onclick="plusSlides(-1)">❮</a>
                <a class="next" onclick="plusSlides(1)">❯</a>
              
                <div class="caption-container">
                  <p id="caption"></p>
                </div>
              
                <div class="row">
                  <div class="column">
                    <img class="demo cursor" src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr1 1.jpg" style="width:100%" onclick="currentSlide(1)" alt="Living Room">
                  </div>
                  <div class="column">
                    <img class="demo cursor" src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr2 1.jpg" style="width:100%" onclick="currentSlide(2)" alt="Bed Room">
                  </div>
                  <div class="column">
                    <img class="demo cursor" src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr3 1.jpg" style="width:100%" onclick="currentSlide(3)" alt="Dining Room">
                  </div>
                  <div class="column">
                    <img class="demo cursor" src="HomeDesign/imagesSideShowFloor/home2/images/New folder/sr4 1.jpg" style="width:100%" onclick="currentSlide(4)" alt="Kitchen">
                  </div>
                </div>
              </div>
              
        </div>
        <div class="product-info">
          <h1 id="h2"> <br> Scandinavian Designs</h1>
          <h3>by Designx</h3>
        <p>This table seamlessly combines traditional
             lo craftsmanship with modern design,
              offering the perfect centerpiece for your tea gatherings. 
              Sourced responsibly, the materials used reflect our
               commitment to sustainability, making it a conscious choice for your
                home decor.<p>
          <!-- <h2>Table: Rs.3000</h2> -->
          <!-- <a href="http://localhost:1234/"><button class="add-to-cart" data-product="Table">View in 3D</button> -->
          <!-- <button class="add-to-cart1" data-product="Table">Contact Us</button> -->
        </a></div>
      </div>
      
      <script>
        let slideIndex = 1;
        showSlides(slideIndex);
        
        function plusSlides(n) {
          showSlides(slideIndex += n);
        }
        
        function currentSlide(n) {
          showSlides(slideIndex = n);
        }
        
        function showSlides(n) {
          let i;
          let slides = document.getElementsByClassName("mySlides");
          let dots = document.getElementsByClassName("demo");
          let captionText = document.getElementById("caption");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
          captionText.innerHTML = dots[slideIndex-1].alt;
        }
        
        // function Move(){
        //   window.scrollTo(50, 1200, 
        //   'smooth' );
        // }
        function Move() {
          window.scrollTo({
            top: 1200,
            left: 50,
            behavior: 'smooth'
            
          });
        }
        
        </script>
<?php
include('includes/footer.php');
?>