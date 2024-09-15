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
        else
        {
            $name = $_POST['con_name'];
        }

        // Email
        if(empty($_POST['con_email']))
        {
            $emailErr = "Please enter your email";
        }
        else
        {
            $email = $_POST['con_email'];
        }

        // Message
        if(empty($_POST['con_message']))
        {
            $msgErr = "Please enter your message";
        }
        else
        {
            $msg = $_POST['con_message'];
        }

        // Check for errors
        if(empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($msgErr))
        {
            $contactt = "UPDATE contact SET reply = 'closed' WHERE conID = ".$_GET['conID'];
            if(mysqli_query($link, $contactt))
            {
                $coninfo = "SELECT * FROM contact WHERE conID = ".$_GET['conID'];
                $resultCon = mysqli_query($link, $coninfo);
                $rowCon = mysqli_fetch_assoc($resultCon);

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
                $mail->addAddress($rowCon['conEmail']);     //Add a recipient email  
            
                //Content
                $mail->isHTML(true);               //Set email format to HTML
                $mail->Subject = 'Feedback Resolution from Administration';   // email subject headings
                $mail->Body    =  '
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Feedback Response</title>
                </head>
                <body style="padding: 20px; background-color: #f2f2f2; width: 400px; color: #333; font-family: Arial, sans-serif; margin: auto;">

                    <h2>Dear '.$rowCon['conName'].',</h2>

                    <p>'.$msg.'</p>

                    <p>Thank you for taking the time to share your valuable feedback with us. We appreciate your insights, and your input is instrumental in helping us enhance our services. Rest assured, your feedback is being carefully reviewed by our team, and we are committed to continuously improving to meet and exceed your expectations. If you have any further comments or suggestions, please do not hesitate to reach out. Your satisfaction is our priority, and we look forward to serving you better in the future.</p>

                    <p style="color: #777;">Best regards,<br>HypeHaven Clothing Co. Team</p>

                </body>
                </html>
                ';
                $mail->send(); //email message
                echo "
                <script>
                Swal.fire({
                    title: 'Sent',
                    text: 'Your message has been sent',
                    icon: 'success'
                }).then(function() {
                    location.href = 'adminfed.php';
                });
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
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                    <li class="active">Reply to customer</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!--contact info are start-->
        <div class="contact-info ptb-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-footer contact-us contact-us-2">
                            <div class="heading-title text-center mb-50">
                                <h5 class="uppercase">Feedback Info</h5> 
                            </div>
                            <ul class="contact-info">
                                <?php
                                    $coninfo = "SELECT * FROM contact WHERE conID = ".$_GET['conID'];
                                    $resultCon = mysqli_query($link, $coninfo);
                                    $rowCon = mysqli_fetch_assoc($resultCon);
                                ?>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-account user-icon"></i> </div>
                                    <div class="contact-text">
                                        <p><span><?=$rowCon['conName']?></span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-phone-paused"></i> </div>
                                    <div class="contact-text">
                                        <p><span><?=$rowCon['conPH']?></span> </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-email-open"></i> </div>
                                    <div class="contact-text">
                                        <p><span><?=$rowCon['conEmail']?></span><br><br><b>User message:</b>
                                        <div class="input-box mb-20">
                                             <textarea name="con_message" class="area-tex" placeholder="<?=$rowCon['conMsg']?>" readonly></textarea>
                                         </div></p>
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
                    <div class="col-md-6">
                        <h2>Reply</h2>
                         <div class="row">
                             <div class="col-lg-12">
                                <?php
                                    $repinfo = "SELECT * FROM user WHERE id = ".$_SESSION['id'];
                                    $resultrep = mysqli_query($link, $repinfo);
                                    $rowrep = mysqli_fetch_assoc($resultrep);
                                ?>
                                 <form class="row" action="" method="post">
                                     <div class="col-md-6">
                                         <div class="input-box mb-20">
                                             <input name="con_name" class="info"  type="text" value="<?=$rowrep['uname']?>" readonly>
                                             <span class="invalid-feedback d-block"><?php echo $nameErr; ?></span>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="input-box mb-20">
                                             <input name="con_email" class="info" type="email" value="<?=$rowrep['email']?>" readonly>
                                             <span class="invalid-feedback d-block"><?php echo $emailErr; ?></span>
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