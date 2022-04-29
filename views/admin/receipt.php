<?php


include 'functions/db_Connection.php'; 

    if(isset($_GET['oid'])){
        $order_no = base64_decode($_GET['oid']);
    }

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

        if($rowUserID['MOP'] == 'COD'){
            $mop = 'Cash on delivery';
        }else{
            $mop = 'Paypal';
        }

        $instruction = $rowUserID['instruction'];
    }

    date_default_timezone_set('Asia/Manila');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <title>Receipt</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script src="../js/invoice_print.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>



    <style>
        body{
            margin-top:20px;
            color: #484b51;
        }
        .text-secondary-d1 {
            color: #728299!important;
        }
        .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: .5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }
        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }
        .brc-default-l1 {
            border-color: #dce9f0!important;
        }

        .ml-n1, .mx-n1 {
            margin-left: -.25rem!important;
        }
        .mr-n1, .mx-n1 {
            margin-right: -.25rem!important;
        }
        .mb-4, .my-4 {
            margin-bottom: 1.5rem!important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0,0,0,.1);
        }

        .text-grey-m2 {
            color: #888a8d!important;
        }

        .text-success-m2 {
            color: #86bd68!important;
        }

        .font-bolder, .text-600 {
            font-weight: 600!important;
        }

        .text-110 {
            font-size: 110%!important;
        }
        .text-blue {
            color: #478fcc!important;
        }
        .pb-25, .py-25 {
            padding-bottom: .75rem!important;
        }

        .pt-25, .py-25 {
            padding-top: .75rem!important;
        }
        .bgc-default-tp1 {
            background-color: rgba(121,169,197,.92)!important;
        }
        .bgc-default-l4, .bgc-h-default-l4:hover {
            background-color: #f3f8fa!important;
        }
        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }
        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120%!important;
        }
        .text-primary-m1 {
            color: #4087d4!important;
        }

        .text-danger-m1 {
            color: #dd4949!important;
        }
        .text-blue-m2 {
            color: #68a3d5!important;
        }
        .text-150 {
            font-size: 150%!important;
        }
        .text-60 {
            font-size: 60%!important;
        }
        .text-grey-m1 {
            color: #7b7d81!important;
        }
        .align-bottom {
            vertical-align: bottom!important;
        }

    </style>
</head>
<body>
    <div class="page-content container my-5">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                Order
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    No: <?php echo $order_no; ?>
                </small>
            </h1>

            <div class="page-tools">
                <div class="action-buttons">
                    <!-- <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        Print
                    </a> -->
                    <a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">
                        <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                        Export
                    </a>
                </div>
            </div>
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <!-- <i class="fa fa-book fa-2x text-success-m2 mr-1"></i> -->
                                <span class="text-default-d3">JC Cakes and Pastries</span>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span class="text-600 text-110 text-blue align-middle"><?php echo $name; ?></span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    <?php echo $address; ?>
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?php echo $phone; ?></b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Order
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">No:</span> #<?php echo $order_no; ?></div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span> <?php echo date('Y-m-d'); ?></div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <?php echo $status; ?></div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

    

                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Product Name</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                            <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                            <div class="col-2">Amount</div>
                        </div>

                        <div class="text-95 text-secondary-d3">

                        <?php

                            $selectOrderProducts = $mysqli->query("SELECT * FROM order_products WHERE order_no = '$order_no'");

                            $total = 0;

                            $counter = 0;

                            if(mysqli_num_rows($selectOrderProducts) != 0){
                                while($rowOrderProduct = mysqli_fetch_array($selectOrderProducts)){
                                    $counter += 1;
                                    $prod_ID = $rowOrderProduct['prodID'];
                                    $selectProduct = $mysqli->query("SELECT * FROM products WHERE id = '$prod_ID'");

                                    if(mysqli_num_rows($selectProduct) != 0){
                                        $rowProd = mysqli_fetch_array($selectProduct);
                                        $totalPrice = $rowOrderProduct['qty'] * $rowProd['price'];


                                        echo '<div class="row mb-2 mb-sm-0 py-25">
                                                <div class="d-none d-sm-block col-1">'.$counter.'</div>
                                                <div class="col-9 col-sm-5">'.$rowProd['name'].'</div>
                                                <div class="d-none d-sm-block col-2">'.$rowOrderProduct['qty'].'</div>
                                                <div class="d-none d-sm-block col-2 text-95">&#8369; '.number_format($rowProd['price'], 2).'</div>
                                                <div class="col-2 text-secondary-d2">&#8369; '.number_format($totalPrice, 2).'</div>
                                            </div>';


                                        $total += $totalPrice;
                                    }
                                    
                                }
                            }


                            ?>


                        </div>

                        <div class="row border-b-2 brc-default-l2"></div>


                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                            
                            </div>

                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">&#8369; <?php echo number_format($total, 2); ?></span>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Delivery Fee
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">FREE</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">
                                        Total Amount
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">&#8369; <?php echo number_format($total, 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for your business</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>