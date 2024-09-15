<?php
    include("header.php");
    
    //initialize all value
    $email = $password = $username = "";
    $email_err = $password_err = $username_err = "";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['registers']))
    {
        //Validate
        if(empty($_POST["email"]))
        {
            $email_err = "<b>Please enter an email<b>";
        }
        elseif(strlen(trim($_POST['email'])) == 0)
        {
            $email_err = "<b>Please enter an email<b>";
        }
        else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", test_input($_POST["email"])))
        {
            $email_err = "<b>Please enter a valid email address<b>";
        }
        else
        {
            $email = $_POST["email"];
            $sqli = "SELECT * FROM user where email = '$email'";
            $results = mysqli_query($link, $sqli);
            if (mysqli_num_rows($results) > 0) 
            {
                $email_err = "<b>Email taken<b>";
                echo "
                <script>
                Swal.fire({
                    title: 'Email is taken',
                    text: 'Please try again',
                    icon: 'error'
                }).then(function() {
                location.href = 'register.php'
                })</script>";
            } 
            else
            {
                $email = $_POST["email"];
            }
        }
        

        if(empty($_POST["username"]))
        {
            $username_err = "<b>Please enter an username</b>";
        }
        elseif(strlen(trim($_POST['username'])) == 0)
        {
            $username_err = "<b>Please enter an username</b>";
        }
        else
        {
            $username = $_POST["username"];
        }

        if(empty($_POST["password"]))
        {
            $password_err = "<b>Please enter a password</b>";
        }
        else
        {
            $password = $_POST["password"];

            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
            {
                $password_err = "<b>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</b>";
            }
        }
        
        $registrationDate = date('Y-m-d');

        if(empty($email_err) && empty($password_err) && empty($username_err))
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (email, pw, mode, uname, registrationDate) VALUES ('$email', '$hash', 'cust', '$username', '$registrationDate')";

            if (mysqli_query($link, $sql)) 
            {
                echo "
                <script>
                Swal.fire({
                    title: 'Successful',
                    text: 'New account created, please verify your email ASAP!',
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

?>      
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Register</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Login</li>
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
                                <h3>Create an Account</h3>
                                <div class="input-box mb-20">
                                    <label class="control-label">E-Mail</label>
                                    <input type="email" class="info" placeholder="E-Mail" value="" name="email">
                                    <span class="invalid-feedback d-block"><?php echo $email_err; ?></span>
                                </div>
                                <div class="input-box">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="info" placeholder="Username" value="" name="username">
                                    <span class="invalid-feedback d-block"><?php echo $username_err; ?></span>
                                </div>
                                <div class="input-box">
                                    <label class="control-label">Password</label><span id="msg"></span>
                                    <input type="password" id="cP" class="info" placeholder="Password" value="" name="password" onkeyup="validatePassword(this.value);">
                                    <span class="invalid-feedback d-block"><?php echo $password_err; ?></span>
                                    <label style="cursor: pointer;"><input style="cursor: pointer; weight:20px; height:13px;" type="checkbox"onclick="myFunction()"></label>Show Password
                                </div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="registers" class="btn btn-dark" value="Register">
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

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
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