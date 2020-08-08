<?php
session_start();
include('includes/header.php'); 
?>

<?php
//if(isset($_POST['login_btn'])){
//    $email_login = trim($_POST['email']);
//    $pass_login = trim($_POST['password']);
//    
//    $query = "SELECT * FROM admin_info WHERE admin_email='$email_login' AND admin_pass='$pass_login'";
//    $query_run = mysqli_query($connection,$query);
//    
//    if(mysqli_fetch_array($query_run)){
//        $_SESSION['username'] = $email_login;
//        header('Location: index.php');
//    }else{
//        $_SESSION['status'] = 'Email address / Password is invalid';
//        header('Location: login.php');
//    }
//}
?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                    <?php
                    if(isset($_SESSION['status'])&& $_SESSION['status'] != ""){
                        echo '<h2 class="bg-danger text-white">'.$_SESSION['status'].'</h2>';
                        unset($_SESSION['status']);
                    }
                    ?>
                  </div>
                    <form class="user" action="code.php" method="POST">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                    </div>
                        <button type="submit" name="login_btn" class="btn btn-warning btn-user btn-block">Login</button>     
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

<?php
include('includes/scripts.php'); 
?>