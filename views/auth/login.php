<?php
include '../admin/functions/db_Connection.php';
session_start();

// Session
if(isset($_SESSION['email']) && isset($_SESSION['password'])){
	$email = $_SESSION['email'];
	$password = $_SESSION['password'];

	$check_admin = mysqli_query($mysqli, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
	if ($check_admin->num_rows > 0) {
		$row_admin = mysqli_fetch_array($check_admin);
		$ai = $row_admin['id'];
		$aid = base64_encode($row_admin['id']);
		$update_admin = mysqli_query($mysqli, "UPDATE admin set status = 1 WHERE id = '$ai'");
		
		if($update_admin){
		  	header("Location: ../admin/dashboard.php?ai=$aid");
			// echo "Admin Login";
			$_SESSION['ai'] = $aid;
			exit();

		}

	}else{
		$pass = md5($password);
		$sql = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
		$result = mysqli_query($mysqli, $sql);
		if ($result->num_rows > 0) {
		$row = mysqli_fetch_array($result);
		$id = base64_encode($row['id']);
		$ui = $row['id'];
	
		if($row['verified'] != 1){
			$_SESSION['feedback'] = '<p id="error">Account not verified</p>';
		}else{
			$update = mysqli_query($mysqli, "UPDATE user set status = 1 WHERE id = '$ui'");
		
			if($update){

			  $check_cart = mysqli_query($mysqli, "SELECT * FROM cart WHERE userID = 0");

			  if(mysqli_num_rows($check_cart) != 0){
				while($cart_row = mysqli_fetch_array($check_cart)){
					$cart_id = $cart_row['id'];

					$update_cart = mysqli_query($mysqli, "UPDATE cart set userID = '$ui' WHERE id = '$cart_id'");
				}
				
			  }

			  header("Location: ../../index.php?ui=$id");
			  $_SESSION['ui'] = $id;

			  
			}
		}
	
		}else{
			$_SESSION['feedback'] = '<p id="error">Incorrect email or password</p>';
		}
	}
}

// Login
if(isset($_POST['signIn'])){
	$email = $_POST['email'];
	$password = $_POST['password'];

	$check_admin = mysqli_query($mysqli, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
	if ($check_admin->num_rows > 0) {
		$row_admin = mysqli_fetch_array($check_admin);
		$ai = $row_admin['id'];
		$aid = base64_encode($row_admin['id']);
		$update_admin = mysqli_query($mysqli, "UPDATE admin set status = 1 WHERE id = '$ai'");
		
		if($update_admin){
		  	header("Location: ../admin/dashboard.php?ai=$aid");
			// echo "Admin Login";

			$_SESSION['email'] = $email;
			$_SESSION['password'] = $password;
			$_SESSION['ai'] = $aid;

		}

	}else{
		$pass = md5($password);
		$sql = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
		$result = mysqli_query($mysqli, $sql);
		if ($result->num_rows > 0) {
		$row = mysqli_fetch_array($result);
		$id = base64_encode($row['id']);
		$ui = $row['id'];
	
		if($row['verified'] != 1){
			$_SESSION['feedback'] = '<p id="error">Account not verified</p>';
		}else{
			$update = mysqli_query($mysqli, "UPDATE user set status = 1 WHERE id = '$ui'");
		
			if($update){
				$check_cart = mysqli_query($mysqli, "SELECT * FROM cart WHERE userID = 0");

				if(mysqli_num_rows($check_cart) != 0){
					while($cart_row = mysqli_fetch_array($check_cart)){
						$cart_id = $cart_row['id'];

						$update_cart = mysqli_query($mysqli, "UPDATE cart set userID = '$ui' WHERE id = '$cart_id'");
					}
				}

				header("Location: ../../index.php?ui=$id");
				$_SESSION['email'] = $email;
				$_SESSION['password'] = $password;
				$_SESSION['ui'] = $id;
			}
		}
	
		}else{
			$_SESSION['feedback'] = '<p id="error">Incorrect email or password</p>';
		}
	}


}

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>JC Cakes and Pastries</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../../css/login.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">

			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img d-flex justify-content-center align-items-center" style="background-color: #293a48;">
							<div class="img rounded-circle" style="height: 250px; width: 250px; background-image: url(../../images/logo.png);">
						</div>

						
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Login</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<button id="customBtn" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-google"></span></button>
									</p>
								</div>
			      	</div>
					<form action="login.php" method="POST" class="signin-form">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Email</label>
			      			<input type="email" name="email" class="form-control" placeholder="Email" required>
			      		</div>
						<div class="form-group mb-3">
							<label class="label" for="password">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>

						<?php

							if(isset($_SESSION['feedback'])){
								echo $_SESSION['feedback'];
								unset($_SESSION['feedback']);
							}

							if(isset($_SESSION['error'])){
								echo $_SESSION['error'];
								unset($_SESSION['error']);
							}

						?>

						<div class="form-group">
							<button type="submit" name="signIn" class="form-control btn btn-primary rounded submit px-3">Login</button>
						</div>

						<?php

							if(isset($_SESSION['verified'])){
								echo '<p class="text-center p-0 m-0 text-success" style="font-size: 10pt;">Account has been verified</p>';
								unset($_SESSION['verified']);
							}


						?>


						<div class="form-group d-md-flex">
							<div class="text-md-right">
								<a href="#">Forgot Password</a>
							</div>
						</div>
		          </form>
		          <p class="text-center">Don't have an account? <a href="register.php">Register</a></p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="../../js/jquery.min.js"></script>
  <script src="../../js/popper.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/main.js"></script>

  <script src="https://apis.google.com/js/api:client.js"></script>
    <script>
          var googleUser = {};
          var startApp = function() {
            gapi.load('auth2', function(){
              // Retrieve the singleton for the GoogleAuth library and set up the client.
              auth2 = gapi.auth2.init({
                client_id: '1080865035875-ejbml3gt0fist5u2m33c6k2kodc9nfpi.apps.googleusercontent.com',
                cookiepolicy: 'single_host_origin',
                // Request scopes in addition to 'profile' and 'email'
                //scope: 'additional_scope'
              });
              attachSignin(document.getElementById('customBtn'));
            });
          };
        
          function attachSignin(element) {
            auth2.attachClickHandler(element, {},
                function(googleUser) {
                  var profile = googleUser.getBasicProfile();
                  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                  console.log('Name: ' + profile.getName());
                  console.log('Given Name: ' + profile.getGivenName());
                  console.log('Family Name: ' + profile.getFamilyName());
                  console.log('Image URL: ' + profile.getImageUrl());
                  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
                  
                    var firstname = profile.getGivenName();
                    var lastname = profile.getFamilyName();
                    var email = profile.getEmail();
                    var password = profile.getId();

                    

                    $.ajax({
                        type : "POST",  //type of method
                        url  : "googleCallback.php",  //your page
                        data : { firstname : firstname, lastname : lastname, email : email, password : password },// passing the values
                        success: function(res){  
                             //do what you want here...
                             console.log(res);
                             if(res.includes("You already have an account with us")){
                                 window.location.href = "login.php";
                             }else{
                                 window.location.href = res;
                             }
                        }
                    });
                    
                    

                    
                });
          }
          
    </script>
    <script>startApp();</script>

	</body>
</html>

