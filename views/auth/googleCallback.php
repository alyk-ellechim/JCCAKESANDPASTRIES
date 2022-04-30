<?php
include '../admin/functions/db_Connection.php';
session_start();
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $name = $_POST['firstname'] . ' ' . $_POST['lastname'];
    $password = $_POST['password'];
    $verified = 1;
    
    $check_login = $mysqli->query("SELECT * FROM user WHERE email = '$email' AND password = 'Google'");
    if(mysqli_num_rows($check_login) != 0){
      $row_login = mysqli_fetch_array($check_login);
      $id = $row_login['id'];
      $ui = base64_encode($id);
      $update = $mysqli->query("UPDATE user SET status='1' WHERE id='$id'");
      if($update){

        $check_cart = mysqli_query($mysqli, "SELECT * FROM cart WHERE userID = 0");

			  if(mysqli_num_rows($check_cart) != 0){
          while($cart_row = mysqli_fetch_array($check_cart)){
            $cart_id = $cart_row['id'];

            $update_cart = mysqli_query($mysqli, "UPDATE cart set userID = '$ui' WHERE id = '$cart_id'");
          }
				
			  }
        header("Location: ../../index.php?ui=$ui");
			  $_SESSION['ui'] = $ui;
      }
    }else{
        $check_email = $mysqli->query("SELECT * FROM user WHERE email = '$email' AND password != 'Google'");
        
        if(mysqli_num_rows($check_email) != 0){
        
            $row = mysqli_fetch_array($check_email);
            $un = $row["name"];
            
            echo "You already have an account with us";
            $_SESSION['error'] = "You already have an account with us. Your Username is '$un'";
        }else{
          $insert = $mysqli->query("INSERT INTO user(name, email, password, verified) VALUES ('$firstname', '$email', 'Google', '$verified')");
      
          if($insert){
            $select_org = $mysqli->query("SELECT * FROM user WHERE email = '$email' and password = 'Google'");
            $row_select = mysqli_fetch_array($select_org);
            if(mysqli_num_rows($select_org) != 0){
              $id = $row_select['id'];
              $org_id = base64_encode($id);
              $update = $mysqli->query("UPDATE user SET status='1' WHERE id='$id'");
              if($update){
                
                $check_cart = mysqli_query($mysqli, "SELECT * FROM cart WHERE userID = 0");

                if(mysqli_num_rows($check_cart) != 0){
                  while($cart_row = mysqli_fetch_array($check_cart)){
                    $cart_id = $cart_row['id'];

                    $update_cart = mysqli_query($mysqli, "UPDATE cart set userID = '$ui' WHERE id = '$cart_id'");
                  }
                
                }

                header("Location: ../../index.php?ui=$ui");
			          $_SESSION['ui'] = $ui;
        
              }
            }
            
          }
        }
      
      
    }
}


?>