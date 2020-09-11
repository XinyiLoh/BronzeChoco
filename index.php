<?php 
session_start();
include('headerFooter/header.php'); 
?>

<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
         <!-- Slide 1 - Set the background image for this slide in the line below -->
         <div class="carousel-item" style="background-image: url('image/index.jpg')">
          <div class="carousel-caption d-none d-md-block">
            
            <p style="color:black;">WELCOME TO YOUR CHOCOLATE HEAVEN.</p>
            
          </div>
        </div>
        <!-- Slide 2 - Set the background image for this slide in the line below -->
        <div class="carousel-item active" style="background-image: url('image/slide1.jpg')">
          <div class="carousel-caption d-none d-md-block">
            
            <p>Introducing the award wining Milk Chocolates from Italy.</p>
          </div>
        </div>
        <!-- Slide 3 - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('image/slide2.jpg')">
          <div class="carousel-caption d-none d-md-block">
            
            <p style="color:black;">Sweden best selling White Chocolates.</p>
            
          </div>
        </div>
        <!-- Slide 4 - Set the background image for this slide in the line below -->
        <div class="carousel-item" style="background-image: url('image/slide3.jpg')">
          <div class="carousel-caption d-none d-md-block">
            <p style="color:white;">France best selling Dark Chocolates.</p>
            
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container">
      
      <?php    
        if(isset($_SESSION['status']) && $_SESSION['status'] != null){
            echo "<h3>'".$_SESSION['status']."'</h3>";
            unset($_SESSION['status']);
        }
      ?>

    <h1 class="my-4">Welcome to Bronze Choco</h1>

    <!-- Best Selling Chocolate Section -->
    <h2>Best Selling Chocolates</h2>

    <div class="row">
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="image/choc1.jpg" alt="Super Milky Chocolate"></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Super Milky Milk Chocolate</a>
            </h4>
            <p class="card-text">is a classic that we all know and love from childhood. With its light brown color, creamy texture, and sweet flavor, milk chocolate is widely regarded as the most popular type of chocolate. It is made by combining chocolate liquor (cocoa solids and cocoa butter) with sugar, and milk. </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="image/choc2.jpg" alt="Sweden White Chocolate"></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Sweden White Chocolate</a>
            </h4>
            <p class="card-text">is easy to identify because of its cream or ivory color. It is made by combining sugar, cocoa butter, milk, vanilla, and lecithin (an emulsifier that helps the ingredients blend together). These ingredients give white chocolate its sweet vanilla aroma.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="#"><img class="card-img-top" src="image/choc3.jpg" alt="Hello Dark Chocolate"></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="#">Hello Dark Chocolate</a>
            </h4>
            <p class="card-text">with its notable deep brown color, is the second most popular type of chocolate. It is sometimes referred to as black or semisweet chocolate and is noticeably less sweet than milk chocolate. Typically made from two ingredients, chocolate liquor and sugar. Sometimes small amounts of vanilla and soy lecithin. </p>
          </div>
        </div>
      </div>
      </div>
    </div>
    <!-- /.row -->

<?php include('headerFooter/footer.php'); ?>

