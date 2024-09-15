<?php

    /*$headers = 'From: noreply <noreply@gmail.com>' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8';  // Set from headers

    $resultss = mail("liyuguangjie@gmail.com", "Hello world", "This is email body", $headers);
    var_dump($resultss);*/

    include("header.php");

    if (isset($_SESSION["loggedin"])) 
    {
        echo '<script>location.href = "index.php" </script>';
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //initialize all value
    $email = $password = "";
    $email_err = $password_err = "";
    $send_status = "";
    $_SESSION["reset_code"] = "";

    $n = 6;
    function getName($n)
    {
        $characters = '123456789';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    if(isset($_POST['resets']))
    {
        //Validate
        if(empty($_POST["email"]))
        {
            $email_err = "<b>Please enter an email<b>";
        }
        else
        {
            $email = $_POST["email"];
            $sqli = "SELECT * FROM user where email = '$email'";
            $results = mysqli_query($link, $sqli);
            if (mysqli_num_rows($results) == 1) 
            {
                while ($row = mysqli_fetch_assoc($results)) {
                    $_SESSION["resetemail"] = $row["email"];
                    $_SESSION["resetid"] = $row["id"];
                };
                $_SESSION["reset_code"] = getName($n);
                $sqll = "UPDATE user SET codes = " .$_SESSION["reset_code"]." where id = " . $_SESSION["resetid"];
                if (mysqli_query($link, $sqll)) 
                {
                    ///
                }
            } 
            else
            {
                $email_err = "Email not found.";
                echo "
                <script>
                Swal.fire({
                    title: '找没有啊',
                    text: 'Please try again',
                    icon: 'error'
                }).then(function() {
                location.href = 'resetpw.php'
                })</script>";
            }
        }


        if (empty($email_err)) 
        {
     
            //required files
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
                $mail->addAddress($_POST["email"]);     //Add a recipient email  
                $mail->addReplyTo($_POST["email"]); // reply to sender email
            
                //Content
                $mail->isHTML(true);               //Set email format to HTML
                $mail->Subject = 'Reset Password';   // email subject headings
                $mail->Body    = '
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Verification Code</title>
                </head>
                <body style="padding: 20px; background-color: #f2f2f2; width: 400px; color: #333; font-family: Arial, sans-serif; margin: auto;">

                    <h2>Hello '.$_POST["email"].',</h2>

                    <p>Here is your password reset PIN::</p>

                    <h1 style="font-size: 36px; color: #009688; text-align: center; margin: 10px 0;">'.$_SESSION["reset_code"].'</h1>

                    <p>If this email was not initiated by you, please disregard it.</p>

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
                }).then(function() {
                location.href = 'resetverify.php'
                })</script>";
            
        }
        
        
}

   

?>      
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Reset Password</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Reset Password</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!-- Account Area Start -->
        <div class="account-area ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6" style="float:none; margin:auto;">
                        <form action="" method="post" class="login-side">
                            <div class="login-reg">
                                <h3>Reset Password</h3>
                                <div class="input-box mb-20">
                                    <label class="control-label">E-Mail</label>
                                    <input type="email" class="info" placeholder="JohnDoe@gmail.com" value="" name="email">
                                    <span class="invalid-feedback d-block"><?php echo $email_err; ?></span>
                                </div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="resets" class="btn btn-dark" value="Reset">
                                </div>
                                <a href="login.php" class="forgotten forg">Already have an account?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Account Area End -->

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

</body>

</html>