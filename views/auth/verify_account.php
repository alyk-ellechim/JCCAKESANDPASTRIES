<?php
include '../admin/functions/db_Connection.php';
session_start();

$vkey =mysqli_real_escape_string($mysqli, $_GET['vkey']);
$update = $mysqli->query("UPDATE user SET verified='1' WHERE vkey='$vkey'");

if($update){
    $_SESSION['verified']= "true";
    header("Location: login.php");
}else{
    echo "false";
}

?>

