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
//    global $order,$sort;
//    //Refers to which column to sort?
//    $order = isset($_GET["order"]) ? $_GET["order"] : "";
//
//    //Refers to how to sort? ASC or DESC ?
//    $sort = isset($_GET["sort"]) ? $_GET["sort"] : "";
    
if(isset($_POST['registerbtn'])) {

    $name = trim($_POST['adminName']);
    $email = trim($_POST['adminEmail']);
    $password = trim($_POST['adminPassword']);
    $cpassword = trim($_POST['adminConfirmPassword']);
    
    if (empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        $message = "All field is required.";
        $type = "error";
    }

    if(empty($message)){
        
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $cpassword = htmlspecialchars($cpassword);
    
        $selectSQL = "SELECT admin_email FROM admin_info WHERE admin_email = '".$email."'";
        $result = $connection ->query($selectSQL);

        if($result -> num_rows > 0){
            $message = "Email exist. Please try another.";
            $type = "error";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $message = "Invalid User Email.";
            $type = "error";
        }elseif($password !== $cpassword){
            $message = 'Passwords should be same.<br>';
            $type = "error";
        }else{
            $query = "INSERT INTO admin_info(admin_name,admin_email,admin_pass) VALUES ('".$name."','".$email."','".$password."')";
            $query_run = mysqli_query($connection, $query);

                if ($query_run) {
                    $_SESSION['status'] = "New Admin Added";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "New Admin NOT Added";
                    $_SESSION['status_code'] = "error";
                }
        }
    }
    
}

if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    
    $query = "DELETE FROM admin_info WHERE admin_id='$id'";
    $query_run = mysqli_query($connection,$query);
    
    if($query_run){
        $_SESSION['status'] = "Your Data is DELETED";  
        $_SESSION['status_code'] = "success";
    }else{
        $_SESSION['status'] = "Your Data is NOT DELETED";
        $_SESSION['status_code'] = "error";
    }
}
?>

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Admin </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Admin Name </label>
                <input type="text" name="adminName" maxlength="30" class="form-control" placeholder="Bronze Choco" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="adminEmail" class="form-control" placeholder="bronze@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="adminPassword" maxlength="30" class="form-control" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="adminConfirmPassword" class="form-control" placeholder="Confirm Password" required>
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="container-fluid">

<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Admin List
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addadminprofile">
             Add Admin
            </button>
    </h6>
  </div>
    
  <div class="card-body">
      
    <?php      
    if (isset($message)) { ?>
        <span class="message <?php echo $type; ?>"><small><?php echo $message; ?></small></span><br/>
    <?php
    }
    ?>

    <div class="table-responsive">
        
    <?php
            
//    if (isset($_GET["page"])) {
//        $page = $_GET["page"];
//    } else {
//        $page = 1;
//    }
//    
//    $results_per_page = 5;
//    $start_from = ($page - 1) * $results_per_page;
      
//    $orderCondition = !empty($order) ? $order :"admin_id";
    $query = "SELECT * FROM admin_info";
    //ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page;
    $query_run = mysqli_query($connection,$query);

    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><!--<a href="?order=admin_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->ID</a></th>
            <th><!--<a href="?order=admin_name&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Admin</a></th>
            <th><!--<a href="?order=admin_email&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo$page ?>">-->Email </a></th>
            <th><!--<a href="?order=admin_pass&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Password</a></th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
            
        <?php
        if(mysqli_num_rows($query_run) > 0){
            while($row = mysqli_fetch_assoc($query_run)){
            ?>
            <tr>
            <td><?php echo $row['admin_id']; ?></td>
            <td><?php echo $row['admin_name']; ?></td>
            <td><?php echo $row['admin_email']; ?></td>
            <td><?php echo $row['admin_pass']; ?></td>
            <td>
                <form action="register_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['admin_id']?>">
                    <center><button  type="submit" name="edit_btn" class="btn btn-info btn-circle"><i class="fas fa-info-circle"></i></button></center>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['admin_id']?>">
                  <center><button type="submit" name="delete_btn" class="btn btn-danger btn-circle" onClick="javascript:return del()"><i class="fas fa-trash"></i></button></center>
                </form>
            </td>
          </tr>
          <?php
            }
        }else{
            echo "No Record Found";
        }
        
//        $sql = "SELECT COUNT(admin_id) AS total FROM admin_info";
//        $result = $connection->query($sql);
//        $row = $result->fetch_assoc();
//        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
//        echo "Page: ";
//        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
//            echo '<button class="btn btn-light">';
//            echo "<a href='register.php?page=" . $i . "'";
//            if ($i == $page) echo " class='curPage'";
//            echo ">" . $i . "</a> ";
//            echo '</button>';
//        };
        ?>

        </tbody>
      </table>

    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>