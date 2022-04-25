<?php
include '../views/admin/functions/db_Connection.php'; 

$data = [];

if(isset($_POST['prodID'])){
    $prodID = $_POST['prodID'];
    $ui = $_POST['userID'];
    $userID = base64_decode($ui);

    if(isset($_POST['Qty'])){
        $qty = $_POST['Qty'];
    }else{
        $qty = 1;
    }

    $select_cart = $mysqli->query("SELECT * FROM cart WHERE userID = '$userID' AND prodID = '$prodID'");

    if(mysqli_num_rows($select_cart) != 0){
        $row_cart = mysqli_fetch_array($select_cart);

        $cart_id = $row_cart['id'];

        $update = $mysqli->query("UPDATE cart SET qty = '$qty' WHERE id = '$cart_id' LIMIT 1");
        $data['success'] = true;
        $data['message'] = 'Success!';
    }
    
    echo json_encode($data);
}else{
    $data['success'] = false;
    $data['message'] = 'Failed!';

    echo json_encode($data);
}


?>