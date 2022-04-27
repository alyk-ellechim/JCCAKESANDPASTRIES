<?php

include '../admin/functions/db_Connection.php';
include('../../smtp/PHPMailerAutoload.php');
session_start();

    if(isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
    
        $_SESSION['name_input'] = $name;
        $_SESSION['email_input'] = $email;
        $_SESSION['password_input'] = $password;


        $select_email = $mysqli->query("SELECT * FROM user WHERE email = '$email'");
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['email_feedback'] = '<p id="error">Invalid Email!</p>';
        }else{
            if(mysqli_num_rows($select_email) != 0){
                $_SESSION['email_feedback'] = '<p id="error">Email already in use!</p>';
            }
        }



        if(strlen($name) < 2){
            $_SESSION['name_feedback'] = '<p id="error">Firstname must be atleast 2 characters!</p>';
        
        }

        if(strlen($password) < 8) {
            $_SESSION['feedback'] = '<p id="error">password must be atleast 8 characters!</p>';
        }else if(strlen($password) > 7){
            if($password != $password2){
                $_SESSION['feedback'] = '<p id="error">password do not match!</p>';
            }
        }


        if(strlen($name) > 1 && strlen($password) > 7 && $password == $password2  && mysqli_num_rows($select_email) == 0){
            $name = $mysqli->real_escape_string($name);
            $email = $mysqli->real_escape_string($email);
            $password = $mysqli->real_escape_string($password);
            $password2 = $mysqli->real_escape_string($password2);
    
            $vkey = md5(time().$name);
    
            $password = md5($password);
            
            $insert_account = $mysqli->query("INSERT INTO user(name, email, password, vkey) VALUES ('$name', '$email', '$password', '$vkey')");
    
            if($insert_account){
               $message = "<a href='http://localhost/JCCAKESANDPASTRIES/views/auth/verify_account.php?vkey=$vkey'>Verify Account";
               smtp_mailer($email, 'Email Verification', $message); 
                unset($_SESSION['name_input']);
                unset($_SESSION['email_input']);
                unset($_SESSION['password_input']);
                echo '<script>alert("Registration Successful. Please verify your account at '.$email.'")</script>';
            }else{
                header("Location: login.php");
            }
        }

}


function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(true);
	//$mail->SMTPDebug = 1;
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "smtpjccakesandpastries@gmail.com"; 
	$mail->Password = "qwerty12345!@#$%";
	$mail->SetFrom("smtpjccakesandpastries@gmail.com");
	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		return 0;
	}else{
		return 1;
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
			      			<h3 class="mb-4">Register</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-google"></span></a>
									</p>
								</div>
			      	</div>
					<form action="register.php" method="POST" class="signin-form">

                    <div class="form-group mb-3">
			      			<label class="label" for="name">Name</label>
			      			<input type="text" name="name" class="form-control" placeholder="Name" required>
                              <?php

							if(isset($_SESSION['name_feedback'])){
								echo $_SESSION['name_feedback'];
								unset($_SESSION['name_feedback']);
							}

						    ?>
			      		</div>

			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Email</label>
			      			<input type="email" name="email" class="form-control" placeholder="Email" required>
                              <?php

							if(isset($_SESSION['email_feedback'])){
								echo $_SESSION['email_feedback'];
								unset($_SESSION['email_feedback']);
							}

						?>   

						<div class="form-group mb-3">
							<label class="label" for="password">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>

                        <div class="form-group mb-3">
							<label class="label" for="password">Confirm Password</label>
						<input type="password" name="password2" class="form-control" placeholder="Password" required>
                        <?php

							if(isset($_SESSION['feedback'])){
								echo $_SESSION['feedback'];
								unset($_SESSION['feedback']);
							}

						?>
						</div>

						

						<div class="form-group">
							<button type="submit" name="register" class="form-control btn btn-primary rounded submit px-3">Register</button>
						</div>
						
		          </form>
		          <p class="text-center">Already have an account? <a href="login.php">Login</a></p>
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

	</body>
</html>

