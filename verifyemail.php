<?php

    /*$headers = 'From: noreply <noreply@gmail.com>' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';  // Set from headers

    $resultss = mail("liyuguangjie@gmail.com", "Hello world", "This is email body", $headers);
    var_dump($resultss);*/

    include("header.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $sqL = "SELECT * FROM user WHERE id = ". $_SESSION['id'];
    $resUlt = mysqli_query($link, $sqL);
    $rOw = mysqli_fetch_assoc($resUlt);
    
    if ($rOw['verify'] == 'yes') {
        echo "
        <script>
        Swal.fire({
            title: 'Account verified',
            text: 'Your account already verified.',
            icon: 'success'
        }).then(function() {
            location.href = 'index.php'
            })</script>";
    }
    //initialize all value
    $code_err = "";
    

    $n = 6;
    function getName($n)
    {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    $_SESSION["codes"] = "";

    if(isset($_POST['send']))
    {
        $_SESSION["codes"] = getName($n);

        $updatecode = "UPDATE user SET codes = ".$_SESSION["codes"]." WHERE id = ".$_SESSION['id'];
        mysqli_query($link, $updatecode);

        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';
        
        //Create an instance; passing `true` enables exceptions
        
            
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
            $mail->addAddress($_SESSION["email"]);     //Add a recipient email  
            $mail->addReplyTo($_SESSION["email"]); // reply to sender email
        
            //Content
            $mail->isHTML(true);               //Set email format to HTML
            $mail->Subject = 'E-mail Verification';   // email subject headings
            $mail->Body    = '
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Verification Code</title>
            </head>
            <body style="padding: 20px; background-color: #f2f2f2; width: 400px; color: #333; font-family: Arial, sans-serif; margin: auto;">

                <h2>Hello '.$_SESSION['email'].',</h2>

                <p>Here is your verification code to access your account:</p>

                <h1 style="font-size: 36px; color: #009688; text-align: center; margin: 10px 0;">'.$_SESSION['codes'].'</h1>

                <p>We have implemented this as an extra layer of security to your account, something we value extremely highly here on our website.</p>

                <p>Thank you for choosing HypeHaven!</p>

                <p style="color: #777;">Best regards,<br>HypeHaven Team</p>

            </body>
            </html>
            '; //email message
            
            // Success sent message alert
            $mail->send();

        echo "
        <script>
        Swal.fire({
            title: 'Code sent',
            text: 'Please check your email.',
            icon: 'success'
        })</script>";
    }

    $getcodes = "SELECT * FROM user WHERE id =". $_SESSION['id'];
    $resultCode = mysqli_query($link, $getcodes);
    $rowCode = mysqli_fetch_assoc($resultCode);

    if(isset($_POST['verifi']))
    {
        

        if(empty($_POST["codes"]))
        {
            $code_err = "<b>Please enter your verification code<b>";
        }
        elseif($_POST['codes'] != $rowCode['codes'])
        {
            $code_err = "<b>Invalid code, please check your email.<b>";
        }
        
        if(empty($code_err))
        {
            $verify = "UPDATE user SET verify = 'yes' WHERE id = " . $_SESSION['id'];
            if(mysqli_query($link, $verify))
            {
                echo "
                <script>
                Swal.fire({
                    title: 'Verified!',
                    text: 'Your account has been verified!',
                    icon: 'success'
                }).then(function() {
                location.href = 'index.php'
                })</script>";  
            }
            
        }
         
    }

?>      
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Verify E-mail</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Verify E-mail</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!-- Account Area Start -->
        <div class="account-area ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6" style="float:none; margin:auto;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-side">
                            <div class="login-reg">
                                <h3>E-mail Verification</h3>
                                <div class="input-box mb-20">
                                    <label class="control-label">Code</label>
                                    <input type="text" class="info" placeholder="123456" value="" name="codes">
                                    <span class="invalid-feedback d-block"><?php echo $code_err; ?></span>
                                </div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="send" class="btn btn-dark" value="Get Code">
                                    <input type="submit" name="verifi" class="btn btn-dark" value="Verify" style="float: right;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Account Area End -->

        <!-- footer area start-->
        <div class="footer-area ptb-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4">
                        <div class="single-footer contact-us">
                            <div class="footer-title uppercase">
                                <h5>Contact US</h5>
                            </div>
                            <ul>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-pin-drop"></i> </div>
                                    <div class="contact-text">
                                        <p>Address: Your address goes here</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-email-open"></i> </div>
                                    <div class="contact-text">
                                        <p><span><a href="mailto://demo@example.com">demo@example.com</a></span> <span><a
                                                    href="mailto://info@example.com">info@example.com</a></span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-phone-paused"></i> </div>
                                    <div class="contact-text">
                                        <p><a href="tel://01234567890">01234567890</a> <a href="tel://01234567890">01234567890</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4">
                        <div class="single-footer informaton-area">
                            <div class="footer-title uppercase">
                                <h5>Information</h5>
                            </div>
                            <div class="informatoin">
                                <ul>
                                    <li><a href="#">My Account</a></li>
                                    <li><a href="#">Order History</a></li>
                                    <li><a href="#">Wishlist</a></li>
                                    <li><a href="#">Returnes</a></li>
                                    <li><a href="#">Private Policy</a></li>
                                    <li><a href="#">Site Map</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 d-md-none d-block d-lg-block">
                        <div class="single-footer instagrm-area">
                            <div class="footer-title uppercase">
                                <h5>InstaGram</h5>
                            </div>
                            <div class="instagrm">
                                <ul>
                                    <li><a href="#"><img src="images/gallery/01.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="images/gallery/02.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="images/gallery/03.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="images/gallery/04.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="images/gallery/05.jpg" alt=""></a></li>
                                    <li><a href="#"><img src="images/gallery/06.jpg" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 offset-xl-1">
                        <div class="single-footer newslatter-area">
                            <div class="footer-title uppercase">
                                <h5>Get Newsletters</h5>
                            </div>
                            <div class="newslatter">
                                <form action="#" method="post">
                                    <div class="input-box pos-rltv">
                                        <input placeholder="Type Your Email hear" type="text">
                                        <a href="#">
                                            <i class="zmdi zmdi-arrow-right"></i>
                                        </a>
                                    </div>
                                </form>
                                <div class="social-icon socile-icon-style-3 mt-40">
                                    <div class="footer-title uppercase">
                                        <h5>Social Network</h5>
                                    </div>
                                    <ul>
                                        <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-google"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--footer area start-->
        
        <!--footer bottom area start-->
        <div class="footer-bottom global-table">
            <div class="global-row">
                <div class="global-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                 <p class="copyrigth text-center">
                    © 2022 <span class="text-capitalize">clothing</span>. Made
                    with <i style="color: #f53400;" class="fa fa-heart"></i>
 by
                    <a  href="https://themeforest.net/user/codecarnival/portfolio">CodeCarnival</a>
                  </p>
                            </div>
                            <div class="col-md-6">
                                <ul class="payment-support text-end">
                                    <li>
                                        <a href="#"><img src="images/icons/pay1.png" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/icons/pay2.png" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/icons/pay3.png" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/icons/pay4.png" alt="" /></a>
                                    </li>
                                    <li>
                                        <a href="#"><img src="images/icons/pay5.png" alt="" /></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

</body>

</html>