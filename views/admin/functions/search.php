<?php

include 'db_Connection.php'; 

if(isset($_POST['Search'])){

    $search = $_POST['Search'];

    $searchOrders = $mysqli->query("SELECT * FROM orders JOIN user ON orders.userID = user.id WHERE user.name LIKE '%$search%'");

    if(mysqli_num_rows($searchOrders) != 0){

        while($result = mysqli_fetch_array($searchOrders)) {
            $output[] = array (
                "order_no" => $result['order_no'],
                "total_price" => $result['total_price'],
                "date_ordered" => $result['date_ordered'],
                "status" => $result['status']
            ); 
        }

        echo json_encode($output);
    }else{

        $searchProducts = $mysqli->query("SELECT * FROM products JOIN order_products ON products.id = order_products.prodID WHERE products.name LIKE '%$search%'");

        if(mysqli_num_rows($searchProducts) != 0){

            $order = mysqli_fetch_array($searchProducts);
            $order_no = $order['order_no'];

            $searchOrder = $mysqli->query("SELECT * FROM orders WHERE order_no = '$order_no'");

            while($result = mysqli_fetch_array($searchOrder)) {
                $output[] = array (
                    "order_no" => $result['order_no'],
                    "total_price" => $result['total_price'],
                    "date_ordered" => $result['date_ordered'],
                    "status" => $result['status']
                ); 
            }

            echo json_encode($output);


        }

    }
 

}




?>