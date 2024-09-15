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

    
                                                                   
?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Assistant');
body {
  background: #eee;
  font-family: Assistant, sans-serif;
}

.cell-1 {
  border-collapse: separate;
  border-spacing: 0 4em;
  background: #fff;
  border-bottom: 5px solid transparent;
  /*background-color: gold;*/
  background-clip: padding-box;
}

thead {
  background: #dddcdc;
}

@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
body
{background-color: #eeeeee;font-family: 'Open Sans',serif}

.card{
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 0.10rem}
    
.card-header:first-child{border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0}

.card-header{
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1)}
    
.track{
    position: relative;
    background-color: #ddd;
    height: 7px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 60px;
    margin-top: 50px}
    
.track .step{-webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    width: 25%;
    margin-top: -18px;
    text-align: center;
    position: relative}

.track .step.active:before{background: #FF5722}

.track .step::before{height: 7px;position: absolute;content: "";width: 100%;left: 0;top: 18px}

.track .step.active .icon{background: #ee5435;color: #fff}

.track .icon{display: inline-block;width: 40px;height: 40px;line-height: 40px;position: relative;border-radius: 100%;background: #ddd}

.track .step.active .text{font-weight: 400;color: #000}

.track .text{display: block;margin-top: 7px}

.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}

.itemside .aside{position: relative;-ms-flex-negative: 0;flex-shrink: 0}

.img-sm{width: 80px;height: 80px;padding: 7px}ul.row, ul.row-sm{list-style: none;padding: 0}

.itemside .info{padding-left: 15px;padding-right: 7px}

.itemside .title{display: block;margin-bottom: 5px;color: #212529}

p{margin-top: 0;margin-bottom: 1rem}

.btn-warning{color: #ffffff;background-color: #ee5435;border-color: #ee5435;border-radius: 1px}

.btn-warning:hover{color: #ffffff;background-color: #ff2b00;border-color: #ff2b00;border-radius: 1px}
</style>
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>My Account</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Account</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
                             
        <div class="container" style="margin-top:10px; margin-bottom:10px;">
            <article class="card">
                <header class="card-header"> <a href="my-order.php" style="color: black;">My Orders</a> / Tracking </header>
                <div class="card-body">
                    <?php
                        
                        $order = "SELECT * FROM receipt INNER JOIN product ON receipt.item_id = product.item_id INNER JOIN orders ON receipt.order_id = orders.order_id WHERE orders.order_id = ".$_GET['order_id'];
                        $result = mysqli_query($link, $order);
                        $row = mysqli_fetch_assoc($result);

                    ?>
                    <h6>Order ID: <?=$row['order_id']?></h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Recipient:</strong> <br><?=$row['recipient_name']?></div>
                            <div class="col"> <strong>Address:</strong> <br><?=$row['addresses']?></div>
                            <div class="col"> <strong>Status:</strong> <br> <?=$row['status']?> </div>
                            <div class="col"> <strong>Payment Method:</strong> <br> <?=$row['methods']?> </div>
                        </div>
                    </article>                                           
                    <div class="track">
                        <?php
                            if($row['status'] == 'To Ship')
                            {
                                echo'
                                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                <div class="step "> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                                <div class="step "> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                <div class="step "> <span class="icon"> <i class="fa fa-dropbox"></i> </span> <span class="text">Complete</span> </div>';
                            }
                            else if($row['status'] == 'To Receive')
                            {
                                echo'
                                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                                <div class="step active"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                <div class="step "> <span class="icon"> <i class="fa fa-dropbox"></i> </span> <span class="text">Complete</span> </div>';
                            }
                            else if($row['status'] == 'Completed')
                            {
                                echo'
                                <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                                <div class="step active"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                <div class="step active"> <span class="icon"> <i class="fa fa-dropbox"></i> </span> <span class="text">Complete</span> </div>';
                            }
                        ?>
                        
                    </div>
                    <hr>
                    <ul class="row">
                    <?php
                        $orderR = "SELECT * FROM receipt INNER JOIN product ON receipt.item_id = product.item_id INNER JOIN orders ON receipt.order_id = orders.order_id WHERE orders.order_id = ".$_GET['order_id'];
                        $resultT = mysqli_query($link, $orderR);
                        if(mysqli_num_rows($resultT) > 0)
                        {
                            while($row = mysqli_fetch_assoc($resultT))
                            {
                                $tol = 0.00;
                                $tol = $row['quantity'] * $row['cost'];
                                echo'
                                
                                    <li class="col-md-4">
                                        <figure class="itemside mb-3">
                                            <div class="aside"><a href="single-product.php?item_id='.$row['item_id'].'" style="color: black;"><img src="images/product/'.$row['images'].'" class="img-sm border"></div>
                                            <figcaption class="info align-self-center">
                                                <p class="title">'.$row['item'].'</a>  ('.$row['quantity'].' pcs) </p> <span class="text-muted">RM '.$tol.' </span>
                                            </figcaption>
                                        </figure>
                                    </li>
                                ';
                            }
                        }
                    ?>
                    </ul>
                    <hr>
                    <div>
                        <a href="my-order.php" class="btn btn-warning" data-abc="true" > <i class="fa fa-chevron-left"></i> Back to orders</a>
                        <a href="invoice.php?invoice_id=<?php echo $_GET['order_id']?>" class="btn btn-warning" data-abc="true" style="float: right;">
                            <i class="fa fa-download"></i> View Receipt
                        </a>
                    </div>
                </div>
            </article>
        </div>
        <!--service idea area are end -->

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
                                        <p><span><a href="mailto://demo@example.com">demo@example.com</a></span>
                                            <span><a href="mailto://info@example.com">info@example.com</a></span></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-icon"> <i class="zmdi zmdi-phone-paused"></i> </div>
                                    <div class="contact-text">
                                        <p><a href="tel://01234567890">01234567890</a> <a
                                                href="tel://01234567890">01234567890</a></p>
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
                                    <li><a href="logout.php">Logout</a></li>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
     </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous">
     </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous">
     </script>
 

</body>

</html>