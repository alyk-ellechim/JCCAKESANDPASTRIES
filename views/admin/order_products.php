<?php

include 'functions/db_Connection.php'; 
session_start();

if(isset($_GET['ai'])){
    $ai = mysqli_escape_string($mysqli, $_GET['ai']);
}else{
    $ai = "";
}

if(isset($_POST['saveStatus'])){
    $order_status = $_POST['status'];

    if(isset($_GET['oid'])){  
        $on = base64_decode($_GET['oid']);
        $oid = $_GET['oid'];
    }


    $update_status = $mysqli->query("UPDATE orders SET status = '$order_status' WHERE order_no = '$on'");

    if($update_status){
        $_SESSION['statusUpdated'] = "true";
        header("Location: order_products.php?ai=".$ai."&oid=".$oid."");
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
              <a href="orders.php?ai=<?php echo $ai; ?>&st=NA==">Orders</a>
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

            <?php
                $selectCartUser = $mysqli->query("SELECT * FROM orders WHERE order_no = '$order_no'");
                $rowUserID = mysqli_fetch_array($selectCartUser);

                if($rowUserID['status'] == 0){
                    $status = 'Pending';
                }else if($rowUserID['status'] == 1){
                    $status = 'Processing';
                }else if($rowUserID['status'] == 2){
                    $status = 'Out for delivery';
                }else if($rowUserID['status'] == 3){
                    $status = 'Received';
                }


                $usID = $rowUserID['userID'];
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

            <div class="alert alert-success text-center text-uppercase"><?php echo $status; ?></div>
            
            
            <div class="content" id="contentID">

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

                                        <button type="button" name="update_status" class="btn btn-success m-0 checkout" data-bs-toggle="modal" data-bs-target="#updateStatus">Update Status</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

            </div>

        </div>
    
    </div>

    <?php

        if(isset($_GET['oid'])){
            $oid = $_GET['oid'];
        }
    ?>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="order_products.php?ai=<?php echo $ai; ?>&oid=<?php echo $oid; ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark fs-6 m-0 p-0">Status</p>
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option selected disabled>Select Status</option>
                        <option value="0">Pending</option>
                        <option value="1">Processing</option>
                        <option value="2">Out for delivery</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="saveStatus" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php			
      if(isset($_SESSION['statusUpdated'])) {
        echo '<script type="text/javascript">
          swal("Success!", "Status Updated", "success");
        </script>';
        unset($_SESSION['statusUpdated']);
      } 

    ?>


  </body>
</html>