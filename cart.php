<?php

include 'views/admin/functions/db_Connection.php'; 
session_start();

if(isset($_GET['ui'])){
    $ui = mysqli_escape_string($mysqli, $_GET['ui']);
}else{
    $ui = "";
}

if(isset($_POST['removeFromCart'])){

    $cartID = $_POST['cartID'];

    $removeCart = $mysqli->query("DELETE FROM cart WHERE id = '$cartID' LIMIT 1");

    if($removeCart){
        header("Location: cart.php?ui=$ui");
    }
}


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
		<link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/logo.png);"></a>
	        <ul class="list-unstyled components mb-5">

	          <li>
	              <a href="index.php?ui=<?php echo $ui; ?>">Home</a>
	          </li>

	          <li>
              <a href="shop.php?ui=<?php echo $ui; ?>">Shop</a>
	          </li>

              <li class="active">
              <a href="cart.php?ui=<?php echo $ui; ?>">
                <span class="position-relative">Cart
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger ms-2">
                    <?php

                      $userID = base64_decode($ui);

                      $select_allCart = $mysqli->query("SELECT * FROM cart WHERE userID = '$userID'");

                      $totalCart = mysqli_num_rows($select_allCart);

                      echo $totalCart;

                    ?>
                    
                  </span>
                </span> 
              </a>
	          </li>
              
	          <li>
              <a href="orders.php?ui=<?php echo $ui; ?>">Orders</a>
	          </li>
	        </ul>


            <?php

                if(isset($_SESSION['email']) && isset($_SESSION['password'])){
                    $email = $_SESSION['email'];
                    echo '<a href="views/auth/logout.php?ui='.$ui.'" class="text-white btn btn-danger w-100">Logout</a>';
                }else{
                    $email = 'User';
                    echo '<a href="views/auth/login.php?" class="text-white btn btn-success w-100">Login</a>';
                }


            ?>

	        <div class="footer mt-4">
	        	<p>
					    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | JC Cakes and Pastries
				    </p>
	        </div>

	      </div>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">


              <p class="nav navbar-nav ml-auto fs-5 fw-bold">Hello <?php echo $email; ?></p>

            </div>
          </div>
        </nav>

        <h2 class="mb-4">Cart</h2>
        
        <div class="content" id="contentID">


        <div class="card">
            <h5 class="card-header  d-flex justify-content-between align-items-center">
                My Cart
            </h5>

            <div class="card-body text-center overflow-auto" style="height: 258px;">

                <div class="shopping-cart" id="myCart">

                    <div class="column-labels">
                        <label class="product-image">Image</label>
                        <label class="product-details">Product</label>
                        <label class="product-price">Price</label>
                        <label class="product-quantity">Quantity</label>
                        <label class="product-line-price">Total</label>
                        <label class="product-removal">Remove</label>
                    </div>

                    <?php

                        $userID = base64_decode($ui);

                        $selectCart = $mysqli->query("SELECT * FROM cart WHERE userID = '$userID'");

                        $total = 0;

                        $checkoutBtn = "";

                        if(mysqli_num_rows($selectCart) != 0){
                            while($rowCart = mysqli_fetch_array($selectCart)){
                                $prod_ID = $rowCart['prodID'];
                                $selectProduct = $mysqli->query("SELECT * FROM products WHERE id = '$prod_ID'");

                                if(mysqli_num_rows($selectProduct) != 0){
                                    $rowProd = mysqli_fetch_array($selectProduct);
                                    $totalPrice = $rowCart['qty'] * $rowProd['price'];
                                    echo '<div class="product">
                                            <div class="product-image">
                                                <img src="product_Images/'.$rowProd['img'].'" style="height: 80px; width: 80px; object-fit: cover;">
                                            </div>
                    
                                            <div class="product-details">
                                                <div class="product-title">'.$rowProd['name'].'</div>
                                                <p class="product-description">'.$rowProd['description'].'</p>
                                            </div>
                                            
                                            <div class="product-price price">'.$rowProd['price'].'</div>
                                            
                                            <div class="product-quantity">
                                                <input type="hidden" name="prodID" value="'.$rowCart['prodID'].'">
                                                <input type="number" class="qty" name="qty" value="'.$rowCart['qty'].'" min="1">
                                            </div>
                    
                                            <div class="product-line-price prod_total">'.number_format($totalPrice, 2).'</div>
                    
                                            <div class="product-removal">
                                                <form action="cart.php?ui='.$ui.'" method="POST">
                                                    <input type="hidden" name="cartID" value="'.$rowCart['id'].'">
                                                    <button type="submit" name="removeFromCart" class="remove-product">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>';

                                    $total += $totalPrice;
                                }
                                
                            }
                        }else{
                            echo '<div class="alert alert-danger">No Item in Cart <a href="shop.php?ui='.$ui.'" class="text-decoration-underline">Continue Shopping</a></div>';
                            $checkoutBtn = 'style="pointer-events: none; opacity: 50%;"';
                        }

                    ?>

                </div>

            </div>

            <div class="card-footer" id="cartTotal">
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
                        <label>Grand Total</label>
                        <div class="totals-value" id="cart-total"><?php echo number_format($total, 2); ?></div>
                    </div>
                </div>


                <?php

                    if($ui != ""){
                        echo '<a href="checkout.php?ui='.$ui.'" class="btn btn-success m-0 checkout" '.$checkoutBtn.'>Checkout</a>';
                    }else{
                        echo '<a href="views/auth/login.php" class="btn btn-success m-0 checkout" '.$checkoutBtn.'>Checkout</a>';
                    }

                ?>
                
                
            </div>
        </div>
        





        </div>

      </div>
      
		</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php			
      if(isset($_SESSION['placeOrder'])) {
        echo '<script type="text/javascript">
          swal("Thank you!", "Your order is being proccess", "success");
        </script>';
        unset($_SESSION['placeOrder']);
      } 

    ?>


    <script>

        $(document).on('change', '.qty', function() {

            var param = new URLSearchParams(window.location.search);
            var ui = param.get('ui');
            var prodId  = $(this).closest('.product').find('input[name=prodID]').val();
            var qty  = $(this).closest('.product').find('input[name=qty]').val();

            $.ajax({
                type: "POST",
                url: "userFunctions/updateQuantity.php",
                data: {
                    prodID : prodId,
                    userID : ui,
                    Qty : qty,
                },
                dataType: "json",
                encode: true,
                }).done(function (data) {
                    $("#myCart").load(location.href + " #myCart > *");
                    $("#cartTotal").load(location.href + " #cartTotal > *");
            });
            
        });     
    

    </script>


  </body>
</html>