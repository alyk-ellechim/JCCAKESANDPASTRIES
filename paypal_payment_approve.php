<?php
include 'views/admin/functions/db_Connection.php';

$id =mysqli_real_escape_string($mysqli, $_GET['ui']);
$on =mysqli_real_escape_string($mysqli, $_GET['on']);
$user_id = base64_decode($id);
$order_no = base64_decode($on);

$payment_approve = $mysqli->query("UPDATE orders SET delivery_permission = 1 WHERE userID = '$user_id' AND order_no = '$order_no' LIMIT 1");

if($payment_approve){

    $select_cart = $mysqli->query("SELECT * FROM cart WHERE userID = '$user_id'");

        if(mysqli_num_rows($select_cart) != 0){
    
            while($row_cart = mysqli_fetch_array($select_cart)){
                $prodID = $row_cart['prodID'];
                $qty = $row_cart['qty'];
    
                $insert = $mysqli->query("INSERT INTO order_products(order_no, prodID, qty) VALUES ('$order_no', '$prodID', '$qty')");
            }
    
            $deleteCart = $mysqli->query("DELETE FROM cart WHERE userID = '$user_id'");

            $updateContact = $mysqli->query("UPDATE user SET name = '$name', address = '$address', phone = '$phone' WHERE id = '$user_id'");

            if($deleteCart){

                $_SESSION['placeOrder'] = "true";
                header("Location: cart.php?ui=$id");
            }
        }
    
}

?>