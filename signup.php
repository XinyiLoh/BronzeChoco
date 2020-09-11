<?php 
session_start();
include('headerFooter/header.php'); 
include('config.php');
?>

<?php
if(isset($_POST['signup'])) {
    $message = array();
    
    $firstname = trim($_POST['userFirstName']);
    $lastname = trim($_POST['userLastName']);
    $email = trim($_POST['userEmail']);
    $mobile = trim($_POST['userMobile']);
    $address = trim($_POST['userAddress']);
    $state = trim($_POST['userState']);
    $zipcode = trim($_POST['userZipcode']);
    $city = trim($_POST['userCity']);
    $country = trim($_POST['userCountry']);
    $password = trim($_POST['userPassword']);
    $cpassword = trim($_POST['userConfirmPassword']);

    //check name
    if($firstname === null || $firstname === "" || $lastname === null || $lastname === ""){
        array_push($message,"Please enter the name.");
        $type = "error";
    }elseif (!preg_match("/^[a-zA-Z]+$/",$firstname)){
        array_push($message,"Please enter valid firstname.");
        $type = "error";
    }elseif(!preg_match("/^[a-zA-Z]+$/",$lastname)){
        array_push($message,"Please enter valid lastname.");
        $type = "error";
    }
    
    //check email
    $selectSQL = "SELECT email FROM user_info WHERE email = '".$email."'";
    $result = $connection ->query($selectSQL);
        
    if($result->num_rows > 0){
        array_push($message,"Email exist. Please try another.");
        $type = "error";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($message,"Invalid User Email.");
        $type = "error";
    }
    
    //check phone no.
    if($mobile == null || $mobile == ""){
        array_push($message,"Please enter mobile number.");
        $type = "error";
    }elseif(!preg_match("/^[0-9]{10}$/", $mobile)){
        array_push($message,"Invalid Mobile number.");
        $type = "error";
    }
    
    //check address
    if($address == null || $address == ""){
        array_push($message,"Please enter adress.");
        $type = "error";
    }elseif(!preg_match("/^[0-9a-zA-Z\,\/\s\.]*$/", $address)){
        array_push($message,"Invalid Address.");
        $type = "error";
    }
    
    //check state
    if($state == null || $state == ""){
        array_push($message,"Please enter state.");
        $type = "error";
    }elseif(!preg_match("/^[a-zA-Z]+[\s]*[a-zA-Z]+$/", $state)){
        array_push($message,"Invalid State.");
        $type = "error";
    }
    
    //check zipcode
    if($zipcode == null || $zipcode == ""){
        array_push($message,"Please enter zipcode.");
        $type = "error";
    }elseif(!preg_match("/^[0-9]{5,10}$/", $zipcode)){
        array_push($message,"Invalid Zipcode.");
        $type = "error";
    }
    
    //check city
    if($city == null || $city == ""){
        array_push($message,"Please enter city.");
        $type = "error";
    }elseif(!preg_match("/^[a-zA-Z]+[a-zA-Z\s]*$/", $city)){
        array_push($message,"Invalid City.");
        $type = "error";
    }
    
    //check country
    if($country == null || $country == ""){
        array_push($message,"Please enter adress.");
        $type = "error";
    }elseif(!preg_match("/^[a-zA-Z]+[a-zA-Z\s]*$/", $country)){
        array_push($message,"Invalid Country.");
        $type = "error";
    }
    
    //check password
    if($password !== $cpassword){
        array_push($message,"Passwords should be same.");
        $type = "error";
    }elseif(!preg_match("/[0-9a-zA-Z_]+/",$password)){
        array_push($message,"Invalid Paassword Format.");
        $type = "error";
    }elseif(strlen($password) < 6 || strlen($password) > 20){
        array_push($message,"Password must be between 6 and 20 digits long ");
        $type = "error";
    }

    if(empty($message)){
        
        $firstname = htmlspecialchars($firstname);
        $lastname = htmlspecialchars($lastname);
        $email = htmlspecialchars($email);
        $mobile = htmlspecialchars($mobile);
        $address = htmlspecialchars($address);
        $state = htmlspecialchars($state);
        $zipcode = htmlspecialchars($zipcode);
        $city = htmlspecialchars($city);
        $country = htmlspecialchars($country);
        $password = htmlspecialchars($password);
        $cpassword = htmlspecialchars($cpassword);
        
        $query = "INSERT INTO user_info(first_name,last_name,email,password,phone,address,state,zipcode,city,country) VALUES ('".$firstname."','".$lastname."','".$email."','".$password."','".$mobile."','".$address."','".$state."','".$zipcode."','".$city."','".$country."')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $_SESSION['status'] = "Registered. Please login with account created just now.";
//            header('Location:login.php');
            echo "<script>window.location = 'login.php'</script>";
        } else {
            $_SESSION['status'] = "Something went wrong, failed to sign up :-( ";
//            header('Location:index.php');
            echo "<script>window.location = 'index.php'</script>";
        }
    }
}
?>

    <div class="container-fluid" id="signupimage" style="background-image:url('image/signup.jpg')";>
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <?php
            if (!empty($message)) {
                echo '<span class=' . $type . '><small><ul>';
                foreach ($message as $value) {
                    echo '<li>';
                    echo $value;
                    echo '</li>';
                }
                echo '</small></ul></span><br/>';
            }
            ?>
                <form action="" method="POST" class="form-signin">

                    <div class="modal-body">
                        <div class="form-group">
                            <label> User First Name </label>
                            <input type="text" name="userFirstName" value="<?php if (isset($_POST['userFirstName'])) echo trim($_POST['userFirstName']); ?>" maxlength="30" class="form-control" placeholder="Bronze" required>
                        </div>
                        <div class="form-group">
                            <label> User Last Name </label>
                            <input type="text" name="userLastName" value="<?php if (isset($_POST['userLastName'])) echo trim($_POST['userLastName']); ?>" maxlength="30" class="form-control" placeholder="Choco" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="userEmail" value="<?php if (isset($_POST['userEmail'])) echo trim($_POST['userEmail']); ?>" maxlength="50" class="form-control" placeholder="bronze@example.com" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="tel" name="userMobile" value="<?php if (isset($_POST['userMobile'])) echo trim($_POST['userMobile']); ?>" maxlength="20" class="form-control" placeholder="1234567890" required>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="userAddress" value="<?php if (isset($_POST['userAddress'])) echo trim($_POST['userAddress']); ?>" maxlength="100" class="form-control" placeholder="No,01, Jalan Bronze, Taman Choco" required>
                        </div>
                        <div class="form-group">
                            <label>States</label>
                            <input type="text" name="userState" value="<?php if (isset($_POST['userState'])) echo trim($_POST['userState']); ?>" maxlength="60" class="form-control" placeholder="Wilayah Persekutuan" required>
                        </div>
                        <div class="form-group">
                            <label>Zip Code</label> 
                            <input type="text" name="userZipcode" value="<?php if (isset($_POST['userZipcode'])) echo trim($_POST['userZipcode']); ?>" maxlength="10"class="form-control" placeholder="50000" required>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="userCity" value="<?php if (isset($_POST['userCity'])) echo trim($_POST['userCity']); ?>" maxlength="50" class="form-control" placeholder="Kuala Lumpur" required>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="userCountry" value="<?php if (isset($_POST['userCountry'])) echo trim($_POST['userCountry']); ?>" maxlength="50" class="form-control" placeholder="Malaysia" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <small>Must be between <b>6 and 20 digits long</b> and contain only <b>uppercase and lowercase alphabet, digit and underscore</b>.</small>
                            <input type="password" name="userPassword" maxlength="30" value="<?php if (isset($_POST['userPassword'])) echo trim($_POST['userPassword']); ?>" class="form-control" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="userConfirmPassword" class="form-control" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <button class="btn btn-lg btn-warning btn-block btn-login text-uppercase font-weight-bold mb-2" name="signup" type="submit">Sign Up</button>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php include('headerFooter/footer.php'); ?>