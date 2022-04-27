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

	          <li>
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
              
	          <li class="active">
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

        <h2 class="mb-4">Orders</h2>
        
        <div class="content" id="contentID">

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span>Order List</span>
                <span><a href="order_history.php?ui=<?php echo $ui; ?>" class="text-decoration-underline">Order History</a></span>
            </h5>
            <div class="card-body text-center overflow-auto" style="height: 410px;">
                <!-- Orders --> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order No.</th>
                        <th scope="col">Price</th>
                        <th scope="col">Date Ordered</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                            $userID = base64_decode($ui);
                            $select_orders = $mysqli->query("SELECT * FROM orders WHERE userID = '$userID'");

                            if(mysqli_num_rows($select_orders) != 0){
                                $counter = 0;
                                while($row_orders = mysqli_fetch_array($select_orders)){
                                    $counter += 1;

                                    $time = strtotime($row_orders['date_ordered']);
                                    $date_ordered = date("m/d/y g:i A", $time);

                                    $total_price = $row_orders['total_price'];

                                    if($row_orders['status'] == 0){
                                      $status = 'Pending';
                                    }else if($row_orders['status'] == 1){
                                      $status = 'Processing';
                                    }else if($row_orders['status'] == 2){
                                      $status = 'Out for delivery';
                                    }

                                    if($row_orders['status'] != 3){
                                      echo '<tr>
                                              <th scope="row">'.$counter.'</th>
                                              <td>'.$row_orders['order_no'].'</td>
                                              <td>&#8369;'.number_format($total_price, 2).'</td>
                                              <td>'.$date_ordered.'</td>
                                              <td>'.$status.'</td>
                                              <td><a href="order_products.php?ui='.$ui.'&oid='.base64_encode($row_orders['order_no']).'" class="btn btn-primary btn-sm">View</a></td>
                                          </tr>';
                                  }
                                }
                            }

                        ?>
                        

                    </tbody>
                </table>


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
    
      if(isset($_SESSION['cancel'])) {
        echo '<script type="text/javascript">
          swal("Success!", "Order Canceled", "success");
        </script>';
        unset($_SESSION['cancel']);
      }

    ?>

  </body>
</html>