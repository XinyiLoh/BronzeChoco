<?php
include('config.php');

$cat = array(
    1 => "Milk Chocolate",
    2 => "White Chocolate",
    3 => "Dark Chocolate"
);

$output = '';

if(isset($_POST["query"])){
 $search = mysqli_real_escape_string($connection, $_POST["query"]);
 $query = "
  SELECT * FROM product_info
  WHERE product_title LIKE '%".$search."%'
  OR product_price LIKE '%".$search."%' 
  OR product_desc LIKE '%".$search."%'
 ";
}else{
 $query = "SELECT * FROM product_info ORDER BY product_id";
}

$result = mysqli_query($connection, $query);
if(mysqli_num_rows($result) > 0){
 $output .= '
  <div class="table-responsive">
   <table class="table table bordered">
    <tr>
     <th>Category</th>
     <th>Product title</th>
     <th>Product description</th>
     <th>Product price</th>
     <th>Product image</th>
    </tr>
 ';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '
   <tr>
    <td>'.$cat[$row["cat_id"]].'</td>
    <td>'.$row["product_title"].'</td>
    <td>'.$row["product_desc"].'</td>
    <td>'.$row["product_price"].'</td>
    <td><img height=100 width=100 src="admin/upload/'.$row['product_image'].'"</td>
   </tr>
  ';
 }
 echo $output;
}else{
 echo 'Data Not Found';
}

?>
