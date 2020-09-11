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

if (isset($_POST['update_status'])) {
    $ordertID = $_POST['orderID'];

    foreach ($ordertID as $key) {
       
        $updateSQL = "UPDATE orders SET order_status='completed' WHERE order_id='".$key."'";
        $result = $connection->query($updateSQL);
        
        if (empty($result)) {
            $_SESSION['status'] = "Your Orders Status is NOT Updated";
            $_SESSION['status_code'] = "error";
        } else {
            $_SESSION['status'] = "Your Orders Status is Updated";
            $_SESSION['status_code'] = "success";
        }
    }
}

if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    
    $query = "DELETE FROM orders WHERE order_id='".$id."'";
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

<div class="container-fluid">
    
    <!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Order List</h6>
  </div>
    
    <div class="card-body">

    <div class="table-responsive">
    <form action="" method="post">
        
    <?php
                        
//    if (isset($_GET["page"])) {
//        $page = $_GET["page"];
//    } else {
//        $page = 1;
//    }
//    
//    $results_per_page = 5;
//    $start_from = ($page - 1) * $results_per_page;
    
//    $orderCondition = !empty($order) ? $order :"order_id";
    $query = "SELECT * FROM orders";
    //ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page;
    $query_run = mysqli_query($connection,$query);
    ?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th></th>
            <th><!--<a href="?order=order_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Order ID</th>
            <th><!--<a href="?order=user_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->User ID</th>
            <th><!--<a href="?order=amount&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Amount </th>
            <th><!--<a href="?order=payment_method&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Payment Method</th>
            <th><!--<a href="?order=shipping_city&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->City</th>
            <th><!--<a href="?order=shipping_address&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Address</th>
            <th><!--<a href="?order=order_date&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Order Date</th>
            <th><!--<a href="?order=order_status&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Order Status</th>
            <th>DELETE</th>
          </tr>
        </thead>
        
        <tbody>
        <?php
        if(mysqli_num_rows($query_run) > 0){
            while($row = mysqli_fetch_assoc($query_run)){
        ?>
            <tr>
            <td><?php echo "<input type='checkbox' name='orderID[]' value='".$row['order_id']."'/>";?></td>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td><?php echo $row['shipping_city']; ?></td>
            <td><?php echo $row['shipping_address']; ?></td>
            <td><?php echo $row['order_date'];?></td>
            <td><?php echo $row['order_status']; ?></td>

            <td>
                <input type="hidden" name="delete_id" value="<?php echo $row['order_id']?>" />
                <center><button type="submit" name="delete_btn" class="btn btn-danger btn-circle" onClick="javascript:return del()"><i class="fas fa-trash"></i></button></center>
            </td>
          </tr>
          <?php
        }
        }else{
            echo "No Record Found";
        }

//        $sql = "SELECT COUNT(order_id) AS total FROM orders";
//        $result = $connection->query($sql);
//        $row = $result->fetch_assoc();
//        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
//        echo "Page: ";
//        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
//            echo '<button class="btn btn-light">';
//            echo "<a href='order.php?page=" . $i . "'";
//            if ($i == $page) echo " class='curPage'";
//            echo ">" . $i . "</a> ";
//            echo '</button>';
//        };

        ?>
            <button type="submit" name="update_status" class="btn btn-dark" onclick="return confirm('This will update all the selected orders status. \nAre you sure?');">
                Update order status
            </button>
        </tbody>
      </table>
    </form>
    </div>
  </div>
</div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
