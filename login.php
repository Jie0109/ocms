<?php
    include("db.php");

 if(isset($_POST['logins']))
    {
         //initialize all value
$email = $password = "";
$email_err = $password_err = $login_err = "";
        if (isset($_POST['g-recaptcha-response'])) 
        {
            // RECAPTCHA SETTINGS
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $key = '6LcVihEpAAAAABRob1H40oIPFg7W0IdO-RhECKZw';
            $url = 'https://www.google.com/recaptcha/api/siteverify';

            // RECAPTCH RESPONSE
            $recaptcha_response = file_get_contents($url . '?secret=' . $key . '&response=' . $captcha . '&remoteip=' . $ip);
            $data = json_decode($recaptcha_response);

        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT * from user where email = '$email'";
        $result = mysqli_query($link,  $sql);
    
        if(mysqli_num_rows($result) === 1)
        {
            if (isset($data->success) &&  $data->success === true) 
            {
                while ($row = mysqli_fetch_assoc($result)) 
                {
                    if (password_verify($password, $row['pw']))
                    {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["uname"] = $row['uname'];
                        $_SESSION["mode"] = $row["mode"];
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["id"] = $row["id"];

                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $activeTimeFrame = date('Y-m-d H:i:s'); 
                        $lastLogin = "UPDATE user SET lastLogin = '$activeTimeFrame' WHERE id = ". $_SESSION['id'];
                        mysqli_query($link, $lastLogin);

                        if($_SESSION['mode'] == 'cust')
                        {
                            $actLogin = "INSERT INTO userlogs (userid, activity, times) VALUES (".$_SESSION['id'].", 'logged in', '$activeTimeFrame')";
                            mysqli_query($link,$actLogin);
                            header('Location: index.php'); // Replace with your desired URL
                        }
                        else
                        {
                            header("Location: admindboard.php");
                        }
                        
                    }
                    else
                    {
                       echo '<script>
                            alert("Invalid password. Please try again.");
                            location.href = "login.php";
                        </script>';
                    }
                    
                }
            } 
            else 
            {
                echo '<script>
                            alert("Please verify that you are not a robot!");
                            location.href = "login.php";
                        </script>';
            }

            
        }   
        else 
        {
            echo '<script>
                    alert("Email not found, please try again");
                    location.href = "login.php";
                </script>';
            $login_err = "Email or password is invalid";
        }
    }
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home || Clothing</title>
    <meta name="description"
        content="Clothing – eCommerce Fashion Template is a clean and elegant design – suitable for selling clothing, fashion, high fashion, men fashion, women fashion, accessories, digital, kids, watches, jewelries, shoes, kids, furniture, sports, tools….. It has a fully responsive width adjusts automatically to any screen size or resolution.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="images/logo/xcon.png">
    <!-- Place favicon.png in the root directory -->

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/color/skin-default.css">


    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

    <!-- ToastrAlert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google reCaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
    
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Body main wrapper start -->
    <div class="wrapper home-one">

        <!-- Start of header area -->
        <header class="header-area header-wrapper">
            <div class="header-top-bar black-bg clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="login-register-area">
                                <ul>
                                    <li><a href="login.php">Login</a></li>
                                    <li><a href="register.php">Register</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-md-block">
                            <div class="social-search-area text-center">
                                <div class="social-icon socile-icon-style-2">
                                    <ul>
                                        <li><a href="https://www.facebook.com/l.guangjie/" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
                                        <li><a href="https://www.linkedin.com/in/liyu-guang-jie-a95280201/" target="_blank"><i class="zmdi zmdi-linkedin"></i></a></li>
                                        <li><a href="https://www.instagram.com/guangjie_l/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
                                        <li><a href="https://twitter.com/jieee0109" target="_blank"><i class="zmdi zmdi-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6">
                            <div class="cart-currency-area login-register-area text-end">
                                <ul>
                                    <li>
                                        <div class="header-cart">
                                            <div class="cart-icon"> <a href="cart.php">Cart<i class="zmdi zmdi-shopping-cart"></i> </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sticky-header" class="header-middle-area">
                <div class="container">
                    <div class="full-width-mega-dropdown">
                        <div class="row">
                            <?php include('userNav.php')?>
                            <div class="col-lg-3 d-none d-lg-block">
                                <div class="search-box global-table">
                                    <div class="global-row">
                                        <div class="global-cell">
                                            <form action="#">
                                                <div class="input-box">
                                                    <input class="single-input" placeholder="Search anything"
                                                        type="text">
                                                    <button class="src-btn"><i class="fa fa-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- mobile-menu-area start -->
                            <div class="mobile-menu-area">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <nav id="dropdown">
                                                <ul>
                                                    <li><a href="index.php">Home</a>
                                                        <ul>
                                                            <li><a class="active" href="index.php">Home One</a></li>
                                                            <li><a href="index-2.php">Home Two</a></li>
                                                            <li><a href="index-boxed-01.php">Home Three (Boxed)</a>
                                                            </li>
                                                            <li><a href="index-boxed-02.php">Home Four (Boxed)</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="shop.php">Man</a>
                                                        <ul class="single-mega-item">
                                                            <li><a href="shop.php">Shirt 01</a></li>
                                                            <li><a href="shop.php">Shirt 02</a></li>
                                                            <li><a href="shop.php">Shirt 03</a></li>
                                                            <li><a href="shop.php">Shirt 04</a></li>
                                                            <li><a href="shop.php">Pant 01</a></li>
                                                            <li><a href="shop.php">Pant 02</a></li>
                                                            <li><a href="shop.php">Pant 03</a></li>
                                                            <li><a href="shop.php">Pant 04</a></li>
                                                            <li><a href="shop.php">T-Shirt 01</a></li>
                                                            <li><a href="shop.php">T-Shirt 02</a></li>
                                                            <li><a href="shop.php">T-Shirt 03</a></li>
                                                            <li><a href="shop.php">T-Shirt 04</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="shop.php">Shop</a>
                                                        <ul class="single-mega-item">
                                                            <li><a href="shop.php">Sharee 01</a></li>
                                                            <li><a href="shop.php">Sharee 02</a></li>
                                                            <li><a href="shop.php">Sharee 03</a></li>
                                                            <li><a href="shop.php">Sharee 04</a></li>
                                                            <li><a href="shop.php">Sharee 05</a></li>
                                                            <li><a href="shop.php">Lahenga 01</a></li>
                                                            <li><a href="shop.php">Lahenga 02</a></li>
                                                            <li><a href="shop.php">Lahenga 03</a></li>
                                                            <li><a href="shop.php">Lahenga 04</a></li>
                                                            <li><a href="shop.php">Lahenga 05</a></li>
                                                            <li><a href="shop.php">Sandel 01</a></li>
                                                            <li><a href="shop.php">Sandel 02</a></li>
                                                            <li><a href="shop.php">Sandel 03</a></li>
                                                            <li><a href="shop.php">Sandel 04</a></li>
                                                            <li><a href="shop.php">Sandel 05</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#">Shortcode</a>
                                                        <ul class="single-mega-item">
                                                            <li><a href="shortcode-banner.php">shortcode-banner</a>
                                                            </li>
                                                            <li><a
                                                                    href="shortcode-best-top-on-sale-slider.php">too-on-sale</a>
                                                            </li>
                                                            <li><a href="shortcode-blog-item.php">Short
                                                                    Blog Item</a></li>
                                                            <li><a href="shortcode-brand-prodcut.php">Brand Product</a>
                                                            </li>
                                                            <li><a href="shortcode-brand-slider.php">Brand Slider</a>
                                                            </li>

                                                            <li><a href="shortcode-breadcrumb.php">Breadcrumb</a></li>
                                                            <li><a href="shortcode-related-product.php">Related
                                                                    Product</a></li>
                                                            <li><a href="shortcode-service.php">Service</a></li>
                                                            <li><a href="shortcode-skill.php">Skill</a>
                                                            </li>
                                                            <li><a href="shortcode-slider.php">Slider</a></li>

                                                            <li><a href="shortcode-team.php">Team</a>
                                                            </li>
                                                            <li><a href="shortcode-testimonial.php">Testimonial</a>
                                                            </li>
                                                            <li><a href="shortcode-why-choose-us.php">Why Choose Us</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li> <a href="#">Pages</a>
                                                        <ul class="single-mega-item coloum-4">
                                                            <li><a href="about-us.php">About-us</a>
                                                            </li>
                                                            <li><a href="blog.php">Blog</a></li>
                                                            <li><a href="blog-right.php">Blog-Right</a>
                                                            </li>
                                                            <li><a href="single-blog.php">Single
                                                                    Blog</a></li>
                                                            <li><a href="single-blog-right.php">Single
                                                                    Blog Right</a></li>
                                                            <li><a href="blog-full.php">Blog-Fullwidth</a></li>
                                                            <li class="menu-title uppercase">pages-02</li>
                                                            <li><a href="blog-full-right.php">Blog Ful
                                                                    Rightl</a></li>
                                                            <li><a href="cart.php">Cart</a></li>
                                                            <li><a href="checkout.php">Checkout</a>
                                                            </li>
                                                            <li><a href="compare.php">Compare</a></li>
                                                            <li><a href="complete-order.php">Complete
                                                                    Order</a></li>
                                                            <li><a href="contact-us.php">Contact US</a>
                                                            </li>
                                                            <li class="menu-title uppercase">pages-03</li>
                                                            <li><a href="login.php">Login</a></li>
                                                            <li><a href="my-account.php">My Account</a>
                                                            </li>
                                                            <li><a href="shop-full-grid.php">Shop Full
                                                                    Grid</a></li>
                                                            <li><a href="shop-full-list.php">Shop Full
                                                                    List</a></li>
                                                            <li><a href="shop-list-right-sidebar.php">Shop List
                                                                    Right</a></li>
                                                            <li><a href="shop-list.php">Shop List</a>
                                                            </li>
                                                            <li class="menu-title uppercase">pages-03</li>
                                                            <li><a href="shop-right-sidebar.php">Shop
                                                                    Right</a></li>
                                                            <li><a href="shop.php">Shop</a></li>
                                                            <li><a href="single-product.php">Single
                                                                    Prodcut</a></li>
                                                            <li><a href="wishlist.php">Wishlist</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="about-us.php">about</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--mobile menu area end-->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End of header area -->
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Log in</h5> </div>
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
                                <h3>Login</h3>
                                <div class="input-box mb-20">
                                    <label class="control-label">E-Mail</label>
                                    <input type="email" placeholder="E-Mail" value="" name="email" class="info" required>
                                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                </div>
                                <div class="input-box">
                                    <label class="control-label">Password</label>
                                    <input type="password" id="cP" placeholder="Password" value="" name="password" class="info" required>
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                    <label style="cursor: pointer;"><input style="cursor: pointer; weight:20px; height:13px;" type="checkbox"onclick="myFunction()"></label>Show Password
                                </div>
                                <div style="margin-left: 115px;" class="g-recaptcha" data-sitekey="6LcVihEpAAAAAIdvbMzrk1Fswp4ju2k7AYNgcLym"></div>
                            </div>
                            <div class="frm-action">
                                <div class="tci-box">
                                    <input type="submit" name="logins" class="btn btn-dark" value="Login">
                                </div>
                                <a href="register.php" class="forgotten forg">Need an account?<i> Register</i></a>
                                <a href="resetpw.php" class="forgotten forg" name="resets">Forgotten Password</a>
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
    </script>

</body>

</html>