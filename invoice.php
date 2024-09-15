<?php 

    include('db.php');


?>


<title>Invoice || Clothing</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" type="image/x-icon" href="images/icons/favicon.png">

<script src="pdf.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
<style type="text/css">
    	body{margin-top:20px;
background-color:#eee;
}

.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: 1rem;
}
    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<div class="container" >
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="content">
                <div class="card-body">
                    <div class="invoice-title">
                        <?php
                            $sql = "SELECT * FROM orders WHERE order_id = ".$_GET['invoice_id'];
                            $inv = mysqli_query($link, $sql);
                            $row = mysqli_fetch_assoc($inv);
                        ?>
                        <h4 class="float-end font-size-15">Order ID: <?=$row['order_id']?> <span class="badge bg-success font-size-12 ms-2">Paid</span></h4>

                        <div class="text-muted">
                            <p class="mb-1"><a href="index.php"><img src="images/logo/logo.png" alt=""></a></p><br>
                            <p class="mb-1">42 Jalan Harmoni,<br>
                            Taman Seri Melaka,<br>
                            75000 Melaka,
                            Malaysia</p>
                            <p><i class="uil uil-phone me-1"></i>+60123608370</p>
                        </div>
                    </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="text-muted">
                                    <h5 class="font-size-16 mb-3">To:</h5>
                                    <h5 class="font-size-15 mb-2"><?=$row['recipient_name']?></h5>
                                    <p class="mb-1"><?=$row['addresses']?></p>
                                    <p><?=$row['phoneNo']?></p>
                                </div>
                            </div>

                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                            <div>
                            <h5 class="font-size-15 mb-1">Order No:</h5>
                            <p id="rids"><?=$row['order_id']?></p>
                        </div>
                        <div class="mt-4">
                            <h5 class="font-size-15 mb-1">Order Date:</h5>
                            <p><?=$row['created']?></p>
                        </div>
                        <div class="mt-4">
                            <h5 class="font-size-15 mb-1">Payment Method:</h5>
                            <p><?=$row['methods']?></p>
                        </div>
                </div>
                        </div>

                        </div>

                        <div class="py-2">
                        <h5 class="font-size-15">Order Summary</h5>
                        <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-centered mb-0">
                        <thead>
                        <tr>
                        <th style="width: 70px;">No.</th>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end" style="width: 120px;">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sqls = "SELECT * FROM receipt INNER JOIN product ON receipt.item_id = product.item_id INNER JOIN orders ON receipt.order_id = orders.order_id WHERE orders.order_id = ".$_GET['invoice_id'];
                                $resultq = mysqli_query($link, $sqls);
                                
                                if(mysqli_num_rows($resultq) > 0) {
                                    $counter = 1; // Initialize counter variable before the loop
                                
                                    while($rows = mysqli_fetch_assoc($resultq)) {
                                        echo '
                                        <tr>
                                            <th scope="row">'.$counter.'</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1">'.$rows['item'].'</h5>
                                                </div>
                                            </td>
                                            <td>RM '.$rows['cost'].'</td>
                                            <td>'.$rows['quantity'].'</td>
                                            <td class="text-end">RM '.$rows['cost'] * $rows['quantity'].'</td>
                                        </tr>
                                        ';
                                
                                        $counter++; // Increment counter for the next iteration
                                    }
                                }
                            ?>


                        <tr>
                        <th scope="row" colspan="4" class="text-end">Sub Total</th>
                        <td class="text-end">RM <?=$row['total']?></td>
                        </tr>

                        <!--<tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                        Discount :</th>
                        <td class="border-0 text-end">- $25.50</td>
                        </tr>

                        <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                        Shipping Charge :</th>
                        <td class="border-0 text-end">$20.00</td>
                        </tr>

                        <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">
                        Tax</th>
                        <td class="border-0 text-end">$12.00</td>
                        </tr>-->

                        <tr>
                        <th scope="row" colspan="4" class="border-0 text-end">Total</th>
                        <td class="border-0 text-end"><h4 class="m-0 fw-semibold">RM <?=$row['total']?></h4></td>
                        </tr>

                        </tbody>
                        </table>
                        </div>
                        <div class="d-print-none mt-4">
                        <div class="float-end">
                        <a href="javascript:window.print()" class="btn btn-success me-1"><i class="fa fa-print"></i></a>
                        <button class="hidden-print btn btn-info" id="download">Download as PDF</button>
                        <a href="my-orderDetails.php?order_id=<?php echo $_GET['invoice_id']; ?>">
                        <i class="btn btn-primary w-md">Back</i>
                        </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
		function download() {
			var content = $("body").val();

			var val = htmlToPdfmake(content);

			var data = {content:val}
			
			pdfMake.createPdf(data).download();
		}
	</script>
</body>
</html>