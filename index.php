<?php

include 'views/admin/functions/db_Connection.php'; 
session_start();

if(isset($_GET['ui'])){
    $ui = mysqli_escape_string($mysqli, $_GET['ui']);
}else{
    $ui = "";
    if(isset($_SESSION['ui'])){
      $ui = $_SESSION['ui'];
    }
}

if(isset($_POST['addToCart'])){
  $prodID = $_POST['prod_id'];

  if(isset($_POST['qty'])){
    $qty = $_POST['qty'];
  }else{
    $qty = 1;
  }

  $userID = base64_decode($ui);

  $select_cart = $mysqli->query("SELECT * FROM cart WHERE userID = '$userID' AND prodID = '$prodID'");

  if(mysqli_num_rows($select_cart) != 0){
      $row_cart = mysqli_fetch_array($select_cart);

      $totalQty = $row_cart['qty'] + $qty;

      $cart_id = $row_cart['id'];

      $update = $mysqli->query("UPDATE cart SET userID = '$userID' , prodID = '$prodID', qty = '$totalQty' WHERE id = '$cart_id' LIMIT 1");

      $_SESSION['addedToCart'] = 'true';
      header("Location: index.php?ui=$ui");
      exit();

  }else{
      $insert = $mysqli->query("INSERT INTO cart(userID, prodID, qty) VALUES ('$userID', '$prodID', '$qty')");
      $_SESSION['addedToCart'] = 'true';
      header("Location: index.php?ui=$ui");
      exit();
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
		<link rel="stylesheet" href="css/style.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/logo.png);"></a>
	        <ul class="list-unstyled components mb-5">

	          <li class="active">
	              <a href="index.php?ui=<?php echo $ui; ?>">Home</a>
	          </li>

	          <li>
              <a href="shop.php?ui=<?php echo $ui; ?>">Shop</a>
	          </li>

            <li>
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

        <h4 class="text-center fw-bold">Make some sweet memories at<br>JC's Cakes and Pastries</h4>

        <h2 class="mb-4">Home</h2>
        
        <div class="content">

            <div class="card">
                <h5 class="card-header  d-flex justify-content-between align-items-center">
                    Featured Products
                </h5>
                <div class="card-body text-center overflow-auto" style="height: 410px;">
                    <!-- Products --> 

                <?php
                    $selectProduct = $mysqli->query("SELECT * FROM products ORDER BY RAND() LIMIT 6")
                    or die("Failed to query database" .mysql_error());
                    $row = mysqli_fetch_array($selectProduct);
                    $hold = "";
                        
                    if(mysqli_num_rows($selectProduct) == 0){
                        echo "<tr>
                        <td class='tm-product-name'>No Product Available</td></tr>"; 
                                        
                    }else{
                        do{
                            $new_product = '<div class="card d-inline-block my-sm-4 mx-sm-2 text-start" style="width: 18rem; ">
                            <img src="product_Images/'.$row['img'].'" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">'.$row['name'].'</h5>
                                <p class="card-text">'.$row['description'].'</p>
                                <p class="card-text fs-6">&#8369; '.$row['price'].'.00</p>
                                <form action="index.php?ui='.$ui.'" method="POST">
                                <input type="hidden" name="prod_id" value="'.$row['id'].'">
                                <button type="submit" name="addToCart" value="'.$row['id'].'" class="btn text-white btn-primary">Add to Cart</button>
                                <button type="submit" name="buyNow" value="'.$row['id'].'" class="btn btn-primary">Buy Now</button>
                                </form>
                            </div>
                        </div>';
                            $hold = $new_product . $hold;
                            $display_all = $hold;
                        }while($row = mysqli_fetch_array($selectProduct));
                            
                        echo $display_all;
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php			
      if(isset($_SESSION['addedToCart'])) {
        echo '<script type="text/javascript">
          swal("Success", "Product has been added to cart", "success");
        </script>';
        unset($_SESSION['addedToCart']);
      } 

    ?>
  </body>
</html>