<?php

include 'db_Connection.php'; 

if(isset($_POST['from']) && isset($_POST['to'])){

    $fromDate = $_POST['from'];
    $toDate = date('Y-m-d H:i:s', strtotime($_POST['to'] . ' +1 day'));

    $searchOrders = $mysqli->query("SELECT * FROM orders WHERE date_ordered BETWEEN '$fromDate' AND '$toDate'");

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
    }
 

}




?>