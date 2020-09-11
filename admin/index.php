<?php 
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php  
//if(isset($_SESSION['views'])) 
//    $_SESSION['views'] = $_SESSION['views']+1; 
//else
//    $_SESSION['views']=1; 
  
?> 

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <a class="weatherwidget-io" href="https://forecast7.com/en/3d16101d71/federal-territory-of-kuala-lumpur/" data-label_1="KUALA LUMPUR" data-label_2="WEATHER" data-font="Ubuntu" data-icons="Climacons Animated" data-theme="weather_one" >KUALA LUMPUR WEATHER</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>
        
        <hr>
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
<!--        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                      <div>Page view = <?php echo $_SESSION['views'] ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>-->
      </div>
      
    <div class="row">

        <div class="col-lg-6">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-success">Admins</h6>
                </div>
                <div class="card-body">
                    <table>
                        <tr style="color: blue">
                            <th>Admin ID</th>
                            <th style="color: yellow">&nbsp;<i class="far fa-star"></i>&nbsp;</th>
                            <th>Name</th>
                            <th style="color: orange">&nbsp;<i class="fas fa-sun"></i>&nbsp;</th>
                            <th>Drop an email !</th>
                        </tr>
                        <?php
                        $query = "SELECT * FROM admin_info";
                        $query_run = mysqli_query($connection,$query);

                        if(mysqli_num_rows($query_run) > 0){
                            while($row = mysqli_fetch_assoc($query_run)){
                        ?>
                        <tr>
                            <td colspan="2"><?php echo $row['admin_id']; ?></td>
                            <td colspan="2"><?php echo $row['admin_name']; ?></td>
                            <td>
                                <form action="sendMail.php" method="POST">
                                    <input type="hidden" name="mail" value="<?php echo $row['admin_email']?>">
                                    <center><button  type="submit" name="email_btn" class="btn btn-info btn-circle btn-sm"><i class="far fa-envelope-open"></i></button></center>
                                </form>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "No Record Found";
                        }
                        ?>
                    </table>
                </div>
              </div>
        </div>    
    </div>
          
          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-8 col-lg-7">

              <!-- Area Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger">Monthly Revenue</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>

            </div>

            <!-- Donut Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-warning">Categories</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <hr>
                  Total products in Categories.
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <!-- /.container-fluid -->
  
  <?php
  include('includes/scripts.php');
  include('includes/footer.php');
  ?>





 


