<?php 
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<?php  
if(isset($_SESSION['views'])) 
    $_SESSION['views'] = $_SESSION['views']+1; 
else
    $_SESSION['views']=1; 
  
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
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                      <div>Page view = <?php echo $_SESSION['views'] ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->
      <div class="row">
          <div class="col-xl-12 col-lg-12">
            
          <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Area Chart</h6>
                </div>
                <div class="card-body">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['corechart']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Year', 'Sales', 'Expenses'],
                          ['2016',  1000,      400],
                          ['2017',  1170,      460],
                          ['2018',  660,       1120],
                          ['2019',  1030,      540]
                        ]);

                        var options = {
                          title: 'Company Performance',
                          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
                          vAxis: {minValue: 0}
                        };

                        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                      }
                    </script>
                    <div id="chart_div" style="width: 100%; height: 500px;"></div>
                  </div>
                </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Geo Chart</h6>
                </div>
                <div class="card-body">
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                      google.charts.load('current', {
                        'packages':['geochart'],
                        // Note: you will need to get a mapsApiKey for your project.
                        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
                        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
                      });
                      google.charts.setOnLoadCallback(drawRegionsMap);

                      function drawRegionsMap() {
                        var data = google.visualization.arrayToDataTable([
                          ['Country', 'Customers'],
                          ['Germany', 200],
                          ['United States', 300],
                          ['Brazil', 400],
                          ['Canada', 500],
                          ['France', 600],
                          ['RU', 700]
                        ]);

                        var options = {};

                        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

                        chart.draw(data, options);
                      }
                    </script>
                    <div id="regions_div" style="width: 900px; height: 500px;"></div>
                </div>
            </div>
            </div>
         
        </div>
        <!-- Content Row -->

    </div>
    <!-- /.container-fluid -->
  
  <?php
  include('includes/scripts.php');
  include('includes/footer.php');
  ?>





 


