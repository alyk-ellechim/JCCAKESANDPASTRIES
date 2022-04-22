<?php
include '../admin/functions/db_Connection.php'; 

if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
}
?>