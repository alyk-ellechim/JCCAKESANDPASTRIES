<?php

include 'functions/db_Connection.php'; 
session_start();

if(isset($_GET['ai'])){
    $ai = mysqli_escape_string($mysqli, $_GET['ai']);
}else{
    $ai = "";
}

if(isset($_POST['placeOrder'])){
    $mop = $_POST['mop'];
    $instruction = $_POST['instruction'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $userID = base64_decode($ai);
    $total = $_POST['total'];
    
    if($mop == "COD"){
        $select_cart = $mysqli->query("SELECT * FROM cart WHERE userID = '$userID'");

        if(mysqli_num_rows($select_cart) != 0){
            $order_no = generateKey($mysqli);
    
            while($row_cart = mysqli_fetch_array($select_cart)){
                $prodID = $row_cart['prodID'];
                $qty = $row_cart['qty'];
    
                $insert = $mysqli->query("INSERT INTO order_products(order_no, prodID, qty) VALUES ('$order_no', '$prodID', '$qty')");
            }
    
            $deleteCart = $mysqli->query("DELETE FROM cart WHERE userID = '$userID'");

            $updateContact = $mysqli->query("UPDATE user SET name = '$name', address = '$address', phone = '$phone' WHERE id = '$userID'");

            if($deleteCart){
                $insertOrders = $mysqli->query("INSERT INTO orders(order_no, userID, total_price, MOP, instruction) VALUES ('$order_no', '$userID', '$total', '$mop', '$instruction')");
    
                if($insertOrders){
                    $_SESSION['placeOrder'] = "true";
                    header("Location: cart.php?ai=$ai");
                }
            }
        }

    }else{
        //Paypal
        header("Location: cart.php?ai=$ai");
        $_SESSION['placeOrder'] = "true";
        exit();
    }
          


}


//Generate Order No
function checkKeys($mysqli, $randStr){

    $result = $mysqli->query("SELECT * FROM orders");
    if(mysqli_num_rows($result) != 0){
        while($row = mysqli_fetch_array($result)){
            if($row['order_no'] == $randStr){
                $keyExist = true;
                break;
            }else{
                $keyExist = false;
            }
        }
    }else{
        $keyExist = false;    
    }
    return $keyExist;
}

function generateKey($mysqli){
    $keylength = 11;
    $str = "1234567890";
    $randStr = substr(str_shuffle($str), 0, $keylength);


    $checkKey = checkKeys($mysqli, $randStr);

    while($checkKey == true){
        $randStr = substr(str_shuffle($str), 0, $keylength);
        $checkKey = checkKeys($mysqli, $randStr);
    }

    return $randStr;
}
//End Order No


?>
<!doctype html>
<html lang="en">
  <head>
  	<title>JC Cakes and Pastries</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../css/cart.css">
        <link rel="stylesheet" href="../../css/style.css">
  </head>
  <body>
		
    <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../../images/logo.png);"></a>
	        <ul class="list-unstyled components mb-5">

	          <li>
	              <a href="dashboard.php?ai=<?php echo $ai; ?>">Dashboard</a>
	          </li>

	          <li>
              <a href="products.php?ai=<?php echo $ai; ?>">Products</a>
	          </li>
	          <li class="active">
              <a href="orders.php?ai=<?php echo $ai; ?>">Orders</a>
	          </li>
	        </ul>


          <a href="../auth/logout.php?ai=<?php echo $ai; ?>" class="text-white btn btn-danger w-100">Logout</a>

	        <div class="footer mt-4">
	        	<p>
					    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | JC Cakes and Pastries
				    </p>
	        </div>

	      </div>

    	</nav>

            <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light" id="toggleBtn">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                <p class="nav navbar-nav ml-auto fs-5 fw-bold">Hello Admin!</p>

                </div>
            </div>
            </nav>
            
            <div class="titleHeader d-flex justify-content-between align-items-center">
                <?php

                    if(isset($_GET['oid'])){
                        $order_no = base64_decode($_GET['oid']);
                    }

                ?>
                <h2 class="mb-4">Order No: <span><?php echo $order_no; ?></span></h2>
                <a href="orders.php?ai=<?php echo $ai; ?>" class="text-decoration-underline" style="font-size: 15pt;">Back to Orders</a>
            </div>

            <div class="alert alert-success text-center text-uppercase">Received</div>

            <?php
                $usID = base64_decode($ai);
                $select_user = $mysqli->query("SELECT * FROM user WHERE id = '$usID'");

                if(mysqli_num_rows($select_user) != 0){
                    $rowUse = mysqli_fetch_array($select_user);

                    $name = $rowUse['name'];

                    if($rowUse['address'] != null){

                        $address = $rowUse['address'];

                    }else{
                        $address = "";
                    }

                    if($rowUse['phone'] != null){
                        $phone = $rowUse['phone'];
                    }else{
                        $phone = "";
                    }
                }

                

            ?>
            
            
            <div class="content" id="contentID">

                <form action="checkout.php?ai=<?php echo $ai; ?>" method="POST">

                    <div class="contact">
                        <label>Contact Details</label>

                        <div class="row m-0">
                            <div class="form-floating mb-3 col p-0 me-2">
                                <input type="text" disabled class="form-control" id="floatingInput" name="name" required placeholder="Name" value="<?php echo $name; ?>">
                                <label for="floatingInput">Name</label>
                            </div>

                            <div class="form-floating mb-3 col p-0 ms-2">
                                <input type="text" disabled class="form-control" id="floatingPassword" name="phone" required placeholder="Phone" value="<?php echo $phone; ?>">
                                <label for="floatingPassword">Phone</label>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="form-floating mb-3 p-0">
                                <input type="text" disabled class="form-control" id="floatingPassword" name="address" required placeholder="Address" value="<?php echo $address; ?>">
                                <label for="floatingPassword">Address</label>
                            </div>
                        </div>

                        

                    </div>

                    <div class="card">
                        <h5 class="card-header  d-flex justify-content-between align-items-center">
                            Products
                        </h5>

                        <div class="card-body text-center overflow-auto" style="height: 258px;">

                            <div class="shopping-cart" id="myCart">

                                <div class="column-labels">
                                    <label class="product-image">Image</label>
                                    <label class="product-details">Product</label>
                                    <label class="product-price">Price</label>
                                    <label class="product-quantity">Quantity</label>
                                    <label class="product-line-price">Total</label>
                                    <label class="product-removal">.</label>
                                </div>

                                <?php

                                    if(isset($_GET['oid'])){
                                        $order_no = base64_decode($_GET['oid']);
                                    }
                                    

                                    $selectOrderProducts = $mysqli->query("SELECT * FROM order_products WHERE order_no = '$order_no'");

                                    $total = 0;

                                    if(mysqli_num_rows($selectOrderProducts) != 0){
                                        while($rowOrderProduct = mysqli_fetch_array($selectOrderProducts)){
                                            $prod_ID = $rowOrderProduct['prodID'];
                                            $selectProduct = $mysqli->query("SELECT * FROM products WHERE id = '$prod_ID'");

                                            if(mysqli_num_rows($selectProduct) != 0){
                                                $rowProd = mysqli_fetch_array($selectProduct);
                                                $totalPrice = $rowOrderProduct['qty'] * $rowProd['price'];
                                                echo '<div class="product">
                                                        <div class="product-image">
                                                            <img src="../../product_Images/'.$rowProd['img'].'" style="height: 80px; width: 80px; object-fit: cover;">
                                                        </div>
                                
                                                        <div class="product-details">
                                                            <div class="product-title">'.$rowProd['name'].'</div>
                                                            <p class="product-description">'.$rowProd['description'].'</p>
                                                        </div>
                                                        
                                                        <div class="product-price price">'.$rowProd['price'].'</div>
                                                        
                                                        <div class="product-quantity">
                                                            <input type="hidden" name="prodID" value="'.$rowOrderProduct['prodID'].'">
                                                            <input type="number" class="qty" disabled name="qty" value="'.$rowOrderProduct['qty'].'" min="1">
                                                        </div>
                                
                                                        <div class="product-line-price prod_total">'.number_format($totalPrice, 2).'</div>
                                
                                                    </div>';

                                                $total += $totalPrice;
                                            }
                                            
                                        }
                                    }

                                ?>

                            </div>

                        </div>

                        <div class="card-footer overflow-auto" id="cartTotal">
                            <div class="wrapper d-flex justify-content-between">
                                <div class="mop">
                                    <label>Mode of payment:</label>
                                    <p>Cash on Delivery</p>
                                </div>

                                <div class="instruction d-flex flex-column">
                                    <label for="ins">Delivery Instruction</label>
                                    <p>TEsting</p>
                                </div>

                                <div class="totalSection">
                                    <div class="totals">
                                        <div class="totals-item m-0 p-0">
                                            <label>Subtotal</label>
                                            <div class="totals-value" id="cart-subtotal"><?php echo number_format($total, 2); ?></div>
                                        </div>

                                        <div class="totals-item m-0 p-0">
                                            <label>Delivery Fee</label>
                                            <div class="text-end">FREE</div>
                                        </div>

                                        <div class="totals-item totals-item-total m-0 p-0">
                                            <label style="margin-right: 80px;">Grand Total</label>
                                            <div class="totals-value" id="cart-total"><?php echo number_format($total, 2); ?></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  </body>
</html>