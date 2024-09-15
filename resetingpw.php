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
    $pw_err = $repw_err = "";
    $pw = $repw = $email = "";
    $_SESSION["resetemail"] = $email;

    if(isset($_POST['pwchg']))
    {
       
        if(empty($_POST['newpw']))
        {
            $pw_err = "Enter password";
        }
        else
        {
            $pw = $_POST['newpw'];

            $uppercase = preg_match('@[A-Z]@', $pw);
            $lowercase = preg_match('@[a-z]@', $pw);
            $number = preg_match('@[0-9]@', $pw);
            $specialChars = preg_match('@[^\w]@', $pw);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pw) < 8) {
                $pw_err = "Password should be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
            }
        }

        if(empty($_POST['renewpw']))
        {
            $repw_err = "Please confirm password";
        }
        else
        {
            $repw = $_POST['renewpw'];
        }

        if(empty($pw_err) && empty($repw_err))
        {
            if($pw != $repw)
            {
                echo "
                <script>
                Swal.fire({
                    title: 'Invalid password',
                    text: 'Please enter same password.',
                    icon: 'error'
                }).then(function() {
                location.href = 'resetingpw.php'
                })</script>";
            }
            else
            {
                $hashed = password_hash($pw, PASSWORD_DEFAULT);
                $sql = "UPDATE user SET pw = '$hashed' WHERE codes = ".$_SESSION["reset_code"];
                if (mysqli_query($link, $sql)) 
                {
                    echo "
                    <script>
                    Swal.fire({
                        title: 'Password changed',
                        text: 'You may login now.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'login.php'
                    })</script>";
                }
                else 
                {
                echo "
                <script>
                    alert('Error: " . $sql . "\n" . mysqli_error($con) . "')
                </script>";
                }
            }
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
                                    <label class="control-label">Enter new password</label><span id="msg"></span>
                                    <input type="password" class="info" placeholder="123456" name="newpw" id="cP"  onkeyup="validatePassword(this.value);">
                                    <span class="invalid-feedback d-block"><?php echo $pw_err; ?></span>
                                </div>
                                <div class="input-box">
                                    <label class="control-label">Re-enter password</label>
                                    <input type="password" class="info" placeholder="123456" value="" name="renewpw" id="nP">
                                    <label style="cursor: pointer;"><input style="cursor: pointer; weight:20px; height:13px;" type="checkbox"onclick="myFunction()"></label>Show Password
                                    <span class="invalid-feedback d-block"><?php echo $repw_err; ?></span>
                                </div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="pwchg" class="btn btn-dark" value="Confirm">
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
    <script>
        function myFunction() 
        {
            var x = document.getElementById("cP");
            var y = document.getElementById("nP");

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        }

        function validatePassword(password) {
        // Do not show anything when the length of password is zero.
        if (password.length === 0) {
            document.getElementById("msg").innerHTML = "";
            return;
        }
        // Create an array and push all possible values that you want in password
        var matchedCase = new Array();
        matchedCase.push("[$@$!%*#?&]"); // Special Charector
        matchedCase.push("[A-Z]"); // Uppercase Alpabates
        matchedCase.push("[0-9]"); // Numbers
        matchedCase.push("[a-z]"); // Lowercase Alphabates

        // Check the conditions
        var ctr = 0;
        for (var i = 0; i < matchedCase.length; i++) {
            if (new RegExp(matchedCase[i]).test(password)) {
                ctr++;
            }
        }
        // Display it
        var color = "";
        var strength = "";
        switch (ctr) {
            case 0:
            case 1:
            case 2:
                strength = " (Very Weak)";
                color = "red";
                break;
            case 3:
                strength = " (Medium)";
                color = "orange";
                break;
            case 4:
                strength = " (Strong)";
                color = "green";
                break;
        }
        document.getElementById("msg").innerHTML = strength;
        document.getElementById("msg").style.color = color;
        }
    </script>

</body>

</html>