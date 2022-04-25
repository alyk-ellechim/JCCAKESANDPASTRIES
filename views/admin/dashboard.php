<?php

include '../admin/functions/db_Connection.php'; 

if(isset($_GET['ai'])){
    $ai = mysqli_escape_string($mysqli, $_GET['ai']);
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
		<link rel="stylesheet" href="../../css/style.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../../images/logo.png);"></a>
	        <ul class="list-unstyled components mb-5">
	          <!-- <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="#">Home 1</a>
                </li>
                <li>
                    <a href="#">Home 2</a>
                </li>
                <li>
                    <a href="#">Home 3</a>
                </li>
	            </ul>
	          </li> -->


	          <li class="active">
	              <a href="dashboard.php?ai=<?php echo $ai; ?>">Dashboard</a>
	          </li>


	          <!-- <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="#">Page 1</a>
                </li>
                <li>
                    <a href="#">Page 2</a>
                </li>
                <li>
                    <a href="#">Page 3</a>
                </li>
              </ul>
	          </li> -->

	          <li>
              <a href="products.php?ai=<?php echo $ai; ?>">Products</a>
	          </li>
	          <li>
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

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <!-- <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button> -->

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

              <!-- <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
              </ul> -->

              <p class="nav navbar-nav ml-auto fs-5 fw-bold">Welcome Admin!</p>

            </div>
          </div>
        </nav>

        <h2 class="mb-4">Dashboard</h2>
        
        <div class="content">


            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daily Sales</h5>
                            <p class="card-text fs-1">&#8369; 50.00</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mt-sm-0 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Order</h5>
                            <p class="card-text fs-1">10</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Processing</h5>
                            <p class="card-text fs-1">5</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mt-sm-0 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Out for Delivery</h5>
                            <p class="card-text fs-1">5</p>
                            <a href="#" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

      </div>
      
		</div>

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
  </body>
</html>