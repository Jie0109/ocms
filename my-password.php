<?php
    include("header.php");

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

    if(isset($_POST['saves']))
    {
        $email = $_SESSION["email"];
        $curPass = $_POST["curPass"];
        $newPass = $_POST["newPass"];
        $conPass = $_POST["conPass"];

        $sql = "SELECT * from user where email = '$email'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
    
        if(password_verify($curPass, $row['pw']))
        {
            $uppercase = preg_match('@[A-Z]@', $newPass);
            $lowercase = preg_match('@[a-z]@', $newPass);
            $number = preg_match('@[0-9]@', $newPass);
            $specialChars = preg_match('@[^\w]@', $newPass);

            if($newPass != $conPass)
            {
                echo "
                <script>
                Swal.fire({
                    title: 'Please try again',
                    text: 'Please enter same password',
                    icon: 'error'
                }).then(function() {
                location.href = 'my-password.php'
                })</script>";
            }
            else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($conPass) < 8) {
                $pw_err = "Password should be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
                echo "
                <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Password should be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.',
                        icon: 'error'
                    }).then(function() {
                    location.href = 'my-password.php'
                    })
                </script>";
            }
            else
            {   $confirmed = password_hash($conPass, PASSWORD_DEFAULT);

                $sqls = "UPDATE user SET pw = '$confirmed' WHERE email = '$email' ";
                if (mysqli_query($link, $sqls)) 
                {
                echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your password have updated, please login again',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'logout.php'
                    })
                </script>";
                }
            }
        }   
        else 
        {
            echo "
            <script>
            Swal.fire({
                title: 'Please try again',
                text: 'Current Password is invalid',
                icon: 'error'
            }).then(function() {
            location.href = 'my-password.php'
            })</script>";
        }
    }
?>

        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>My Account</h5>
                </div>
                <ol class="breadcrumb">
                    <?php
                        if($_SESSION["mode"] == 'cust')
                        {
                            echo'<li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                            <li class="active">Account</li>';
                        }
                        else
                        {
                            echo'<li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                            <li class="active">Account</li>';
                        }
                    ?>
                    
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

        <!--service idea area are start -->
        <div class="idea-area  ptb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="idea-tab-menu">
                            <ul class="nav idea-tab" role="tablist">
                            <?php
                                    if($_SESSION["mode"] == 'cust')
                                    {
                                        echo'
                                            <li><a class="" href="my-account.php">Personal Info</a></li>
                                            <li><a class="" href="my-design.php">Customization</a></li>
                                            <li><a class="active" href="my-password.php">Password</a></li>
                                            <li><a class="" href="my-order.php">My Order</a></li>
                                            <li><a class="" href="paymentmethod.php">Payment Method</a></li>
                                        ';
                                    }
                                    else
                                    {
                                        echo'
                                            <li><a class="" href="addProduct.php">Add Product</a></li>
                                            <li><a class="" href="modProd.php">Modify Product</a></li>
                                            <li><a class="" href="adminCat.php">Add Category</a></li>
                                            <li><a class="active" href="my-password.php">Password</a></li>
                                        ';
                                    }
                                ?>
                                <li role=""><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="idea-tab-content">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="" id="">
                                    <div class="row">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-side">
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Current Password<em>*</em></label>
                                                    <input type="password" id="cP" name="curPass" class="info" placeholder="Current Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>New Password<em>*</em></label><span id="msg"></span>
                                                    <input type="password" id="nP" name="newPass" onkeyup="validatePassword(this.value);" class="info" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Confirm Password<em>*</em></label>
                                                    <input type="password" id="CP" name="conPass" class="info" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-end">
                                                <label style="cursor: pointer;"><input style="cursor: pointer; weight:20px; height:13px;" type="checkbox"onclick="myFunction()"></label>Show Password
                                                <input type="submit" name="saves" class="btn btn-dark" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--service idea area are end -->

        

        <!--footer bottom area start-->
        <?php include('footer.php');?>
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
            var z = document.getElementById("CP");

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

            if (z.type === "password") {
                z.type = "text";
            } else {
                z.type = "password";
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