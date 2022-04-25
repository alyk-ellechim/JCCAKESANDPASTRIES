<?php

include 'views/admin/functions/db_Connection.php'; 
session_start();

if(isset($_GET['ui'])){
    $ui = mysqli_escape_string($mysqli, $_GET['ui']);
}else{
    $ui = "";
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
              <a href="cart.php?ui=<?php echo $ui; ?>">Cart</a>
	          </li>
              
	          <li>
              <a href="#">Orders</a>
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

                <div class="shopping-cart">

                    <div class="column-labels">
                        <label class="product-image">Image</label>
                        <label class="product-details">Product</label>
                        <label class="product-price">Price</label>
                        <label class="product-quantity">Quantity</label>
                        <label class="product-line-price">Total</label>
                        <label class="product-removal">Remove</label>
                    </div>

                    <div class="product">
                        <div class="product-image">
                            <img src="https://s.cdpn.io/3/dingo-dog-bones.jpg">
                        </div>

                        <div class="product-details">
                            <div class="product-title">Dingo Dog Bones</div>
                            <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
                        </div>
                        
                        <div class="product-price price">12.99</div>
                        
                        <div class="product-quantity">
                            <input type="number" class="qty" value="0" min="1">
                        </div>

                        <div class="product-line-price prod_total">25.98</div>

                        <div class="product-removal">
                            <button class="remove-product">
                                Remove
                            </button>
                        </div>
                    </div>

                    <div class="product">
                        <div class="product-image">
                            <img src="https://s.cdpn.io/3/dingo-dog-bones.jpg">
                        </div>

                        <div class="product-details">
                            <div class="product-title">Dingo Dog Bones</div>
                            <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
                        </div>
                        
                        <div class="product-price price">15.99</div>
                        
                        <div class="product-quantity">
                            <input type="number" class="qty" value="0" min="1">
                        </div>

                        <div class="product-line-price prod_total">25.98</div>

                        <div class="product-removal">
                            <button class="remove-product">
                                Remove
                            </button>
                        </div>
                    </div>


                </div>

            </div>

            <div class="card-footer">
                <div class="totals">
                    <div class="totals-item m-0 p-0">
                        <label>Subtotal</label>
                        <div class="totals-value" id="cart-subtotal">71.97</div>
                    </div>

                    <div class="totals-item m-0 p-0">
                        <label>Delivery Fee</label>
                        <div class="text-end">FREE</div>
                    </div>

                    <div class="totals-item totals-item-total m-0 p-0">
                        <label>Grand Total</label>
                        <div class="totals-value" id="cart-total">90.57</div>
                    </div>
                </div>
                
                <button class="btn btn-success m-0 checkout">Checkout</button>
            </div>
        </div>
        





        </div>

      </div>
      
		</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>


    <script>

        $('.qty').change( function() {
            var price = $(this).closest('.product').find('.price').text();

            var qty = $(this).val();

            var total = price * qty;

            $(this).closest('.product').find('.prod_total').text(total.toFixed(2));
            
        });






        
    

    </script>


  </body>
</html>