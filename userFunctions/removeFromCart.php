<?php

include '../views/admin/functions/db_Connection.php'; 

if(isset($_GET['ui'])){
    $ui = mysqli_escape_string($mysqli, $_GET['ui']);
}else{
    $ui = "";
}
           
if(isset($_POST['removeFromCart'])){

    $cartID = $_POST['cartID'];

    $removeCart = $mysqli->query("DELETE FROM cart WHERE id = '$cartID' LIMIT 1");
 
    if($removeCart){
        header("Location: ../cart.php?ui=$ui");
    }
}


?>