<?php
include('security.php');

if(isset($_POST['login_btn'])){
    $email_login = trim($_POST['email']);
    $pass_login = trim($_POST['password']);
    
    $query = "SELECT * FROM admin_info WHERE admin_email='$email_login' AND admin_pass='$pass_login'";
    $query_run = mysqli_query($connection,$query);
    
    if(mysqli_fetch_array($query_run)){
        $_SESSION['username'] = $email_login;
        header('Location: index.php');
    }else{
        $_SESSION['status'] = 'Email address / Password is invalid';
        $_SESSION['status_code'] = "warning";
        header('Location: login.php');
    }
}

?>
