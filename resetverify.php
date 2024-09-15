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

    //initialize value
    $code_err = "";
    $resetcode = "";
    $scode = $sid = "";

    if(isset($_POST['codess']))
    {
        if($_POST['codes'] != $_SESSION["reset_code"])
        {
            $code_err = "Invalid code, please enter the correct code from your email.";
        }
        else
        {
            echo "
            <script>
            Swal.fire({
                title: 'Success',
                text: 'Change your new password.',
                icon: 'success'
            }).then(function() {
            location.href = 'resetingpw.php'
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
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-side">
                            <div class="login-reg">
                                <h3>Reset Password</h3>
                                <div class="input-box mb-20">
                                    <label class="control-label">Enter the 6-digit code</label>
                                    <input type="text" class="info" placeholder="123456" value="" name="codes" maxlength="6">
                                    <span class="invalid-feedback d-block"><?php echo $code_err; ?></span>
                                </div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="codess" class="btn btn-dark" value="Confirm">
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