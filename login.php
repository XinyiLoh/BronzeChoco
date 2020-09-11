<?php 
session_start();
include('headerFooter/header.php'); 
include('config.php');
?>

<?php
if(isset($_POST['signin'])){
    $email_login = trim($_POST['login_email']);
    $pass_login = trim($_POST['login_password']);
    
    $query = "SELECT * FROM user_info WHERE email='$email_login' AND password='$pass_login'";
    $query_run = mysqli_query($connection,$query);
    $row = mysqli_fetch_assoc($query_run);
    
    if(mysqli_num_rows($query_run) > 0){
        $_SESSION['username'] = $row['first_name'];
        $_SESSION['status'] = 'Successfully Log In !';
        echo "<script>window.location = 'index.php'</script>";
//        header('Location: index.php');
    }else{
        $_SESSION['status'] = 'Email address / Password is invalid';
//        header('Location: login.php');
    }
}

if(isset($_POST['forgetpassword'])){
    $email_login = htmlspecialchars(trim($_POST['login_email']));
    
    if(empty($email_login)){
        echo '<script type="text/javascript">alert("Please fill in the email address!");</script>';  
    }else{
        
        $query = "SELECT * FROM user_info WHERE email='$email_login'";
        $query_run = mysqli_query($connection,$query);

        if(mysqli_num_rows($query_run) > 0){
            $row = mysqli_fetch_assoc($query_run);
            $to = $email_login;
            $email_subject = "Bronze Choco Forgot Password";
            $email_body = "This is your account password : ".$row['password']."\n".
                    "If you need any assistance, you may send us a message at http://localhost/BronzeChoco/contact.php";
            $headers = "From: lohxy-wm19@student.tarc.edu.my";
            
            if(mail($to,$email_subject,$email_body,$headers) === true){
                echo '<script type="text/javascript">alert("Email Sent! Check your inbox!");</script>';   
            }else{
                echo '<script type="text/javascript">alert("Email Failed. Please try again later.");</script>';
            }
        }else{
            echo '<script type="text/javascript">alert("You havent set up an account!");</script>';
//            $_SESSION['status'] = "You haven't set up an account!";
        }
        
    }
}
?>

<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Login Here!</h3>
              <?php
              if (isset($_SESSION['status']) && $_SESSION['status'] != null) {
                  echo "<h3>" . $_SESSION['status'] . "</h3>";
                  unset($_SESSION['status']);
              }
              ?>
              <form method="POST">
                <div class="form-label-group">
                    <input type="email" id="inputEmail" name="login_email" class="form-control" placeholder="Email address" autofocus>
                  <label for="inputEmail">Email address</label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="inputPassword" name="login_password" class="form-control" placeholder="Password" >
                  <label for="inputPassword">Password</label>
                </div>

                <button class="btn btn-lg btn-warning btn-block btn-login text-uppercase font-weight-bold mb-2" name="signin" type="submit">Sign in</button>
                <button class="btn btn-lg btn-danger btn-block btn-login text-uppercase font-weight-bold mb-2" name="forgetpassword" type="submit" >Forget Password</button>
                
                <div class="text-center">
                <a class="small" href="signup.php">Haven't set up an account? Register Here !</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include('headerFooter/footer.php'); ?>