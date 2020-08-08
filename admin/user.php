<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php
global $order,$sort;
//Refers to which column to sort?
$order = isset($_GET["order"]) ? $_GET["order"] : "";

//Refers to how to sort? ASC or DESC ?
$sort = isset($_GET["sort"]) ? $_GET["sort"] : "";
    
if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    
    $query = "DELETE FROM user_info WHERE user_id='$id'";
    $query_run = mysqli_query($connection,$query);
    
    if($query_run){
        $_SESSION['success'] = "Your Data is DELETED";  
    }else{
        $_SESSION['status'] = "Your Data is NOT DELETED";
    }
}
?>

<div class="container-fluid">

<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
      <form action="user_new.php" method="post">
    <h6 class="m-0 font-weight-bold text-primary">User List
            <button type="submit" class="btn btn-dark" name="addNewUserbtn" >
                Add User
            </button>
        </form>
    </h6>
  </div>
    
  <div class="card-body">
      
    <?php
    if(isset($_SESSION['success'])&& $_SESSION['success'] != ''){
        echo'<h2 class="bg-success text-white">'.$_SESSION['success'].'</h2>';
        unset($_SESSION['success']);
    }
    
    if(isset($_SESSION['status'])&& $_SESSION['status'] != ''){
        echo'<h2 class="bg-warning text-white">'.$_SESSION['status'].'</h2>';
        unset($_SESSION['status']);
    }
    ?>

    <div class="table-responsive">
        
    <?php
                
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    
    $results_per_page = 5;
    $start_from = ($page - 1) * $results_per_page;

    $orderCondition = !empty($order) ? $order :"user_id";
    $query = "SELECT * FROM user_info ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page;

    $query_run = mysqli_query($connection,$query);
    ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><a href="?order=user_id&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">ID</th>
            <th><a href="?order=first_name&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">First Name</th>
            <th><a href="?order=last_name&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Last Name</th>
            <th><a href="?order=email&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Email </th>
            <th><a href="?order=password&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Password</th>
            <th><a href="?order=phone&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Phone</th>
            <th><a href="?order=city&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">City</th>
            <th><a href="?order=address&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Address</th>
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
            <td><?php echo $row['city']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
                <form action="user_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['user_id']?>">
                    <button  type="submit" name="edit_btn" class="btn btn-info">EDIT</button>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['user_id']?>">
                  <button type="submit" name="delete_btn" class="btn btn-danger" onClick="javascript:return del()"> DELETE</button>
                </form>
            </td>
          </tr>
          <?php
            }
        }else{
            echo "No Record Found";
        }
        
                
        $sql = "SELECT COUNT(user_id) AS total FROM user_info";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
        echo "Page: ";
        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
            echo '<button class="btn btn-light">';
            echo "<a href='user.php?page=" . $i . "'";
            if ($i == $page) echo " class='curPage'";
            echo ">" . $i . "</a> ";
            echo '</button>';
        };
        
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