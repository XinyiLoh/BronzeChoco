<?php 
include('config.php');
include('headerFooter/header.php'); 
?>

 <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">White Chocolates
    </h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="index.php">Home</a>
      </li>
      <li class="breadcrumb-item active">White Chocolates</li>
    </ol>
<?php
    
    $query = "SELECT * FROM product_info WHERE cat_id='2'";
    $query_run = mysqli_query($connection,$query);
    
    if(mysqli_num_rows($query_run) > 0){
        while($row = mysqli_fetch_assoc($query_run)){
    ?>
        <!-- Project One -->
        <div class="row">
          <div class="col-md-7">
            <a href="#">
                <img class="img-fluid rounded mb-3 mb-md-0" src="admin/upload/<?php echo $row['product_image']; ?>" alt="">
            </a>
          </div>
          <div class="col-md-5">
            <h3><?php echo $row['product_title']; ?></h3>
            <p><?php echo $row['product_desc']; ?></p>
            <h4>RM<?php echo number_format($row['product_price'],2);?></h4>
            <form action="cart.php" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['product_id']?>" />
                <button type="submit" name="edit_btn" class="btn btn-warning">Add to Cart</button>
            </form>
          </div>
        </div>
        <!-- /.row -->
        <hr>
    <?php
        }
    } else {
        echo "No Record Found";
    }
    ?>

  </div>
  <!-- /.container -->


<?php include('headerFooter/footer.php'); ?>