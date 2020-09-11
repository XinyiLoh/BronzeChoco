<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bronze Choco</title>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/login.css" rel="stylesheet">
  <link href="css/cart.css" rel="stylesheet">

  <style> 
    /* Modify the background color */ 
      
    .navbar-custom { 
        background-color: rgb(233, 205, 171); 
    } 
    /* Modify brand and text color */ 
      
    .navbar-custom .navbar-brand, 
    .navbar-custom .navbar-text { 
        color: black; 
    } 

    .footer-custom{
      background-color: rgb(233, 205, 171); 
      border-top:     20px solid rgb(233, 205, 171) ;
      border-bottom:     20px solid rgb(233, 205, 171) ;
    }
    
    .card{
        border: 4px solid  ;
        outline: none;
        border-color: rgb(233, 205, 171);
        box-shadow: 0 0 20px brown;
    }
</style> 

<script type="text/javascript">  
    function openulr(newurl) {  
        if (confirm("Are you sure you want to logout?")) 
        {    document.location = newurl;  }
    }
</script>

<script>
$(document).ready(function(){

 load_data();

 function load_data(query){
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{query:query},
   success:function(data){
    $('#result').html(data);
   }
  });
 }
 
 $('#search_text').keyup(function(){
  var search = $(this).val();
  if(search != ''){
   load_data(search);
  }else{
   load_data();
  }
 });
});
</script>

</head>

<body>
    
    <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src="image/logo.png" width="30px" height="30px"> BRONZE CHOCO</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
        <a class="nav-link" href="searchProducts.php" style="color: black;"><i class="fas fa-search"></i>&nbsp;Search Chocolate</a>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="about.php" style="color: black;">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php" style="color: black;">Contact</a>
          </li>
          <li class="nav-item active dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;">
              Chocolates
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
              <a class="dropdown-item" href="milk_chocolate.php" style="color: black;">1. Milk  Chocolates</a>
              <a class="dropdown-item" href="white_chocolate.php" style="color: black;">2. White Chocolates</a>
              <a class="dropdown-item" href="dark_chocolate.php" style="color: black;">3. Dark  Chocolates</a>
              
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;"><img src="image/user.png" width="25px" height="25px">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                <?php
                if(empty($_SESSION['username'])){
                    echo '<a class="dropdown-item" href="login.php">Login</a>';
                    echo '<a class="dropdown-item" href="signup.php">Register</a>';
                }else{
                    echo '<a class="dropdown-item">'.$_SESSION['username'].'</a>';
                    ?>
                    <a class="dropdown-item" href="javascript:openulr('logout.php');" >Logout</a>
                    <?php
                    }
                    ?>  
                <!--'alert("Are you sure you want to log out?");'-->
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;"><img src="image/gift.png" height="30px" title="cart">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
              <a class="dropdown-item" href="cart.php">Cart</a>
              <a class="dropdown-item" href="orderdetail.php">Order detail</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
