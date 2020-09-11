<?php
//ob_start(); //start buffering the output
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

if(isset($_POST['save_product'])) {
    
   $message = array();
       
    $cat_id  = $_POST['category'];
    $title = trim($_POST['productTitle']);
    $price = number_format(trim($_POST['productPrice'],2));
    $desc = trim($_POST['productDescription']);
    $image = $_FILES['productImage']['name'];
    $stock = trim($_POST['productStock']);
    
    $temp = 'upload/' . $_FILES['productImage']['name'];
    $imageFileType = strtolower(pathinfo($temp,PATHINFO_EXTENSION));

    //check category
    if($cat_id == null || $cat_id == ""){
        array_push($message,"Please select a category.");
        $type = "error";
    }
    
    //check title
    if($title == null || $title == ""){
        array_push($message,"Please enter the title.");
        $type = "error";
    }

    //check price
    if($price  == null || $price == ""){
        array_push($message,"Please enter the price.");
        $type = "error";
    }elseif(!preg_match ("/^[0-9]+(\.[0-9]{2})?$/", $price)){
        array_push($message,"Invalid price format.");
        $type = "error";
    }
    
    //check description
    if($desc  == null || $desc  == ""){
        array_push($message,"Please enter the description.");
        $type = "error";
    }
    
    //check image
    if($image == null || $image  == ""){
        array_push($message,"Please upload the image.");
        $type = "error";
    }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
        array_push($message,"Only JPG, PNG and JPEG are allowed.");
        $type = "error";
    }elseif(file_exists($temp)){
        $store = $_FILES['productImage']['name'];
        array_push($message,"Image already exist $store.");
        $type = "error";
    }elseif($_FILES['productImage']["size"] > 500000){
        array_push($message,"Sorry, your file is too large.");
        $type = "error";
    }

    //check stock
    if($stock == null || $stock  == ""){
        array_push($message,"Please enter the stock.");
        $type = "error";
    }elseif(!preg_match ("/^[0-9]+$/",$stock)){
        array_push($message,"Please enter only number(s) for stock.");
        $type = "error";
    }
    

    if(empty($message)){
        
        $cat_id  = htmlspecialchars($cat_id);
        $title = htmlspecialchars($title);
        $price = htmlspecialchars($price);
        $desc = htmlspecialchars($desc);
//        $image = $_FILES['productImage']['name'];
        $stock = htmlspecialchars($stock);
        
        $query = "INSERT INTO product_info(cat_id,product_title,product_price,product_desc,product_image,product_stock) VALUES ('".$cat_id."','".$title."','".$price."','".$desc."','".$image."','".$stock."');";
        $query_run = mysqli_query($connection, $query);

       if($query_run){
           move_uploaded_file($_FILES['productImage']['tmp_name'],$temp);
           $_SESSION['status'] = "New Product Added";
           $_SESSION['status_code'] = "success";
       }else{
           $_SESSION['status'] = "New Product Not Added / Please select the category";
           $_SESSION['status_code'] = "error";
       }
        
    }
}

if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];
    
    $prod_query = "SELECT * FROM product_info WHERE product_id=".$id."";
    $prod_query_run = mysqli_query($connection,$prod_query);
    foreach ($prod_query_run as $prod_row) {

        if($img_path = 'upload/'.$prod_row['product_image']){
            unlink($img_path);
        }
    }
    
    $query = "DELETE FROM product_info WHERE product_id='$id'";
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

<div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="POST" enctype="multipart/form-data">

        <div class="modal-body">     

            <div class="form-group">
                <label>Category :</label>
                <select name="category">
                <option>Select one</option>
                <?php
                
                $q = "SELECT cat_id,cat_title FROM category";
                $r = mysqli_query($connection,$q);
                if (mysqli_num_rows($r) > 0) {
                    while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
                        echo "<option value=\"$row[0]\"";
                        if (isset($_POST['category']) && ($_POST['category'] == $row[0]) ) echo 'selected="selected"';
                        echo ">$row[1]</option>\n";
                    }
                }else{
                    echo '<option>Please add a new category first.</option>';
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label>Title :</label><input type="text" name="productTitle" size="30" maxlength="30" class="form-control" placeholder="Dark Choco" value="<?php if (isset($_POST['productName'])) echo htmlspecialchars($_POST['productName']); ?>" required>
            </div>
            <div class="form-group">
                <label>Price : </label><input type="text" name="productPrice" size="10" maxlength="10" class="form-control" value="<?php if(isset($_POST['price'])) echo number_format($_POST['price'],2) ?>" placeholder="Do not include the dollar sign or commas." required>
            </div>
            <div class="form-group">
                <label>Description :</label>
                <textarea name="productDescription" cols="50" rows="5"><?php if (isset($_POST['productDescription'])) echo $_POST['productDescription']; ?></textarea>
            </div>
            <div class="form-group">
                <label>Image :</label>
                <input type="file" name="productImage" id="productImage" accept = "image/*" required>
            </div>
            <div class="form-group">
                <label>Stock :</label><input type="text" name="productStock" size="10" maxlength="10" class="form-control" required>
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="save_product" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="container-fluid">

<!-- DataTables Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Product List
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addproduct">
             Add Product
            </button>
    </h6>
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
        echo '</small></ul></span><br/>';
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

//    $orderCondition = !empty($order) ? $order :"product_id";
    $query = "SELECT * FROM product_info"; //ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page
    $query_run = mysqli_query($connection,$query);
    ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><!--<a href="?order=product_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Product ID</th>
            <th><!--<a href="?order=cat_id&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Category ID</th>
            <th><!--<a href="?order=product_title&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Title </th>
            <th><!--<a href="?order=product_price&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Price(RM)</th>
            <th><!--<a href="?order=product_desc&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Description</th>
            <th><!--<a href="?order=product_image&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Image</th>
            <th><!--<a href="?order=product_stock&sort=<php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<php echo $page ?>">-->Stock</th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
            
        <?php
        $cat = array (
                    1 => "Milk",
                    2 => "Dark",
                    3 => "White"
                );

        if(mysqli_num_rows($query_run) > 0){
            while($row = mysqli_fetch_assoc($query_run)){
        ?>
            <tr>
            <td><?php echo $row['product_id']; ?></td>
            <td><?php echo $cat[$row['cat_id']]; ?></td>
            <td><?php echo $row['product_title']; ?></td>
            <td><?php echo number_format($row['product_price'],2);?></td>
            <td><?php echo $row['product_desc']; ?></td>
            <td><?php echo '<img src="upload/'.$row['product_image'].'" alt="Image" height="100px;" width="100px;" >'?></td>
            <td><?php echo $row['product_stock']; ?></td>
            <td>
                <form action="product_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['product_id']?>" />
                    <center><button  type="submit" name="edit_btn" class="btn btn-info btn-circle"><i class="fas fa-info-circle"></i></button></center>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['product_id']?>" />
                  <center><button type="submit" name="delete_btn" class="btn btn-danger btn-circle" onClick="javascript:return del()"><i class="fas fa-trash"></i></button></center>
                </form>
            </td>
          </tr>

          <?php
        }
        }else{
            echo "No Record Found";
        }
                        
//        $sql = "SELECT COUNT(product_id) AS total FROM product_info";
//        $result = $connection->query($sql);
//        $row = $result->fetch_assoc();
//        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
//        echo "Page: ";
//        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
//            echo '<button class="btn btn-light">';
//            echo "<a href='product.php?page=" . $i . "'";
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
