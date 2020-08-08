<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
$show=2;

if(isset($_POST['registerbtn'])) {

    $firstname = trim($_POST['userFirstName']);
    $lastname = trim($_POST['userLastName']);
    $email = trim($_POST['userEmail']);
    $mobile = trim($_POST['userMobile']);
    $city = trim($_POST['userCity']);
    $address = trim($_POST['userAddress']);
    $password = trim($_POST['userPassword']);
    $cpassword = trim($_POST['userConfirmPassword']);

    $selectSQL = "SELECT email FROM user_info WHERE email = '".$email."'";
    $result = $connection ->query($selectSQL);

    if($result -> num_rows > 0){
        $_SESSION['notAdded'] = "New User NOT Added. Email exist. Please try another.";
    }elseif($password !== $cpassword){
        $_SESSION['notAdded'] = "New User NOT Added. Comfirm password is incorrect.";    
    }else{
        $query = "INSERT INTO user_info(first_name,last_name,email,password,phone,city,address) VALUES ('$firstname','$lastname','$email','$password','$mobile','$city','$address')";
        $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                $_SESSION['success'] = "New User Added";
                header('Location: user.php');
                echo "<script>window.location = 'user.php'</script>";
            } else {
                $_SESSION['status'] = "New User NOT Added";
                header('Location: user.php');
                echo "<script>window.location = 'user.php'</script>";
            }
    }
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New User</h6>
        </div>

        <div class="card-body">
        <?php
        if (isset($_SESSION['notAdded']) && $_SESSION['notAdded'] != '') {
            echo'<h2 class="bg-warning text-white">' . $_SESSION['notAdded'] . '</h2>';
            unset($_SESSION['notAdded']);
            $show = 0;
        }
        
        if (isset($_POST['addNewUserbtn']) || $show === 0) {
        ?>
        <form action="" method="POST">
          
            <div class="form-group">
                <label> User First Name </label>
                <input type="text" name="userFirstName" value="<?php if(isset($_POST['userFirstName'])) echo trim($_POST['userFirstName']);?>" maxlength="30" class="form-control" placeholder="Bronze" required>
            </div>
          <div class="form-group">
                <label> User Last Name </label>
                <input type="text" name="userLastName" value="<?php if(isset($_POST['userLastName'])) echo trim($_POST['userLastName']);?>" maxlength="30" class="form-control" placeholder="Choco" required>
              </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo trim($_POST['userEmail']);?>" class="form-control" placeholder="bronze@example.com" required>
            </div>
                <div class="form-group">
                  <label>Mobile</label>
                  <input type="tel" name="userMobile" value="<?php if(isset($_POST['userMobile'])) echo trim($_POST['userMobile']);?>" class="form-control" placeholder="123-4567890" pattern="[0-9]{3}-[0-9]{7}" required>
              </div>
              <div class="form-group">
                  <label>City</label>
                  <input type="text" name="userCity" value="<?php if(isset($_POST['userCity'])) echo trim($_POST['userCity']);?>" class="form-control" placeholder="Kuala Lumpur, Malaysia" pattern="/^[a-zA-Z\u0080-\u024F\s\/\-\)\(\`\.\"\']+$/" required>
              </div>
              <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="userAddress" value="<?php if(isset($_POST['userAddress'])) echo trim($_POST['userAddress']);?>" class="form-control" placeholder="No,01, Jalan Bronze, Taman Choco 50000" required>
              </div>
            <div class="form-group">
                <label>Password</label>
                <small>Must be between 6 and 20 digits long and include at least one numeric digit, one lowercase characters,one uppercase characters.</small>
                <input type="password" name="userPassword" maxlength="30" value="<?php if(isset($_POST['userPassword'])) echo trim($_POST['userPassword']);?>" class="form-control" placeholder="Enter Password" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20})" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="userConfirmPassword" class="form-control" placeholder="Confirm Password" required>
            </div>

            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
            <a href="user.php" class="btn btn-danger">Cancel</a>
        </form>
        <?php
        }
        ?>
    </div>       
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>