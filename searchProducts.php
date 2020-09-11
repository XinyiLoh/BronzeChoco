<?php
session_start();
include('config.php');
include('headerFooter/header.php'); 
?>
  <div class="container">
   <br />
   <h2 align="center">Bronze Choco Products</h2>
   <br />
   <div class="form-group">
    <div class="input-group">
     <input type="text" name="search_text" id="search_text" placeholder="Search by Product Details" class="form-control" />
    </div>
   </div>
   <br />
   <div id="result"></div>
  </div>

   <div id="result"></div>
   
   <?php include('headerFooter/footer.php'); ?>