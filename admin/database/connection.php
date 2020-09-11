<link href="../css/sb-admin-2.min.css" rel="stylesheet">

<?php 

$server_name = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bronzechoco";

$connection = mysqli_connect($server_name,$db_username,$db_password,$db_name);
$dbconfig = mysqli_select_db($connection,$db_name);

if ($dbconfig) {
    // echo "Database Connected";
}else{
    echo'<div class="container">
            <div class="row">
                <div class="col-md-6 mr-auto ml-auto text-center py-5 mt-5">
                    <div class="card">
                        <h1 class="card-title text-red">Database Connection Failed</h1>
                        <h2 class="card-title">Database Failure</h2>
                        <p class="card-text">Please Check Your Database Connection...</p>
                        <a href="#">:(</a>
                    </div>
                </div>
            </div>
        </div>';
}

?>