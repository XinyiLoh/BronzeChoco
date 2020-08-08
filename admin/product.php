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

if(isset($_POST['save_product'])) {
    $cat_id  = $_POST['category'];
    $title = trim($_POST['productTitle']);
    $price = number_format(trim($_POST['productPrice'],2));
    $desc = trim($_POST['productDescription']);
    $image = $_FILES['productImage']['name'];
    $stock = trim($_POST['productStock']);
    
    $temp = 'upload/' . $_FILES['productImage']['name'];
    
    $validate_img_extension = $_FILES['productImage']['type'] == "image/jpg" ||
        $_FILES['productImage']['type'] == "image/png" ||
        $_FILES['productImage']['type'] == "image/jpeg"
    ;

    if ($validate_img_extension) {
            
        if(file_exists($temp)){

            $store = $_FILES['productImage']['name'];
            $_SESSION['status'] = "Image already exist $store";

        }elseif(!preg_match ("/^[0-9]+(\.[0-9]{2})?$/", $price) || !preg_match ("/^[0-9]+$/",$stock)){

            if(!preg_match ("/^[0-9]+(\.[0-9]{2})?$/", $price)){
                $_SESSION['status'] = "Price format invalid";
            }else{
                $_SESSION['status'] = "Stock format invalid";
            }
            
        }else{
            $query = "INSERT INTO product_info(cat_id,product_title,product_price,product_desc,product_image,product_stock) VALUES ('$cat_id','$title','$price','$desc','$image','$stock');";
            $query_run = mysqli_query($connection, $query);

           if($query_run){
               move_uploaded_file($_FILES['productImage']['tmp_name'],$temp);
               $_SESSION['success'] = "New Product Added";
           }else{
               $_SESSION['status'] = "New Product Not Added / Please select the category";
           }

        }
        
    }else{
        $_SESSION['status'] = "Only JPG, PNG and JPEG are allowed.";
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
        $_SESSION['success'] = "Your Data is DELETED";  
    }else{
        $_SESSION['status'] = "Your Data is NOT DELETED";
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
                <input type="file" name="productImage" id="productImage" accept = "image/png, image/jpeg, image/jpg" required>
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

    $orderCondition = !empty($order) ? $order :"product_id";
    $query = "SELECT * FROM product_info ORDER BY $orderCondition $sort LIMIT $start_from,". $results_per_page;
    $query_run = mysqli_query($connection,$query);
    ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th><a href="?order=product_id&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Product ID</th>
            <th><a href="?order=cat_id&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Category ID</th>
            <th><a href="?order=product_title&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Title </th>
            <th><a href="?order=product_price&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Price</th>
            <th><a href="?order=product_desc&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Description</th>
            <th><a href="?order=product_image&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Image</th>
            <th><a href="?order=product_stock&sort=<?php $sort; echo $sort === "ASC" ? "DESC":"ASC" ?>&page=<?php echo $page ?>">Stock</th>
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
            <td><?php echo $row['product_id']; ?></td>
            <td><?php echo $row['cat_id']; ?></td>
            <td><?php echo $row['product_title']; ?></td>
            <td><?php echo number_format($row['product_price'],2);?></td>
            <td><?php echo $row['product_desc']; ?></td>
            <td><?php echo '<img src="upload/'.$row['product_image'].'" alt="Image" height="100px;" width="100px;" >'?></td>
            <td><?php echo $row['product_stock']; ?></td>
            <td>
                <form action="product_edit.php" method="post">
                    <input type="hidden" name="edit_id" value="<?php echo $row['product_id']?>" />
                    <button  type="submit" name="edit_btn" class="btn btn-info">EDIT</button>
                </form>
            </td>
            <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['product_id']?>" />
                  <button type="submit" name="delete_btn" class="btn btn-danger" onClick="javascript:return del()"> DELETE</button>
                </form>
            </td>
          </tr>
          <?php
        }
        }else{
            echo "No Record Found";
        }
                        
        $sql = "SELECT COUNT(product_id) AS total FROM product_info";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
        echo "Page: ";
        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
            echo '<button class="btn btn-light">';
            echo "<a href='product.php?page=" . $i . "'";
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
