<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
$show=2;

if(isset($_POST['updatebtn'])){
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
       $id = $_POST['edit_id'];
    } else {
        echo "No User ID found</li>";
    }

    $firstname = trim($_POST['editUserFirstName']);
    $lastname = trim($_POST['editUserLastName']);
    $email = trim($_POST['editUserEmail']);
    $mobile = trim($_POST['editUserMobile']);
    $city = trim($_POST['editUserCity']);
    $address = trim($_POST['editUserAddress']);
    $password = trim($_POST['editUserPassword']);

    $updateSQL ="UPDATE user_info SET first_name='$firstname',last_name='$lastname',email='$email',password='$password',phone='$mobile',city='$city',address='$address' WHERE user_id='$id'; ";
    $selectSQL = "SELECT email FROM user_info WHERE user_id != ".$id." AND email = '".$email."'";
    $exist = $connection ->query($selectSQL);

    if($exist -> num_rows > 0){
        $_SESSION['notUpdated'] = "Email exist. Please try another.";
    }else{
        if (mysqli_query($connection,$updateSQL)) {
            $_SESSION['success'] = "Your Data is Updated";
            header('Location: user.php');
            echo "<script>window.location = 'user.php'</script>";
        }else {
            $_SESSION['notUpdated'] = "Your Data is NOT Updated";
            header('Location: user.php');
            echo "<script>window.location = 'user.php'</script>";
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
        if (isset($_SESSION['notUpdated']) && $_SESSION['notUpdated'] != '') {
            echo'<h2 class="bg-warning text-white">' . $_SESSION['notUpdated'] . '</h2>';
            unset($_SESSION['notUpdated']);
            $show = 1;
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
              <input type="text" name="editUserFirstName" maxlength="30" class="form-control" value="<?php echo $row['first_name'] ?>" required>
          </div>
          <div class="form-group">
              <label> User Last Name </label>
              <input type="text" name="editUserLastName" maxlength="30" class="form-control" value="<?php echo $row['last_name'] ?>" required>
          </div>
          <div class="form-group">
              <label>Email</label>
              <input type="email" name="editUserEmail" class="form-control" value="<?php echo $row['email'] ?>" required>
          </div>
          <div class="form-group">
              <label>Mobile</label>
              <input type="tel" name="editUserMobile" class="form-control" value="<?php echo $row['phone'] ?>"pattern="[0-9]{3}-[0-9]{7}" required>
          </div>
          <div class="form-group">
              <label>City</label>
              <input type="text" name="editUserCity" class="form-control" value="<?php echo $row['city'] ?>" pattern="/^[a-zA-Z\u0080-\u024F\s\/\-\)\(\`\.\"\']+$/" required>
          </div>
          <div class="form-group">
              <label>Address</label>
              <input type="text" name="editUserAddress" class="form-control"value="<?php echo $row['address'] ?>"required>
          </div>
          <div class="form-group">
              <label>Password</label>
              <small>Must be between 6 and 20 digits long and include at least one numeric digit, one lowercase characters,one uppercase characters.</small>
              <input type="password" name="editUserPassword" maxlength="30" class="form-control" value="<?php echo $row['password'] ?>" pattern="((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20})" required>
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