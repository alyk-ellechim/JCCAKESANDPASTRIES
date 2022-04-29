<?php

include 'functions/db_Connection.php'; 
session_start();

if(isset($_GET['ai'])){
  $ai = mysqli_escape_string($mysqli, $_GET['ai']);
}else{
  $ai = "";
  if(isset($_SESSION['ai'])){
    $ai = $_SESSION['ai'];
  }
}  


if(isset($_GET['st'])){
  $st = base64_decode($_GET['st']);
  if($st == 4){
    $status_query = '';
  }elseif($st == 0){
    $status_query = 'WHERE status = 0';
  }elseif($st == 1){
    $status_query = 'WHERE status = 1';
  }elseif($st == 2){
    $status_query = 'WHERE status = 2';
  }elseif($st == 3){
    $status_query = 'WHERE status = 3';
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

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
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

        <h2 class="mb-4">Orders</h2>
        
        <div class="content" id="contentID">

        <div class="date mb-2">
          <span style="font-size: 11pt;">From: <input type="date" class="p-1 rounded" id="fromDate" name="fromDate" style="border: 1px solid #ced4da;"></span>
          <span style="font-size: 11pt;">To: <input type="date" class="p-1 rounded" id="toDate" name="toDate" style="border: 1px solid #ced4da;"></span>
        </div>

        <div class="card">
            <h5 class="card-header  d-flex justify-content-between align-items-center">
                <span>Order List</span>
                <span><input type="search" class="p-1 rounded" id="search" name="search" placeholder="Search" style="font-size: 11pt; border: 1px solid #ced4da;"></span>
                <span>
                  <?php

                    if($st == 4){
                      echo '<select class="form-select" id="selectStatus" name="status" aria-label="Default select example">
                          <option selected disabled>All Orders</option>
                          <option value="0">Pending</option>
                          <option value="1">Processing</option>
                          <option value="2">Out for delivery</option>
                          <option value="3">Received</option>
                      </select>';
                    }elseif($st == 0){
                      echo '<select class="form-select" id="selectStatus" name="status" aria-label="Default select example">
                          <option value="4">All Orders</option>
                          <option selected disabled>Pending</option>
                          <option value="1">Processing</option>
                          <option value="2">Out for delivery</option>
                          <option value="3">Received</option>
                      </select>';
                    }elseif($st == 1){
                      echo '<select class="form-select" id="selectStatus" name="status" aria-label="Default select example">
                          <option value="4">All Orders</option>
                          <option value="0">Pending</option>
                          <option selected disabled>Processing</option>
                          <option value="2">Out for delivery</option>
                          <option value="3">Received</option>
                      </select>';
                    }elseif($st == 2){
                      echo '<select class="form-select" id="selectStatus" name="status" aria-label="Default select example">
                          <option value="4">All Orders</option>
                          <option value="0">Pending</option>
                          <option value="1">Processing</option>
                          <option selected disabled>Out for delivery</option>
                          <option value="3">Received</option>
                      </select>';
                    }elseif($st == 3){
                      echo '<select class="form-select" id="selectStatus" name="status" aria-label="Default select example">
                          <option value="4">All Orders</option>
                          <option value="0">Pending</option>
                          <option value="1">Processing</option>
                          <option value="2">Out for delivery</option>
                          <option selected disabled>Received</option>
                      </select>';
                    } 
                      

                  ?>
      
                </span>
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

                    <tbody class="orderTbody">

                        <?php

                            $select_orders = $mysqli->query("SELECT * FROM orders ".$status_query."");

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
                                    }else if($row_orders['status'] == 3){
                                      $status = 'Received';
                                    }


                                    echo '<tr>
                                            <th scope="row">'.$counter.'</th>
                                            <td>'.$row_orders['order_no'].'</td>
                                            <td>&#8369;'.number_format($total_price, 2).'</td>
                                            <td>'.$date_ordered.'</td>
                                            <td>'.$status.'</td>
                                            <td><a href="order_products.php?ai='.$ai.'&oid='.base64_encode($row_orders['order_no']).'" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>';
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

    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/popper.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>

      $(document).ready(function() {

        function calcTime(city, offset) {
            // create Date object for current location
            var d = new Date();

            // convert to msec
            // subtract local time zone offset
            // get UTC time in msec
            var utc = d.getTime() + (d.getTimezoneOffset() * 60000);

            // create new Date object for different city
            // using supplied offset
            var nd = new Date(utc + (3600000*offset));

            // return time as a string
            var day = ("0" + nd.getDate()).slice(-2);
            var month = ("0" + (nd.getMonth() + 1)).slice(-2);

            var today = nd.getFullYear()+"-"+(month)+"-"+(day) ;
            return today;
        }

        $('#fromDate').attr('max', calcTime('Philippines', '+8.0'));
        $('#toDate').attr('max', calcTime('Philippines', '+8.0'));
        $('#toDate').attr('min', calcTime('Philippines', '+8.0'));
        $('#toDate').val(calcTime('Philippines', '+8.0'));
        $('#fromDate').val(calcTime('Philippines', '+8.0'));

        $(document).on('change', '#fromDate', function() {

          var param = new URLSearchParams(window.location.search);
          var ai = param.get('ai');
          var st = param.get('st');

          $('.orderTbody').html('');

          var fromDate = $(this).val();

          $('#toDate').attr('min', fromDate);

          var toDate = $('#toDate').val();
          $.ajax({
              type: "POST",
              url: "functions/filter_date.php",
              data: {
                  from : fromDate,
                  to : toDate,
              },
              dataType: "json",
              encode: true,
              }).done(function (data) {

                  var counter = 0;

                  console.log(data);

                  $.each(data, function(key, order){
                    counter += 1;
                    var status = '';

                    if(order.status == 0){
                      status = 'Pending';
                    }else if(order.status == 1){
                      status = 'Processing';
                    }else if(order.status == 2){
                      status = 'Out for delivery';
                    }else if(order.status == 3){
                      status = 'Received';
                    } 

                    var created_at = new Date(order.date_ordered);
                    var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][created_at.getMonth()];
                    var date = (created_at.getMonth() + 1) + "/" + created_at.getDate() + "/" + created_at.getYear().toString().substr(-2) + " " + formatAMPM(created_at);

                    $('.orderTbody').append('<tr>\
                                              <th scope="row">'+counter+'</th>\
                                              <td>'+order.order_no+'</td>\
                                              <td>&#8369;'+Number(order.total_price).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
                                              <td>'+date+'</td>\
                                              <td>'+status+'</td>\
                                              <td><a href="order_products.php?ai='+ai+'&oid='+btoa(order.order_no)+'" class="btn btn-primary btn-sm">View</a></td>\
                                          </tr>');


                    

                  });


          });

          


        });   
        
        $(document).on('change', '#toDate', function() {

            var param = new URLSearchParams(window.location.search);
            var ai = param.get('ai');
            var st = param.get('st');

            $('.orderTbody').html('');

            var toDate = $(this).val();
            var fromDate = $('#fromDate').val();

            $.ajax({
                type: "POST",
                url: "functions/filter_date.php",
                data: {
                    from : fromDate,
                    to : toDate,
                },
                dataType: "json",
                encode: true,
                }).done(function (data) {

                    var counter = 0;

                    console.log(data);

                    $.each(data, function(key, order){
                      counter += 1;
                      var status = '';

                      if(order.status == 0){
                        status = 'Pending';
                      }else if(order.status == 1){
                        status = 'Processing';
                      }else if(order.status == 2){
                        status = 'Out for delivery';
                      }else if(order.status == 3){
                        status = 'Received';
                      } 

                      var created_at = new Date(order.date_ordered);
                      var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][created_at.getMonth()];
                      var date = (created_at.getMonth() + 1) + "/" + created_at.getDate() + "/" + created_at.getYear().toString().substr(-2) + " " + formatAMPM(created_at);

                      $('.orderTbody').append('<tr>\
                                                <th scope="row">'+counter+'</th>\
                                                <td>'+order.order_no+'</td>\
                                                <td>&#8369;'+Number(order.total_price).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
                                                <td>'+date+'</td>\
                                                <td>'+status+'</td>\
                                                <td><a href="order_products.php?ai='+ai+'&oid='+btoa(order.order_no)+'" class="btn btn-primary btn-sm">View</a></td>\
                                            </tr>');


                    });

            });
        });    

        $(document).on('change', '#selectStatus', function() {

          var param = new URLSearchParams(window.location.search);
          var ai = param.get('ai');
          var st = btoa($(this).val());
          location.href = "orders.php?ai="+ai+"&st="+st+"";
  
        });     

        function formatAMPM(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            return strTime;
        }


        $(document).on('input', '#search', function() {

          var param = new URLSearchParams(window.location.search);
          var ai = param.get('ai');
          var st = param.get('st');

          $('.orderTbody').html('');

          var search = $(this).val();
          
          if(!search.replace(/\s/g, '').length){
            search = null;
          }

          $.ajax({
              type: "POST",
              url: "functions/search.php",
              data: {
                  Search : search,
              },
              dataType: "json",
              encode: true,
              }).done(function (data) {
                  // $("#myCart").load(location.href + " #myCart > *");
                  // $("#cartTotal").load(location.href + " #cartTotal > *");
                  // console.log(data.results.length);

                  var counter = 0;

                  $.each(data, function(key, order){
                    counter += 1;
                    var status = '';

                    if(order.status == 0){
                      status = 'Pending';
                    }else if(order.status == 1){
                      status = 'Processing';
                    }else if(order.status == 2){
                      status = 'Out for delivery';
                    }else if(order.status == 3){
                      status = 'Received';
                    } 

                    var created_at = new Date(order.date_ordered);
                    var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"][created_at.getMonth()];
                    var date = (created_at.getMonth() + 1) + "/" + created_at.getDate() + "/" + created_at.getYear().toString().substr(-2) + " " + formatAMPM(created_at);

                    $('.orderTbody').append('<tr>\
                                              <th scope="row">'+counter+'</th>\
                                              <td>'+order.order_no+'</td>\
                                              <td>&#8369;'+Number(order.total_price).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</td>\
                                              <td>'+date+'</td>\
                                              <td>'+status+'</td>\
                                              <td><a href="order_products.php?ai='+ai+'&oid='+btoa(order.order_no)+'" class="btn btn-primary btn-sm">View</a></td>\
                                          </tr>');


                    

                  });


          });

        });   

      });


    </script>


  </body>
</html>