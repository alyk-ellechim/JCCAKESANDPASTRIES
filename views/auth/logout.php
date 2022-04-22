<?php 
include '../admin/functions/db_Connection.php';
session_start();


if(isset($_GET['ui'])){
    $ui = base64_decode(mysqli_escape_string($mysqli, $_GET['ui']));

    $sql = "UPDATE user set status = 0 WHERE id = '$ui'";
	$logout = mysqli_query($mysqli, $sql);

    if($logout){
        header("Location: login.php");
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    }
}elseif(isset($_GET['ai'])){
    $ai = base64_decode(mysqli_escape_string($mysqli, $_GET['ai']));

    $sql = "UPDATE admin set status = 0 WHERE id = '$ai'";
	$logout = mysqli_query($mysqli, $sql);

    if($logout){
        header("Location: login.php");
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    }
}


?>