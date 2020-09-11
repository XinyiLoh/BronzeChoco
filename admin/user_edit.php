<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
  
<?php
$show=2;

if(isset($_POST['updatebtn'])){
    
    $message = array();
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
       $id = $_POST['edit_id'];
    } else {
        $_SESSION['status'] = "No User ID found</li>";
        $_SESSION['status_code'] = "error";
    }

    $firstname = trim($_POST['editUserFirstName']);
    $lastname = trim($_POST['editUserLastName']);
    $email = trim($_POST['editUserEmail']);
    $mobile = trim($_POST['editUserMobile']);
    $address = trim($_POST['editUserAddress']);
    $state = trim($_POST['editUserState']);
    $zipcode = trim($_POST['editUserZipcode']);
    $city = trim($_POST['editUserCity']);
    $country = trim($_POST['editUserCountry']);
    $password = trim($_POST['editUserPassword']);
    
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
    $selectSQL = "SELECT email FROM user_info WHERE user_id != ".$id." AND email = '".$email."'";
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
        array_push($message,"Invalid Mobile number..");
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
    if(!preg_match("/[0-9a-zA-Z_]+/",$password)){
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

        $updateSQL ="UPDATE user_info SET first_name='$firstname',last_name='$lastname',email='$email',password='$password',phone='$mobile',address='$address',state='$state',zipcode='$zipcode',city='$city',country='$country' WHERE user_id='$id'; ";
        $query_run = mysqli_query($connection, $updateSQL);

        if ($query_run) {
            $_SESSION['status'] = "Your Data is Updated";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "Your Data is NOT Updated";
            $_SESSION['status_code'] = "error";
        }
    }
   
}

?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User info</h6>
        </div>
            
        <div class="card-body">
        
        <?php
        
    if (!empty($message)) {
        
        echo '<span class='.$type.'><small><ul>';
        foreach ($message as $value) {
              echo '<li>';
              echo $value;
              echo '</li>';
        }
        $show = 1;
        echo '</small></ul></span><br/><br/>';
    }

    if (isset($_POST['edit_btn']) || $show === 1) {
    
        $id = $_POST['edit_id'];

        $result =mysqli_query($connection,"SELECT * FROM user_info WHERE user_id='$id'")or die("query 1 incorrect......");
        mysqli_fetch_array($result);

        foreach ($result as $row) {
        ?>
      <form action="" method="POST">
          
          <input type="hidden" name="edit_id" value="<?php echo $id;?>">

          <div class="form-group">
              <label> User First Name </label>
              <input type="text" name="editUserFirstName" maxlength="30" class="form-control" value="<?php echo $row['first_name'] ?>" maxlength="30" required>
          </div>
          <div class="form-group">
              <label> User Last Name </label>
              <input type="text" name="editUserLastName" maxlength="30" class="form-control" value="<?php echo $row['last_name'] ?>" maxlength="30" required>
          </div>
          <div class="form-group">
              <label>Email</label>
              <input type="email" name="editUserEmail" class="form-control" value="<?php echo $row['email'] ?>" maxlength="50" size="50" required>
          </div>
          <div class="form-group">
              <label>Mobile</label>
              <input type="tel" name="editUserMobile" class="form-control" value="<?php echo $row['phone'] ?>" maxlength="20"size="20" required>
          </div>
          <div class="form-group">
              <label>Address</label>
              <input type="text" name="editUserAddress" class="form-control"value="<?php echo $row['address'] ?>" maxlength="100" required>
          </div>
          <div class="form-group">
              <label for="editUserState">State</label>
              <input type="text" name="editUserState" class="form-control" value="<?php echo $row['state'] ?>" maxlength="50" size="50" required>
          </div>
          <div class="form-group">
              <label for="editUserZipcode">Zip Code</label>
              <input type="text" name="editUserZipcode" class="form-control" value="<?php echo $row['zipcode'] ?>" maxlength="10" size="10" required>
          </div>
          <div class="form-group">
              <label>City</label>
              <input type="text" name="editUserCity" class="form-control" value="<?php echo $row['city'] ?>" maxlength="50" required>
          </div>
          <div class="form-group">
              <label>Country</label>
              <input type="text" name="editUserCountry" class="form-control" value="<?php echo $row['country'] ?>" maxlength="50" size="30" required>
          </div>
          <div class="form-group">
              <label>Password</label>
              <small>Must be between 6 and 20 digits long and contain only <b>uppercase and lowercase alphabet, digit and underscore</b>.</small>
              <input type="password" name="editUserPassword" maxlength="30" class="form-control" value="<?php echo $row['password'] ?>" required>
          </div>

            <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
            <a href="user.php" class="btn btn-danger">Cancel</a>
      </form>
    <?php
    }
    }
    ?>
    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>