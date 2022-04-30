<?php
include 'views/admin/functions/db_Connection.php';

if(isset($_SESSION['ai'])){
    header("Location: views/auth/login.php");
  }

$id =mysqli_real_escape_string($mysqli, $_GET['ui']);
$on =mysqli_real_escape_string($mysqli, $_GET['on']);
$user_id = base64_decode($id);
$order_no = base64_decode($on);

$select_order = $mysqli->query("SELECT * FROM orders WHERE userID = '$user_id' AND order_no = '$order_no' ");
if(mysqli_num_rows($select_order) != 0){
    $row_order = mysqli_fetch_array($select_order);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/checkout.css">
        <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <title>Paypal Payment</title>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form_control" style="background-color: #ebebeb; padding: 20px; border-radius: 10px;">
            <h1 style="text-align: center; font-size:15pt;">Order Details</h1>
            <span  style="text-align: center;"><p class="p m-0 p-0"><span>Order No: </span>  <?php echo $order_no; ?></p></span>
            <span  style="text-align: center;"><p class="p"><span>Amount: </span>  &#8369;<?php echo $row_order['total_price']; ?></p></span>
            <input type="hidden" value="<?php echo $row_order['total_price']; ?>" id="total_amount">
            <span  style="text-align: center;">Click the button below to continue. </span>
            <div id="paypal-button-container">
        </div>
        
    </div>

<script
    src="https://www.paypal.com/sdk/js?client-id=AY-obt4iIYKuvPu91GadYaPtnbEHKw21GW2AsLEByq-NlqC7UQGnjG2K9NGevTfA4jiIFZiFoerDUtt4&disable-funding=credit,card">
  </script>

  <div id="paypal-button-container"></div>

  <script>
    var param = new URLSearchParams(window.location.search);
    var ui = param.get('ui');
    var on = param.get('on');

    var total_amount = document.getElementById('total_amount');
    var price = String(total_amount.value);
    paypal.Buttons({
    style:{
        color:"blue",
        shape:"pill"
    },
    createOrder:function(data,actions){
        return actions.order.create({
            purchase_units:[{
                amount:{
                    value:price
                }
            }]
         
        });
    },
    onApprove:function(data,actions){
        return actions.order.capture().then(function(details){
            console.log(details)
            window.location.replace('http://localhost/JCCAKESANDPASTRIES/paypal_payment_approve.php?ui='+ui+'&&on='+on+'')
       
        })
    },
    onCancel:function(data){
        window.location.replace('http://localhost/JCCAKESANDPASTRIES/checkout.php?ui='+ui+'')
    }
}).render('#paypal-button-container');

  </script>
</body>
</html>