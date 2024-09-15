<?php
    include("header.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if (!isset($_SESSION["loggedin"])) {
        echo "
            <script>
            Swal.fire({
                title: 'Error',
                text: 'Please log in.',
                icon: 'error'
            }).then(function() {
            location.href = 'login.php'
            })
            </script>";
    }
    
    $shipping_total = 0.00;
    $sName = $sPhone = $sAdd = $sZip = $sMethod = "";
    $sNameERR = $sPhoneERR = $sAddERR = $sZipERR = $sMethodERR = "";

    $sqL = "SELECT * FROM user WHERE id = ". $_SESSION['id'];
    $resUlt = mysqli_query($link, $sqL);
    $rOw = mysqli_fetch_assoc($resUlt);
    
    if ($rOw['verify'] != 'yes') {
        echo '<script>
            Swal.fire({
                title: "Email Verification",
                text: "You have not verified your email. Do you want to proceed to the verification page?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, proceed!",
                cancelButtonText: "No, cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "verifyemail.php";
                } else {
                    Swal.fire("Verification pending", "You will not receive a digital receipt until your email is verified. Thank you for your attention..", "info");
                    // You can add additional actions here or leave it empty to simply close the dialog.
                }
            });
        </script>';
    }
?>

        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Cart Details</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.html">Home</a></li>
                    <li class="active">Cart</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

        <!--cart-checkout-area start -->
        <div class="cart-checkout-area  pt-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-area">
                            <div class="content-tab-product-category pb-70">
                                <!-- Tab panes -->
                                <div class="row">
                                    <form action="" method="post">
                                        <div class="col-lg-12">
                                            <div class="checkout-payment-area">
                                                <div class="checkout-total mt20">
                                                    <h3><b>Your order</b></h3>
                                                    <div class="table-responsive">
                                                        <table class="checkout-area table">
                                                            <thead>
                                                                <tr class="cart_item check-heading">
                                                                    <td class="ctg-type"> Product</td>
                                                                    <td class="cgt-des"> Total</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                                    <?php 
                                                                        $totaL = 0.00; $stotaL = 0.00;
                                                                        $sqle = "SELECT * FROM cart INNER JOIN product ON cart.item = product.item_id WHERE paid = 'no' AND uid = ".$_SESSION["id"];
                                                                        $resulte = mysqli_query($link, $sqle);
                                                                        if(mysqli_num_rows($resulte)>0)
                                                                        {
                                                                            while($rowe = mysqli_fetch_assoc($resulte))
                                                                            {
                                                                                
                                                                                $totaL = $rowe['cost'] * $rowe['quantity']; 
                                                                                $stotaL += $totaL;
                                                                                echo '
                                                                                <tr class="cart_item check-item prd-name">
                                                                                <td class="ctg-type">'.$rowe['item'].' *
                                                                                <span>'.$rowe['quantity'].'</span></td>
                                                                                <td class="cgt-des"> RM '.$totaL.'</td>
                                                                                </tr>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    
                                                                
                                                                <tr class="cart_item">
                                                                    <td class="ctg-type"> Subtotal</td>
                                                                    <td class="cgt-des"><?php echo 'RM '.$stotaL;?></td>
                                                                </tr>
                                                                <!--<tr class="cart_item">
                                                                    <td class="ctg-type">Shipping</td>
                                                                    <td class="cgt-des ship-opt">
                                                                        <div class="shipp">
                                                                            <input type="radio"
                                                                                id="pay-toggle" name="ship">
                                                                            <label for="pay-toggle">Flat
                                                                                Rate:
                                                                                <span>$03</span></label>
                                                                        </div>
                                                                        <div class="shipp">
                                                                            <input type="radio"
                                                                                id="pay-toggle2"
                                                                                name="ship">
                                                                            <label for="pay-toggle2">Free
                                                                                Shipping</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>-->
                                                                <tr class="cart_item">
                                                                    <td class="ctg-type crt-total"> Total (include shipping fees)
                                                                    </td>
                                                                    <td class="cgt-des prc-total"> <?php 
                                                                            
                                                                            $shipping = 0.00; 
                                                                        
                                                                            if($stotaL <= 299) 
                                                                            {
                                                                                $shipping = 5.00;
                                                                            }
                                                                            else if($stotaL >= 300)
                                                                            {
                                                                                $shipping = 0.00;
                                                                            }
                                                                            $shipping_total = $shipping + $stotaL;
                                                                            echo 'RM '.$shipping_total;
                                                                            ?>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="billing-details">
                                                            <div class="contact-text right-side">
                                                                <h3><b>Shipping Details</b></h3>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="input-box mb-20">
                                                                                <label>Recipient Name
                                                                                    <em>*</em></label>
                                                                                <input type="text"name="namm" class="info" placeholder="John Doe" required>
                                                                                <span class="invalid-feedback d-block"><?php echo $sNameERR; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="input-box mb-20">
                                                                                <label>Phone Number<em>*</em></label>
                                                                                <input type="text" name="phone" class="info" placeholder="+60123456789" required>
                                                                                <span class="invalid-feedback d-block"><?php echo $sPhoneERR; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="input-box mb-20">
                                                                                <label>Address
                                                                                    <em>*</em></label>
                                                                                <input type="text" name="add1" class="info mb-10" placeholder="Street Address" required>
                                                                                <span class="invalid-feedback d-block"><?php echo $sAddERR; ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="input-box">
                                                                                <label>Post Code/Zip
                                                                                    Code<em>*</em></label>
                                                                                <input type="text" name="zipcode" class="info" placeholder="Zip Code" required>
                                                                                <span class="invalid-feedback d-block"><?php echo $sZipERR; ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payment-section mt-20 clearfix">
                                                    <div class="pay-toggle">
                                                        <div class="pay-type-total">
                                                            <label><b>Payment Method:</b> </label>
                                                            <select id="pay-type" name=methods required>
                                                                <option value="Direct Bank Transfer" name="bank">Direct Bank Transfer</option>
                                                                <option value="Cash On Delivery" name="cash">Cash On delivery</option>
                                                                <option value="#" selected="">Select your method</option>
                                                            </select>
                                                        </div>
                                                        <div id="payContainer" style="display: none;">
                                                            <!-- Display FPX content here -->
                                                            <div class="input-box mt-20" id="fpxOption" style="display: none;">
                                                                <!-- FPX input fields go here -->
                                                                <button class="hidden-print btn btn-info" id="payment-form">FPX</button>
                                                            </div>

                                                            <div class="input-box mt-20">
                                                                <input type="submit" name="orders" style="background-color: gray;" class="btn btn-dark" value="Place Order">
                                                            </div>
                                                        </div>
                                                        <?php
                                                            date_default_timezone_set("Asia/Kuala_Lumpur");
                                                            $dates = date('Y-m-d H:i:s'); //Use this for default created 

                                                            // Unix timestamp for January 1, 2022, at 00:00:00
                                                            $start = strtotime('2022-01-01 00:00:00');

                                                            // Unix timestamp for December 31, 2024, at 23:59:59
                                                            $end = strtotime('2023-12-31 23:59:59');

                                                            // Generate a random timestamp between the start and end
                                                            $randomTimestamp = mt_rand($start, $end);

                                                            // Format the random timestamp as a MySQL datetime string
                                                            $randomDateTime = date('Y-m-d H:i:s', $randomTimestamp);

                                                            
                                                            $paidid = $_SESSION['id'];

                                                            if(isset($_POST['orders']))
                                                            {

                                                                if(empty($_POST['namm']))
                                                                {
                                                                    $sNameERR = "Please enter your name.";
                                                                }
                                                                elseif(strlen(trim($_POST['namm'])) == 0)
                                                                {
                                                                    $sNameERR = "Please enter name";
                                                                }
                                                                else
                                                                {
                                                                    $sName = trim($_POST['namm']);
                                                                }

                                                                $phonePattern = '/^\+\d{1,3}\d{9}$/';
                                                                if(empty($_POST['phone']))
                                                                {
                                                                    $sPhoneERR = "Please enter your phone number.";
                                                                }
                                                                elseif(strlen(trim($_POST['phone'])) == 0)
                                                                {
                                                                    $sPhoneERR = "Please enter your phone number.";
                                                                }
                                                                elseif (!preg_match($phonePattern, $_POST['phone'])) 
                                                                {
                                                                    $sPhoneERR = "Please enter a valid 10-digit phone number.";
                                                                }
                                                                else
                                                                {
                                                                    $sPhone = trim($_POST['phone']);
                                                                }

                                                                if(empty($_POST['add1']))
                                                                {
                                                                    $sAddERR = "Please enter shipping address.";
                                                                }
                                                                elseif(strlen(trim($_POST['add1'])) == 0)
                                                                {
                                                                    $sAddERR = "Please enter shipping address.";
                                                                }
                                                                else
                                                                {
                                                                    $sAdd = trim($_POST['add1']);
                                                                }

                                                                if(empty($_POST['zipcode']))
                                                                {
                                                                    $sZipERR = "Please enter shipping Postal Code/Zip Code.";
                                                                }
                                                                elseif(strlen(trim($_POST['zipcode'])) == 0)
                                                                {
                                                                    $sZipERR = "Please enter shipping Postal Code/Zip Code.";
                                                                }
                                                                else
                                                                {
                                                                    $sZip = trim($_POST['zipcode']);
                                                                }

                                                                $sMethod = $_POST['methods'];

                                                                if(empty($sNameERR) && empty($sPhoneERR) && empty($sAddERR) && empty($sZipERR))
                                                                {
                                                                    $sqls = "INSERT INTO orders (recipient_name, phoneNo, total, addresses, postcode, methods, status, created, UID) VALUES ('$sName', '$sPhone', '$shipping_total', '$sAdd', '$sZip', '$sMethod', 'To Ship', '$dates',".$_SESSION['id'].")";
                                                                    if(mysqli_query($link,$sqls))
                                                                    {
                                                                        $order_id = mysqli_insert_id($link);
                                                                        $paid = "UPDATE cart SET paid = 'yes' WHERE uid = $paidid;";
                                                                        if(mysqli_query($link, $paid))
                                                                        {
                                                                            $not_paid = "SELECT * FROM cart INNER JOIN product ON cart.item = product.item_id WHERE paid = 'yes' AND uid = ".$_SESSION['id'];
                                                                            $results = mysqli_query($link, $not_paid);
                                                                            if(mysqli_num_rows($results)>0)
                                                                            {
                                                                                while($rowww = mysqli_fetch_assoc($results))
                                                                                {
                                                                                    $itemIDs = $rowww['item_id'];
                                                                                    $qtys = $rowww['quantity'];
                                                                                    $receipt = "INSERT INTO receipt (order_id, item_id, quantity) VALUES('$order_id', '$itemIDs', '$qtys')";
                                                                                    mysqli_query($link,$receipt);

                                                                                    $cItem = "SELECT * FROM product WHERE item_id = '$itemIDs'";
                                                                                    $cResult = mysqli_query($link, $cItem);
                                                                                    $cRow = mysqli_fetch_assoc($cResult);

                                                                                    $cSold = "UPDATE product SET cSold = " . $cRow['cSold'] . " + " . $qtys . " WHERE item_id = " . $itemIDs;
                                                                                    mysqli_query($link, $cSold);
                                                                                    
                                                                                    $delete_cart = "DELETE FROM cart WHERE paid = 'yes'";
                                                                                    mysqli_query($link, $delete_cart);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    require 'phpmailer/src/PHPMailer.php';
                                                                    require 'phpmailer/src/SMTP.php';
                                                                    $mail = new PHPMailer(true);


                                                                    //Server settings
                                                                    $mail->isSMTP();                              //Send using SMTP
                                                                    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
                                                                    $mail->SMTPAuth   = true;             //Enable SMTP authentication
                                                                    $mail->Username   = 'rex010109@gmail.com';   //SMTP write your email
                                                                    $mail->Password   = 'jlxqwodubbnbbflr';      //SMTP password
                                                                    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
                                                                    $mail->Port       = 465;                                    
                                                                
                                                                    //Recipients
                                                                    $mail->setFrom('noreply@example.com', 'HypeHaven');
                                                                    $mail->addAddress($_SESSION['email']);     //Add a recipient email  
                                                                
                                                                    //Content
                                                                    $mail->isHTML(true);               //Set email format to HTML
                                                                    $mail->Subject = 'E-Receipt';   // email subject headings
                                                                    $mail->Body    = '
                                                                    <html lang="en">
                                                                    <head>
                                                                        <meta charset="UTF-8">
                                                                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                                        <title>Order Confirmation</title>
                                                                    </head>
                                                                    <body style="padding: 20px; background-color: #f2f2f2; width: 400px; color: #333; font-family: Arial, sans-serif; margin: auto;">
                                                                    
                                                                        <p>Your order from HypeHaven Clothing Co. has been confirmed.</p>
                                                                    
                                                                        <p>You can track your order status on our website by providing your Order ID: <b>'.$order_id.'</b></p>
                                                                    
                                                                        <p>Enjoy your stay on our website!</p>
                                                                    
                                                                        <p>If this email was not initiated by you, please ignore it.</p>
                                                                    
                                                                        <p>Thank you for choosing HypeHaven Clothing Co.!</p>
                                                                    
                                                                        <p style="color: #777;">Best regards,<br>HypeHaven Clothing Co. Team</p>
                                                                    
                                                                    </body>
                                                                    </html>
                                                                    ';
                                                                    $mail->send(); //email message
                                                                    
                                                                    $activeTimeFrame = date('Y-m-d H:i:s'); 
                                                                    $actOrder = "INSERT INTO userlogs (userid, activity, times) VALUES (".$_SESSION['id'].", 'have place an order $order_id', '$activeTimeFrame')";
                                                                    mysqli_query($link,$actOrder);

                                                                    echo "
                                                                    <script>
                                                                    Swal.fire({
                                                                        title: 'Successful',
                                                                        text: 'Your order will be shipped soon. A digital receipt have sent to your email.',
                                                                        icon: 'success'
                                                                    }).then(function() {
                                                                    location.href = 'my-orderDetails.php?order_id=$order_id'
                                                                    })
                                                                    </script>";

                                                                    //$not_paid = "SELECT * FROM cart INNER JOIN product ON cart.item = product.item_id WHERE paid = 'no' AND uid = ".$_SESSION['id'];
                                                                   // $results = mysqli_query($link, $not_paid);
                                                                   // if(mysqli_num_rows($results)>0)
                                                                   // {
                                                                    //    while($rowww = mysqli_fetch_assoc($results))
                                                                    //    {
                                                                     //       $itemIDs = $rowww['item_id'];
                                                                     //       $qtys = $rowww['quantity'];
                                                                     //       $receipt = "INSERT INTO receipt (order_id, item_id, quantity) VALUES('$order_id', '$itemIDs', '$qtys')";
                                                                     //       if(mysqli_query($link,$receipt))
                                                                    //        {
                                                                    //            
                                                                     //       }
                                                                    //    }
                                                                  //  }
                                                        

                                                                }
                                                                else
                                                                {
                                                                    echo "  
                                                                        <script>
                                                                            Swal.fire({
                                                                                title: 'Invalid input',
                                                                                text: 'Please enter your shipping details and check your phone number formats',
                                                                                icon: 'error'
                                                                            }).then(function() {
                                                                            location.href = 'complete-order.php'
                                                                            })
                                                                        </script>  
                                                                        ";
                                                                }
                                                                
                                                            }

                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--cart-checkout-area end-->

        <!-- footer area start-->
        <?php include('footer.php')?>
        <!--footer bottom area end-->

    </div>
    <!-- Body main wrapper end -->

    <!-- Placed js at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.6.0.min.js"></script>
    <script src="js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Slider js -->
    <script src="js/slider/jquery.nivo.slider.pack.js"></script>
    <script src="js/slider/nivo-active.js"></script>
    <!-- counterUp-->
    <script src="js/jquery.countdown.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

    <script>
    document.getElementById("pay-type").addEventListener("change", function() {
        var selectedOption = this.value;
        var payContainer = document.getElementById("payContainer");

        if (selectedOption !== "#") {
            payContainer.style.display = "block";

            // Check if the selected option is "Direct Bank Transfer"
            if (selectedOption === "Direct Bank Transfer") {
                // Display the FPX content
                document.getElementById("fpxOption").style.display = "block";
            } else {
                // Hide the FPX content for other options
                document.getElementById("fpxOption").style.display = "none";
            }
        } else {
            payContainer.style.display = "none";
            // Hide the FPX content when no option is selected
            document.getElementById("fpxOption").style.display = "none";
        }
    });
</script>
</body>

</html>