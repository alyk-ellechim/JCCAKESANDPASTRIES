<?php

include '../admin/functions/db_Connection.php'; 
session_start();

if(isset($_GET['ai'])){
  $ai = mysqli_escape_string($mysqli, $_GET['ai']);
}
 
if(isset($_POST['addProduct'])){

  $name = $_POST['name'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];

  $image = $_FILES['image']['name'];
  $image_type = $_FILES['image']['type'];
  $image_size = $_FILES['image']['size'];
  $image_loc = $_FILES['image']['tmp_name'];
  $image_store = "../../product_Images/".$image;

  if($image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/jpg' || $image_type == 'image/gif'){
    $insertProduct = $mysqli->query("INSERT INTO products(name, description, category, price, img) VALUES('$name', '$description', '$category','$price', '$image' )");
   
    move_uploaded_file($image_loc, $image_store);
    if($insertProduct){

      $_SESSION['success'] = '<div class="alert alert-success">New Product Added</div>';
      header("Location: products.php");
      exit();

    }else{
        echo "False";
    }
  }else{
    $_SESSION['feedback'] = '<p id="error">Invalid file type</p>';

    // echo "Invalid File Type";
  }

  

}elseif(isset($_POST['editProduct'])){
  $id = $_POST['editProduct'];

  $selectProductEdit = $mysqli->query("SELECT * FROM products WHERE id = '$id'")
  or die("Failed to query database" .mysql_error());
  $rowEdit = mysqli_fetch_array($selectProductEdit);

  $editModal = "true";

}elseif(isset($_POST['updateProduct'])){

  $id = $_POST['prodID'];

  $name = $_POST['name'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];

  $image = $_FILES['image']['name'];
  $image_type = $_FILES['image']['type'];
  $image_size = $_FILES['image']['size'];
  $image_loc = $_FILES['image']['tmp_name'];
  $image_store = "../../product_Images/".$image;
  
  if($image != ""){
    $updateProduct = $mysqli->query("UPDATE products SET name = '$name', category = '$category', price = '$price', img = '$image' WHERE id = '$id'");
    move_uploaded_file($image_loc, $image_store);
  }else{
      $updateProduct = $mysqli->query("UPDATE products SET name = '$name', category = '$category', price = '$price' WHERE id = '$id'");
  }


  if($updateProduct){

    $_SESSION['success'] = '<div class="alert alert-success">Product Saved</div>';
    header("Location: products.php");
    exit();

  }else{
      echo "False";
  }
}elseif(isset($_POST['delProduct'])){

  $id = $_POST['prodID'];
  $deleteProduct = $mysqli->query("DELETE FROM products WHERE id = '$id'");

  if($deleteProduct){
    $_SESSION['success'] = '<div class="alert alert-success">Product Deleted</div>';
    header("Location: products.php");
    exit();
  }
}

