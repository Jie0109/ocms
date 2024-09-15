<?php 

    include('header.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $name = $email = $phone = $msg = "";
    $nameErr = $emailErr = $phoneErr = $msgErr = "";

    if(isset($_POST['contact']))
    {
        // Name
        if(empty($_POST['con_name']))
        {
            $nameErr = "Please enter your name";
        }
        elseif(strlen(trim($_POST['con_name'])) == 0)
        {
            $nameErr = "Please enter your name";
        }
        else
        {
            $name = $_POST['con_name'];
        }

        // Email
        if(empty($_POST['con_email']))
        {
            $emailErr = "Please enter your email";
        }
        elseif(strlen(trim($_POST['con_email'])) == 0)
        {
            $emailErr = "Please enter your email";
        }
        else
        {
            $email = $_POST['con_email'];
        }

        // Phone
        $phonePattern = '/^\+\d{1,3}\d{9}$/';
        if(empty($_POST['con_phone']))
        {
            $phoneErr = "Please enter your phone number";
        }
        elseif(strlen(trim($_POST['con_phone'])) == 0)
        {
            $phoneErr = "Please enter your phone number";
        }
        elseif (!preg_match($phonePattern, $_POST['con_phone'])) 
        {
            $phoneErr = "Please enter a valid 10-digit phone number.";
        }
        else
        {
            $phone = $_POST['con_phone'];
        }

        // Message
        if(empty($_POST['con_message']))
        {
            $msgErr = "Please enter your message";
        }
        elseif(strlen(trim($_POST['con_message'])) == 0)
        {
            $msgErr = "Please enter your message";
        }
        else
        {
            $msg = $_POST['con_message'];
        }

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dates = date('Y-m-d H:i:s'); //Returns IST
        // Check for errors
        if(empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($msgErr))
        {
            $contactt = "INSERT INTO contact (conName, conEmail, conPH, conMsg, reply, conDate) VALUES ('$name', '$email', '$phone', '$msg', 'pending', '$dates')";
            if(mysqli_query($link, $contactt))
            {
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
                $mail->addAddress($email);     //Add a recipient email  
            
                //Content
                $mail->isHTML(true);               //Set email format to HTML
                $mail->Subject = 'Get in Touch';   // email subject headings
                $mail->Body    = '
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Feedback Received</title>
                </head>
                <body style="padding: 20px; background-color: #f2f2f2; width: 400px; color: #333; font-family: Arial, sans-serif; margin: auto;">

                    <h2>Hello '.$email.',</h2>

                    <p>We have received your feedback. Our team will reply to you soon.</p>

                    <p>If this email was not initiated by you, please disregard it.</p>

                    <p>Thank you for choosing HypeHaven!</p>

                    <p style="color: #777;">Best regards,<br>HypeHaven Team</p>

                </body>
                </html>
                ';
                $mail->send(); //email message

                echo "
                <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'Our administrative team will be in touch with you shortly.',
                    icon: 'success'
                }).then(function() {
                location.href = 'index.php'
                })
                </script>";
            }
            
        }
    }

?>
        
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Contact Details</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Contact Us</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!--map area start-->
        <div class="map-area">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.904809837224!2d102.25004407452943!3d2.189756358301615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1f1e0e79b7485%3A0xb1f4d1ef5e1facc8!2sDataran%20Pahlawan%20Melaka%20Megamall!5e0!3m2!1sen!2smy!4v1701239575521!5m2!1sen!2smy" width="1519" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <!--map area end-->
        
        <!--contact info are start-->
        <div class="contact-info ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                         <div class="row">
                             <div class="col-lg-12">
                                 <form class="row" action="" method="post">
                                     <div class="col-md-6">
                                         <div class="input-box mb-20">
                                             <input name="con_name" class="info" placeholder="JohnDoe*" type="text">
                                             <span class="invalid-feedback d-block"><?php echo $nameErr; ?></span>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="input-box mb-20">
                                             <input name="con_email" class="info" placeholder="JohnDoe@gmail.com" type="email">
                                             <span class="invalid-feedback d-block"><?php echo $emailErr; ?></span>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
                                         <div class="input-box mb-20">
                                             <input name="con_phone" class="info" placeholder="60123456789" type="text">
                                             <span class="invalid-feedback d-block"><?php echo $phoneErr; ?></span>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
                                         <div class="input-box mb-20">
                                             <textarea name="con_message" class="area-tex" placeholder="Your Message*"></textarea>
                                             <span class="invalid-feedback d-block"><?php echo $msgErr; ?></span>
                                         </div>
                                     </div>
                                     <div class="col-12">
                                         <div class="input-box">
                                             <input type="submit" name="contact" class="btn btn-info" value="Submit" style="color: black;">
                                             <p class="form-messege"></p>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-footer contact-us contact-us-2">
                            <div class="heading-title text-center mb-50">
                                <h5 class="uppercase">Contact Info</h5> 
                                </div>
                            <ul class="contact-info">
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-phone-paused"></i> </div>
                                    <div class="contact-text">
                                        <p><span>0123608370</span> </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-email-open"></i> </div>
                                    <div class="contact-text">
                                        <p><span><a href="#">rex010109@gmail.com</a></span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-pin-drop"></i> </div>
                                    <div class="contact-text">
                                        <p><span>Dataran Pahlawan Melaka Megamall, Jln Merdeka, </span> <span>Banda Hilir, 75000 Malacca</span></p>
                                    </div>
                                </li>
                            </ul>
                            <!--<div class="social-icon-wraper mt-25">
                                <div class="social-icon socile-icon-style-1">
                                    <ul>
                                        <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-google-glass"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-dribbble"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-whatsapp"></i></a></li>
                                        <li><a href="#"><i class="zmdi zmdi-blogger"></i></a></li>
                                    </ul>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="col-lg-12">
                       <div class="pos-rltv">
                            <div class="contact-des">
                                <p>Connect With Us
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--contact info are end-->
        
       
        
        <!--footer bottom area start-->
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
    <!-- ajax file. -->
    <script src="js/ajax-mail.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <!-- Google Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-IIoucJ-70FQg6xZsORjQCUPHCVj9GV4"></script>
    <script src="js/google-map.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

</body>

</html>