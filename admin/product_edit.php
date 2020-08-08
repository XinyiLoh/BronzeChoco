<?php
include('security.php'); 
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
<?php
$show = 1;
if(isset($_POST['updatebtn'])) {
 
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
       $id = $_POST['edit_id'];
    } else {
        echo "No Product ID found</li>";
    }
        
    $cat_id  = $_POST['category'];
    $title = trim($_POST['edit_productTitle']);
    $price = trim($_POST['edit_productPrice']);
    $desc = trim($_POST['edit_productDescription']);
    $image = $_FILES['productImage']['name'];
    $stock = trim($_POST['edit_productStock']);
    $temp = 'upload/' . $_FILES['productImage']['name'];
    
    $prod_query = "SELECT * FROM product_info WHERE product_id=".$id."";
    $prod_query_run = mysqli_query($connection,$prod_query);
    foreach ($prod_query_run as $prod_row) {

        if(empty($cat_id)){
            $cat_data = $prod_row['cat_id'];
        }else{
            $cat_data = $cat_id;
        }

        //update w/ existing image
        if(empty($image)){
            $image_data = $prod_row['product_image'];
        }else{

            if($img_path = 'upload/'.$prod_row['product_image']){
                unlink($img_path);
                $image_data = $image;
            }
        }
    }

    if(!preg_match ("/^[0-9]+(\.[0-9]{2})?$/", $price) || !preg_match ("/^[0-9]+$/",$stock)){

        if(!preg_match ("/^[0-9]+(\.[0-9]{2})?$/", $price)){
            $_SESSION['status'] = "Price format invalid";
        }else{
            $_SESSION['status'] = "Stock format invalid";
        }
        
    }else{
        $query = "UPDATE product_info SET cat_id='".$cat_data."',product_title='".$title."',product_price='".$price."',product_desc='".$desc."',product_image='".$image_data."',product_stock='".$stock."' WHERE product_id='".$id."';";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {

            if (empty($image)) {

                $_SESSION['success'] = "Product Edited with existing image";
                echo "<script>window.location = 'product.php'</script>";

            } else {
                move_uploaded_file($_FILES['productImage']['tmp_name'],$temp);
                $_SESSION['success'] = "Product Edited with new image";
                echo "<script>window.location = 'product.php'</script>";

            }

        } else {
            $_SESSION['status'] = "Product NOT Edited".$query;
            echo "<script>window.location = 'product.php'</script>";
            echo $query;
        }
    }
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Edit</h6>
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

    $result =mysqli_query($connection,"SELECT * FROM product_info WHERE product_id='$id'")or die("query 1 incorrect......");
    mysqli_fetch_array($result);
    
    foreach ($result as $row) {
    ?>
      
    <form action="" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="edit_id" value="<?php echo $id;?>">

            <div class="form-group">
                <label>Category :</label>
                <select name="category">
                
                <?php
                $cat = array (
                    1 => "Pure",
                    2 => "Fruity",
                    3 => "Nutty"
                );

                $q = "SELECT cat_id,cat_title FROM category";
                $r = mysqli_query($connection,$q);
                echo $cat[$row['cat_id']];
                if (mysqli_num_rows($r) > 0) {
                    while ($cat = mysqli_fetch_array ($r, MYSQLI_NUM)) {
                        echo "<option value=\"$cat[0]\"";
                        if (isset($_POST['category']) && ($_POST['category'] == $cat[0])) echo 'selected="selected"';
                        echo ">$cat[1]</option>\n";
                    }
                }else{
                    echo '<option>Please add a new category first.</option>';
                }
                ?>
                </select>
            </div>
        
        <div class="form-group">
            <label>Title :</label><input type="text" name="edit_productTitle" size="30" maxlength="30" class="form-control" placeholder="Dark Choco" value="<?php echo $row['product_title']; ?>" required>
        </div>
        <div class="form-group">
            <label>Price : </label><input type="text" name="edit_productPrice" size="10" maxlength="10" class="form-control" value="<?php echo number_format($row['product_price'],2); ?>" placeholder="Do not include the dollar sign or commas." required>
        </div>
        <div class="form-group">
            <label>Description :</label>
            <textarea name="edit_productDescription" cols="50" rows="5"><?php echo $row['product_desc']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Image :</label>
            <input type="file" name="productImage" id="productImage" value="<?php echo $row['product_image']; ?>" accept = "image/png, image/jpeg, image/jpg" >
        </div>
        <div class="form-group">
            <label>Stock :</label><input type="text" name="edit_productStock" value="<?php echo $row['product_stock']; ?>" size="10" maxlength="10" pattern="/^\d{0-9}$/" class="form-control" required>
        </div>

        <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
        <a href="product.php" class="btn btn-danger">Cancel</a>

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