if(isset($_POST['delProductBtn'])){

  $id = $_POST['delProductBtn'];
  $deleteModal = "true";
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

	          <li>
	              <a href="dashboard.php?ai=<?php echo $ai; ?>">Dashboard</a>
	          </li>

	          <li class="active">
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

            <div class="collapse navbar-collapse" id="navbarSupportedContent">


              <p class="nav navbar-nav ml-auto fs-5 fw-bold">Welcome Admin!</p>

            </div>
          </div>
        </nav>

        <h2 class="mb-4">Products</h2>
        
        <div class="content" id="contentID">

        <?php
          if(isset($_SESSION['success'])){
            echo $_SESSION['success'];
            unset($_SESSION['success']);
          }
        ?>

        <div class="card">
            <h5 class="card-header  d-flex justify-content-between align-items-center">
                All Products
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddProductModal">Add Product</button>
            </h5>
            <div class="card-body text-center overflow-auto" style="height: 410px;">
                <!-- Products --> 

            <?php
                $selectProduct = $mysqli->query("SELECT * FROM products")
                or die("Failed to query database" .mysql_error());
                $row = mysqli_fetch_array($selectProduct);
                $hold = "";
                    
                if(mysqli_num_rows($selectProduct) == 0){
                    echo "<tr>
                    <td class='tm-product-name'>No Product Available</td></tr>"; 
                                    
                }else{
                    do{
                        $new_product = '<div class="card d-inline-block my-sm-4 mx-sm-2 text-start" style="width: 18rem; ">
                        <img src="../../product_Images/'.$row['img'].'" class="card-img-top" alt="Product Image" style="height: 150px; width: 100%; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text">'.$row['description'].'</p>
                            <p class="card-text fs-6">&#8369; '.$row['price'].'.00</p>
                            <form action="products.php" method="POST">
                            <button type="submit" name="editProduct" value="'.$row['id'].'" class="btn text-white" style="background-color: blue;">Edit</button>
                            <button type="submit" name="delProductBtn" value="'.$row['id'].'" class="btn btn-danger">Delete</button>
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


        <!-- Add Product Modal -->
        <div class="modal fade" id="AddProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form class="needs-validation" method="POST" action="products.php" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" required autofocus class="form-control" id="name" placeholder="Product Name">
                    </div>

                    <div class="mb-3">
                      <label for="desc" class="form-label">Description</label>
                      <textarea class="form-control" id="desc" name="description" placeholder="Description" rows="3" required autofocus></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="price" class="form-label">Price</label>
                      <input type="number" name="price" required autofocus class="form-control" id="price" placeholder="Price">
                    </div>

                    <div class="mb-3">
                      <label for="selectCat" class="form-label">Category</label>
                      <select id="selectCat" name="category" class="form-select" required autofocus>
                      <option value="" disabled selected>Select Category</option>
                        <option value="cake">Cake</option>
                        <option value="pastry">Pastry</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="productImage" class="form-label">Product Image</label>
                      <input class="form-control" name="image" required autofocus type="file" id="productImage">
                    </div>

                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="addProduct" class="btn btn-success">Save changes</button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <!-- Edit Product Modal -->
        <div class="modal fade" id="EditProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form class="needs-validation" method="POST" action="products.php" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="mb-3">
                      <label for="name" class="form-label">Name</label>
                      <input type="text" name="name" value="<?php echo $rowEdit['name']; ?>" required autofocus class="form-control" id="name" placeholder="Product Name">
                    </div>

                    <div class="mb-3">
                      <label for="desc" class="form-label">Description</label>
                      <textarea class="form-control" id="desc" name="description" placeholder="Description" rows="3" required autofocus><?php echo $rowEdit['description']; ?></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="price" class="form-label">Price</label>
                      <input type="number" name="price" value="<?php echo $rowEdit['price']; ?>" required autofocus class="form-control" id="price" placeholder="Price">
                    </div>

                    <div class="mb-3">
                      <label for="selectCat" class="form-label">Category</label>
                      <select id="selectCat" name="category" class="form-select text-capitalize">
                        <option value="<?php echo $rowEdit['category']; ?>"><?php echo $rowEdit['category']; ?></option>
                        <option value="cake">Cake</option>
                        <option value="pastry">Pastry</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label for="productImage" class="form-label">Product Image</label>
                      <input class="form-control" name="image" type="file" id="productImage">
                    </div>

                </div>

                <input type="hidden" name="prodID" value="<?php echo $rowEdit['id']; ?>">

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="updateProduct" class="btn btn-success">Save changes</button>
                </div>

              </form>
            </div>
          </div>
        </div>

        <!-- Delete Product Modal -->
        <div class="modal fade" id="DelteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form class="needs-validation" method="POST" action="products.php" enctype="multipart/form-data">

                <div class="modal-body">

                      <h5 class="text-center">Are you sure?</h5>

                </div>

                <input type="hidden" name="prodID" value="<?php echo $id; ?>">

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" name="delProduct" class="btn btn-danger">Delete</button>
                </div>

              </form>
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

    <?php			
      if(!empty($editModal)) {
        // CALL MODAL HERE
        echo '<script type="text/javascript">
          $(document).ready(function(){
            $("#EditProductModal").modal("show");
          });
        </script>';
      } 

      if(!empty($deleteModal)) {
        // CALL MODAL HERE
        echo '<script type="text/javascript">
          $(document).ready(function(){
            $("#DelteProductModal").modal("show");
          });
        </script>';
      } 
    ?>
  </body>
</html>