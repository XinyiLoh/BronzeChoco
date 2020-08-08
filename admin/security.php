<?php
session_start();
include ('database/connection.php');

if($dbconfig){
//    echo "Database Connected";
}else{
    header("Location: database/connection.php");
}

if(!$_SESSION['username']){
    header('Location: login.php');
}

?>

