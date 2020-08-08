<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
$show = 0;

if(isset($_POST['updatebtn'])){
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
       $id = $_POST['edit_id'];
    } else {
        echo "No Admin ID found</li>";
    }

    $name = trim($_POST['edit_adminName']);
    $email = trim($_POST['edit_adminEmail']);
    $password = trim($_POST['edit_adminPassword']);
    
    $sql ="UPDATE admin_info SET admin_name='$name', admin_email='$email', admin_pass='$password' WHERE admin_id='$id'; ";
    $selectSQL = "SELECT admin_email FROM admin_info WHERE admin_id != ".$id." AND admin_email = '".$email."'";
    $exist = $connection ->query($selectSQL);
    
    if($exist -> num_rows > 0){
        $_SESSION['notUpdated'] = "Email exist. Please try another.";
    }elseif(empty($id) || empty($name) || empty($email) || empty($password)){
        $_SESSION['notUpdated'] = "Please fill in all data";
    }else{
        if (mysqli_query($connection, $sql)) {
            $_SESSION['success'] = "Your Data is Updated";
            header('Location: register.php');
            echo "<script>window.location = 'register.php'</script>";
        }else {
            $_SESSION['notUpdated'] = "Your Data is NOT Updated";
            header('Location: register.php');
            echo "<script>window.location = 'register.php'</script>";
        }
    }
}
?>

<div class="container-fluid">
    
<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Admin List</h6>
  </div>
    
  <div class="card-body">

    <?php

    if(isset($_SESSION['notUpdated'])&& $_SESSION['notUpdated'] != ''){
        echo'<h2 class="bg-warning text-white">'.$_SESSION['notUpdated'].'</h2>';
        unset($_SESSION['notUpdated']);
        $show = 0;
    }
    
    if (isset($_POST['edit_btn']) || $show === 0) {

    $id = $_POST['edit_id'];

    $result =mysqli_query($connection,"SELECT admin_name,admin_email,admin_pass FROM admin_info WHERE admin_id='$id'")or die("query 1 incorrect......");
    mysqli_fetch_array($result);
    
    foreach ($result as $row) {
    ?>
      <form action="" method="POST">
          
          <input type="hidden" name="edit_id" value="<?php echo $id;?>">
          
            <div class="form-group">
                <label>Admin Name</label>
                <input type="text" name="edit_adminName" value="<?php echo $row['admin_name'] ?>" maxlength="30" class="form-control">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="edit_adminEmail" value="<?php echo $row['admin_email'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="edit_adminPassword" value="<?php echo $row['admin_pass'] ?>" maxlength="30" class="form-control">
            </div>

            <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
            <a href="register.php" class="btn btn-danger">Cancel</a>
      </form>
    <?php
    }
    }
    ?>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>