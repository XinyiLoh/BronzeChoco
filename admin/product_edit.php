<?php
ob_start(); //start buffering the output
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
        $_SESSION['status'] = "No Product ID found</li>";
        $_SESSION['status_code'] = "error";
    }
    
    $message = array();
    
    $cat_id  = $_POST['category'];
    $title = trim($_POST['edit_productTitle']);
    $price = trim($_POST['edit_productPrice']);
    $desc = trim($_POST['edit_productDescription']);
    $image = $_FILES['productImage']['name'];
    $stock = trim($_POST['edit_productStock']);
//    $temp = 'upload/' . $_FILES['productImage']['name'];
    
    $prod_query = "SELECT * FROM product_info WHERE product_id=".$id."";
    $prod_query_run = mysqli_query($connection,$prod_query);
    foreach ($prod_query_run as $prod_row) {
        if(empty($cat_id)){                             //if do not have new category
            $cat_data = $prod_row['cat_id'];
        }else{
            $cat_data = $cat_id;
        }
        //update w/ existing image
        if(empty($image)){
            $image_data = $prod_row['product_image'];       //if do not have new file
        }else{
            if($img_path = 'upload/'.$prod_row['product_image']){
                unlink($img_path);
                $image_data = $image;
            }
        }
    }
    
    $temp = 'upload/' .$image_data;
    $imageFileType = strtolower(pathinfo($temp,PATHINFO_EXTENSION));

    //check category
    if($cat_data == null || $cat_data == ""){
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
    if($image_data == null || $image_data  == ""){
        array_push($message,"Please upload the image.");
        $type = "error";
    }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
        array_push($message,"Only JPG, PNG and JPEG are allowed.");
        $type = "error";
    }elseif($image_data > 500000){
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
        
        $query = "UPDATE product_info SET cat_id='".$cat_data."',product_title='".$title."',product_price='".$price."',product_desc='".$desc."',product_image='".$image_data."',product_stock='".$stock."' WHERE product_id='".$id."';";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {

            if (empty($image)) {

                $_SESSION['status'] = "Product Edited with existing image";
                $_SESSION['status_code'] = "success";
//                echo "<script>window.location = 'product.php'</script>";

            } else {
                move_uploaded_file($_FILES['productImage']['tmp_name'],$temp);
                $_SESSION['status'] = "Product Edited with new image";
                $_SESSION['status_code'] = "success";
//                header('Location: product.php');
//                echo "<script>window.location = 'product.php'</script>";

            }

        } else {
            $_SESSION['status'] = "Product NOT Edited".$query;
            $_SESSION['status_code'] = "error";
//            header('Location: product.php');
//            echo "<script>window.location = 'product.php'</script>";
//            echo $query;
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
      
    if (!empty($message)) {
        
        echo '<span class='.$type.'><small><ul>';
        foreach ($message as $value) {
              echo '<li>';
              echo $value;
              echo '</li>';
        }
        $show = 0;
        echo '</small></ul></span><br/>';
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
                    1 => "Milk",
                    2 => "Dark",
                    3 => "White"
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
            <img src='upload/<?php echo $row['product_image']; ?>' alt="Image" height=100 width=200 /><br/>
            <label>Image :</label>
            <input type="file" name="productImage" id="productImage" accept = "image/*" >
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
