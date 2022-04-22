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

	          <li>
	              <a href="dashboard.php">Dashboard</a>
	          </li>

	          <li class="active">
              <a href="products.php">Products</a>
	          </li>
	          <li>
              <a href="#">Orders</a>
	          </li>
	        </ul>

	        <div class="footer">
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


              <p class="nav navbar-nav ml-auto fs-5 fw-bold">Welcome Admin!</p>

            </div>
          </div>
        </nav>

        <h2 class="mb-4">Products</h2>
        
        <div class="content" id="contentID">

        <div class="card">
            <h5 class="card-header  d-flex justify-content-between align-items-center">
                Featured
                <button class="btn btn-success">Add Product</button>
            </h5>
            <div class="card-body text-center overflow-auto" style="height: 410px;">
                <!-- Products --> 


                <div class="card d-inline-block mx-sm-2" style="width: 18rem; ">
                    <img src="../../images/choco.jpg" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Chocolate Cake</h5>
                        <p class="card-text fs-6">&#8369; 150.00</p>
                        <a href="#" class="btn text-white" style="background-color: blue;">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>

                <div class="card d-inline-block my-sm-4 mx-sm-2" style="width: 18rem;">
                    <img src="../../images/choco.jpg" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Chocolate Cake</h5>
                        <p class="card-text fs-6">&#8369; 150.00</p>
                        <a href="#" class="btn text-white" style="background-color: blue;">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>

                <div class="card d-inline-block my-sm-4 mx-sm-2" style="width: 18rem;">
                    <img src="../../images/choco.jpg" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Chocolate Cake</h5>
                        <p class="card-text fs-6">&#8369; 150.00</p>
                        <a href="#" class="btn text-white" style="background-color: blue;">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                </div>

                <div class="card d-inline-block my-sm-4 mx-sm-2" style="width: 18rem;">
                    <img src="../../images/choco.jpg" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Chocolate Cake</h5>
                        <p class="card-text fs-6">&#8369; 150.00</p>
                        <a href="#" class="btn text-white" style="background-color: blue;">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
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