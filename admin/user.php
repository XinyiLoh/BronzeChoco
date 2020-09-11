<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
//global $order,$sort;
////Refers to which column to sort?
//$order = isset($_GET["order"]) ? $_GET["order"] : "";
//
////Refers to how to sort? ASC or DESC ?
//$sort = isset($_GET["sort"]) ? $_GET["sort"] : "";

if(isset($_POST['registerbtn'])) {

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
            $_SESSION['status'] = "New User Added";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "New User NOT Added";
            $_SESSION['status_code'] = "error";
        }
    }
}

if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    
    $query = "DELETE FROM user_info WHERE user_id='".$id."'";
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

<div class="modal fade" id="addcustomerprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="POST">
            <div class="modal-body">
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
                    <input type="email" name="userEmail" value="<?php if(isset($_POST['userEmail'])) echo trim($_POST['userEmail']);?>" maxlength="50" class="form-control" placeholder="bronze@example.com" required>
                </div>
                    <div class="form-group">
                      <label>Mobile</label>
                      <input type="tel" name="userMobile" value="<?php if(isset($_POST['userMobile'])) echo trim($_POST['userMobile']);?>" maxlength="20" class="form-control" placeholder="1234567890" required>
                  </div>
                <div class="form-group">
                      <label>Address</label>
                      <input type="text" name="userAddress" value="<?php if(isset($_POST['userAddress'])) echo trim($_POST['userAddress']);?>" maxlength="100" class="form-control" placeholder="No,01, Jalan Bronze, Taman Choco" required>
                  </div>
                <div class="form-group">
                      <label>States</label>
                      <input type="text" name="userState" value="<?php if(isset($_POST['userState'])) echo trim($_POST['userState']);?>" maxlength="60" class="form-control" placeholder="Wilayah Persekutuan" required>
                  </div>
                <div class="form-group">
                      <label>Zip Code</label> 
                      <input type="text" name="userZipcode" value="<?php if(isset($_POST['userZipcode'])) echo trim($_POST['userZipcode']);?>" maxlength="10"class="form-control" placeholder="50000" required>
                  </div>
                  <div class="form-group">
                      <label>City</label>
                      <input type="text" name="userCity" value="<?php if(isset($_POST['userCity'])) echo trim($_POST['userCity']);?>" maxlength="50" class="form-control" placeholder="Kuala Lumpur" required>
                  </div>
                <div class="form-group">
                      <label>Country</label>
                      <input type="text" name="userCountry" value="<?php if(isset($_POST['userCountry'])) echo trim($_POST['userCountry']);?>" maxlength="50" class="form-control" placeholder="Malaysia" required>
                  </div>
                <div class="form-group">
                    <label>Password</label>
                    <small>Must be between <b>6 and 20 digits long</b> and contain only <b>uppercase and lowercase alphabet, digit and underscore</b>.</small>
                    <input type="password" name="userPassword" maxlength="30" value="<?php if(isset($_POST['userPassword'])) echo trim($_POST['userPassword']);?>" class="form-control" placeholder="Enter Password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="userConfirmPassword" class="form-control" placeholder="Confirm Password" required>
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
    <h6 class="m-0 font-weight-bold text-primary">Customer List
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addcustomerprofile">
             Add Customer
            </button>
    </h6>
  </div>
    
  <div class="card-body">

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

    if (!empty($message)) {
                
        echo '<span class='.$type.'><small><ul>';
        foreach ($message as $value) {
          echo '<li>';
          echo $value;
          echo '</li>';
        }
        echo '</small></ul></span><br/>';
    }

//    $orderCondition = !empty($order) ? $order :"user_id";
    $query = "SELECT * FROM user_info";
    //ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page;

    $query_run = mysqli_query($connection,$query);
    
?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><!--<a href="?order=user_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->ID</th>
            <th><!--<a href="?order=first_name&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->First Name</th>
            <th><!--<a href="?order=last_name&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Last Name</th>
            <th><!--<a href="?order=email&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Email </th>
            <th><!--<a href="?order=password&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Password</th>
            <th><!--<a href="?order=phone&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Phone</th>
            <th><!--<a href="?order=address&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Address</th>
            <th><!--<a href="?order=address&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->State</th>
            <th><!--<a href="?order=address&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Zip Code</th>
            <th><!--<a href="?order=city&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->City</th>
            <th><!--<a href="?order=address&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Country</th>
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
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['state']; ?></td>
            <td><?php echo $row['zipcode']; ?></td>
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $row['country']; ?></td>
            
            <td>
                <form action="user_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['user_id']?>">
                    <center><button  type="submit" name="edit_btn" class="btn btn-info btn-circle"><i class="fas fa-info-circle"></i></button></center>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['user_id']?>">
                  <center><button type="submit" name="delete_btn" class="btn btn-danger btn-circle" onClick="javascript:return del()"><i class="fas fa-trash"></i></button></center>
                </form>
            </td>
          </tr>
          <?php
            }
        }else{
            echo "No Record Found";
        }
        
                
//        $sql = "SELECT COUNT(user_id) AS total FROM user_info";
//        $result = $connection->query($sql);
//        $row = $result->fetch_assoc();
//        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
//        echo "Page: ";
//        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
//            echo '<button class="btn btn-light">';
//            echo "<a href='user.php?page=" . $i . "'";
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
