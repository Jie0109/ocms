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
.stats 
{
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
    margin-bottom: 30px;
}

.stat-box 
{
    width: 200px;
    background-color: #fff;
    padding: 1em;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 0 10px;
}
</style>
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Admin <?=$_SESSION['uname']?></h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admn</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
    <div id="main">
        <div class="stats">
            <a href="userlist.php">
                <div class="stat-box" >
                    <?php
                        $userCount = "SELECT COUNT(id) FROM user WHERE mode = 'cust'";
                        $resultC = mysqli_query($link, $userCount);
                        $row = mysqli_fetch_assoc($resultC);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Users</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['COUNT(id)']?></p>
                </div>
            </a>
            <a href="adminproduct.php">
                <div class="stat-box">
                    <?php
                        $prodCount = "SELECT COUNT(item_id) FROM product WHERE userID IS NULL";
                        $resultC = mysqli_query($link, $prodCount);
                        $row = mysqli_fetch_assoc($resultC);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Products</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['COUNT(item_id)']?></p>
                </div>
            </a>
            <a href="adminCATE.php">
                <div class="stat-box">
                    <?php
                        $catCount = "SELECT COUNT(*) AS brand_count FROM brand WHERE brand_name != 'Custom'";
                        $resultCat = mysqli_query($link, $catCount);
                        $row = mysqli_fetch_assoc($resultCat);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Category</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['brand_count']?></p>
                </div>
            </a>
            
            <!-- Add more stat boxes as needed -->
        </div>
        <div class="stats">
            <a href="orderList.php">
                <div class="stat-box">
                    <?php
                        $orderCount = "SELECT COUNT(order_id) FROM orders ";
                        $resultC = mysqli_query($link, $orderCount);
                        $row = mysqli_fetch_assoc($resultC);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Orders</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['COUNT(order_id)']?></p>
                </div>
            </a>
            <a href="salesrpt.php">
                <div class="stat-box">
                    <?php
                        $sumCount = "SELECT SUM(total) FROM orders ";
                        $resultS = mysqli_query($link, $sumCount);
                        $row = mysqli_fetch_assoc($resultS);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Sales</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">RM <?=$row['SUM(total)']?></p>
                </div>
            </a>
            <a href="adminfed.php">
                <div class="stat-box">
                    <?php
                        $conCount = "SELECT COUNT(*) AS concount FROM contact";
                        $resultCon = mysqli_query($link, $conCount);
                        $row = mysqli_fetch_assoc($resultCon);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Feedback</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['concount']?></p>
                </div>
            </a>
        </div>
        
    </div>

   
    <!--footer area start-->

        <!--footer bottom area start-->
        <?php include('footer.php');?>
        <!--footer bottom area end-->

        <!-- QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                                <div class="product-images">
                                    <!--modal tab start-->
                                    <div class="portfolio-thumbnil-area-2">
                                        <div class="tab-content active-portfolio-area-2">
                                            <div role="tabpanel" class="tab-pane active" id="view1">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/01.jpg"
                                                            alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view2">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/02.jpg"
                                                            alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view3">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/03.jpg"
                                                            alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view4">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/04.jpg"
                                                            alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-more-views-2">
                                            <ul class="thumbnail-carousel-modal-2 nav" data-tabs="tabs">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="view1" data-bs-toggle="tab" href="#view1"
                                                        role="tab" aria-controls="view1" aria-selected="true">
                                                        <img
                                                        src="images/product/01.jpg" alt="" />
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="view2" data-bs-toggle="tab" href="#view2"
                                                        role="tab" aria-controls="view2" aria-selected="true">
                                                        <img
                                                        src="images/product/02.jpg" alt="" />
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="view3" data-bs-toggle="tab" href="#view3"
                                                        role="tab" aria-controls="view3" aria-selected="true">
                                                        <img
                                                        src="images/product/03.jpg" alt="" />
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="view4" data-bs-toggle="tab" href="#view4"
                                                        role="tab" aria-controls="view4" aria-selected="true">
                                                        <img
                                                        src="images/product/04.jpg" alt="" />
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--modal tab end-->
                                <!-- .product-images -->
                                <div class="product-info">
                                    <h1>Aenean eu tristique</h1>
                                    <div class="price-box-3">
                                        <div class="s-price-box"> <span class="new-price">$160.00</span> <span
                                                class="old-price">$190.00</span> </div>
                                    </div> <a href="shop.php" class="see-all">See all features</a>
                                    <div class="quick-add-to-cart">
                                        <form method="post" class="cart">
                                            <div class="numbers-row">
                                                <input type="number" id="french-hens" value="3" min="1">
                                            </div>
                                            <button class="single_add_to_cart_button" type="submit">Add to cart</button>
                                        </form>
                                    </div>
                                    <div class="quick-desc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Nam
                                        fringilla augue nec est tristique auctor. Donec non est at libero.Lorem ipsum
                                        dolor
                                        sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique
                                        auctor.
                                        Donec non est at libero.Nam fringilla tristique auctor. </div>
                                    <div class="social-sharing-modal">
                                        <div class="widget widget_socialsharing_widget">
                                            <h3 class="widget-title-modal">Share this product</h3>
                                            <ul class="social-icons-modal">
                                                <li><a title="Facebook" href="#" class="facebook m-single-icon"><i
                                                            class="fa fa-facebook"></i></a>
                                                </li>
                                                <li><a title="Twitter" href="#" class="twitter m-single-icon"><i
                                                            class="fa fa-twitter"></i></a></li>
                                                <li><a title="Pinterest" href="#" class="pinterest m-single-icon"><i
                                                            class="fa fa-pinterest"></i></a>
                                                </li>
                                                <li><a title="Google +" href="#" class="gplus m-single-icon"><i
                                                            class="fa fa-google-plus"></i></a>
                                                </li>
                                                <li><a title="LinkedIn" href="#" class="linkedin m-single-icon"><i
                                                            class="fa fa-linkedin"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- .product-info -->
                            </div>
                            <!-- .modal-product -->
                        </div>
                        <!-- .modal-body -->
                    </div>
                    <!-- .modal-content -->
                </div>
                <!-- .modal-dialog -->
            </div>
            <!-- END Modal -->
        </div>
        <!-- END QUICKVIEW PRODUCT -->
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
    function changeColor(element) {
        element.style.color = "red";
    }

    function restoreColor(element) {
        element.style.color = "black";
    }
    </script>

</body>

</html> 