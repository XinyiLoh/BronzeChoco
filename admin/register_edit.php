<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 

$str1 = $_SESSION['username'];
$str2 = "bronzechoco@mail.com";

if(strcmp($str1, $str2) != 0){
echo "<script>window.location = 'index.php'</script>";
}
?>

<?php
$show = 0;

if(isset($_POST['updatebtn'])){
    
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
       $id = $_POST['edit_id'];
    } else {
        $_SESSION['status'] = "No Admin ID found</li>";
        $_SESSION['status_code'] = "error";
    }

    $name = trim($_POST['edit_adminName']);
    $email = trim($_POST['edit_adminEmail']);
    $password = trim($_POST['edit_adminPassword']);
    
    if (empty($name) || empty($email) || empty($password)) {
        $message = "All field is required";
        $type = "error";
    }
 
    if(empty($message)){
        
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        
        $sql ="UPDATE admin_info SET admin_name='".$name."', admin_email='".$email."', admin_pass='".$password."' WHERE admin_id='".$id."'; ";
        $selectSQL = "SELECT admin_email FROM admin_info WHERE admin_id != '".$id."' AND admin_email = '".$email."'";
        $exist = $connection ->query($selectSQL);

        if(empty($name) || empty($email) || empty($password)){
            $message = " All field is required";
            $type = "error";
        }elseif($exist -> num_rows > 0){
            $message = "Email exist.";
            $type = "error";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = "Invalid User Email";
            $type = "error";
        }else{
            if (mysqli_query($connection, $sql)) {
                $_SESSION['status'] = 'Your Data is Updated';
                $_SESSION['status_code'] = "success";
//                header('Location: register.php');
//                echo "<script>window.location = 'register.php'</script>";
            }else {
                $_SESSION['status'] = 'Your Data is NOT Updated';
                $_SESSION['status_code'] = "error";
//                header('Location: register.php');
//                echo "<script>window.location = 'register.php'</script>";
            }
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

    if(isset($message)) { ?>
      <span class="message <?php echo $type; ?>"><small><?php echo $message; ?></small></span><br/><br/>
    <?php
    $show = 1;
    } 
    
    if (isset($_POST['edit_btn']) || $show == 1) {

    $id = $_POST['edit_id'];

    $result =mysqli_query($connection,"SELECT admin_name,admin_email,admin_pass FROM admin_info WHERE admin_id='$id'")or die("query 1 incorrect......");
    mysqli_fetch_array($result);
    
    foreach ($result as $row) {
    ?>
      <form action="" method="POST">
          
          <input type="hidden" name="edit_id" value="<?php echo $id;?>">
          
            <div class="form-group">
                <label>Admin Name</label>
                <input type="text" name="edit_adminName" value="<?php echo $row['admin_name'] ?>" maxlength="30" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="edit_adminEmail" value="<?php echo $row['admin_email'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="edit_adminPassword" value="<?php echo $row['admin_pass'] ?>" maxlength="30" class="form-control" required>
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