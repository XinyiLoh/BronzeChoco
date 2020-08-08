<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bronze Choco</title>

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


</head>

<body>

  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html"><img src="logo.png" width="30px" height="30px"> BRONZE CHOCO</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
           <form action="#">
              <input type="text" placeholder="Search.." name="search">
              <button class="btn-dark" type="submit"><i class="fa fa-search"></i></button>
          </form>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="about.html" style="color: black;">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html" style="color: black;">Contact</a>
          </li>
          <li class="nav-item active dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;">
              Chocolates
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
              <a class="dropdown-item" href="milk _chocolate.html" style="color: black;">1. Milk  Chocolates</a>
              <a class="dropdown-item" href="white_chocolate.html" style="color: black;">2. White Chocolates</a>
              <a class="dropdown-item" href="dark_chocolate.html" style="color: black;">3. Dark  Chocolates</a>
              
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;"><img src="user.png" width="25px" height="25px">
              
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
              <a class="dropdown-item" href="login.php">Login</a>
              <a class="dropdown-item" href="signup.php">Register</a>
              <a class="dropdown-item" href="#">Logout</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;"><img src="image/gift.png" height="30px" title="cart">
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
              <a class="dropdown-item" href="cart.html">Cart</a>
              <a class="dropdown-item" href="orderdetail.html">Order detail</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Login Here!</h3>
              <form>
                <div class="form-label-group">
                  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                  <label for="inputEmail">Email address</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Remember password</label>
                </div>
                <button class="btn btn-lg btn-warning btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign in</button>
                <div class="text-center">
                    <a class="small" href="signup.php">Register</a></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <!-- Footer -->
  <footer class="footer-custom">
    <div class="container">
      <p class="m-0 text-center text-black">Copyright &copy; Bronze Choco 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
