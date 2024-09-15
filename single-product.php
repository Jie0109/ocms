<?php
    include("header.php");

    $items = "";
    
    if(isset($_GET["item_id"])) 
    {
        $sql = "SELECT * FROM product INNER JOIN brand ON product.brand_id = brand.brand_id WHERE item_id = " . $_GET["item_id"];
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
    }
    else
    {
        echo "
        <script>
        Swal.fire({
            title: 'Error 404',
            text: 'How can u saw this pages?!',
            icon: 'error'
        }).then(function() {
        location.href = 'shop.php'
        })
        </script>";
    }

    //if(isset($_GET["custom_id"])) 
    //{
    //    $sqls = "SELECT * FROM custom WHERE custom_id = " . $_GET["custom_id"];
    //    $results = mysqli_query($link, $sqls);
    //    $rows = mysqli_fetch_assoc($results);
    //}

    if(isset($_GET["item_id"])) 
    {
        $items = $_GET["item_id"];
    }
    else
    {
        $items = $_GET["custom_id"];
    }

    if(isset($_POST['addtocart']))
    {

        if (!isset($_SESSION["loggedin"])) {
            echo "
                <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Please log in first and then continue to shopping.',
                    icon: 'question'
                }).then(function() {
                location.href = 'login.php'
                })
                </script>";
        }
        else
        {
            if($_POST['qtybutton'] < 1)
            {
                echo "
                        <script>
                            Swal.fire({
                                title: 'Oops',
                                text: 'Your quantity cannot be zero.',
                                icon: 'error'
                            }).then(function() {
                            location.href = 'single-product.php?item_id=$items'
                            })
                        </script>  
                        ";
            }
            else
            {
                $checkSQL = "SELECT * FROM cart WHERE uid = ".$_SESSION['id'] ." AND item = $items AND size = ".$_POST['sizing'];
                if($resultSQL = mysqli_query($link, $checkSQL))
                {
                    if(mysqli_num_rows($resultSQL) == 1)
                    {
                        while ($rowSQL = mysqli_fetch_assoc($resultSQL)) 
                        {
                            $Quantity = $rowSQL['quantity'] + $_POST['qtybutton'];
                            $insert = "UPDATE cart SET quantity = $Quantity WHERE cart_id = " . $rowSQL['cart_id'];
                        }
                    }
                    else
                    {
                        $insert = "INSERT INTO cart (uid, item, quantity, size, paid) VALUES (".$_SESSION['id'].", $items, ".$_POST['qtybutton'].",".$_POST['sizing'].",'no')";
                    }
                }

                if(mysqli_query($link, $insert)) 
                {
                    echo "
                    <script>
                    Swal.fire({
                        title: 'Shopping cart',
                        text: 'Your product have been added',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'cart.php'
                    })</script>";
                }
            }
            
            
            
        }
    }
?>
        
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Prodcut Details</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Product Details</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!--single-protfolio-area are start-->
        <div class="single-protfolio-area ptb-70">
          <div class="container">
              <div class="row">
                    <div class="col-lg-7">
                       <div class="portfolio-thumbnil-area">
                        <div class="product-more-views">
                            <div class="tab_thumbnail" data-tabs="tabs">
                                <div class="thumbnail-carousel">
                                    <ul class="nav">
                                       <li>
                                        <a class="active" href="#view11" class="shadow-box" aria-controls="view11" data-bs-toggle="tab"><img src="images/product/<?php if(isset($_GET["item_id"]))echo $row['images']; else echo $rows['custom_img']; ?>" alt="" /></a></li>
                                       <li>
                                        <a href="#view22" class="shadow-box" aria-controls="view22" data-bs-toggle="tab"><img src="images/product/<?php if(isset($_GET["item_id"])) echo $row['imgs']; else echo $rows['custom_imgs'];?>" alt="" /></a></li>
                                       <li>
                                        <a href="#view33" class="shadow-box" aria-controls="view33" data-bs-toggle="tab"><img src="images/product/03.jpg" alt="" /></a></li>
                                       <li>
                                        <a href="#view44" class="shadow-box" aria-controls="view44" data-bs-toggle="tab"><img src="images/product/04.jpg" alt="" /></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content active-portfolio-area pos-rltv">
                           <div class="social-tag">
                              <a href="#"><i class="zmdi zmdi-share"></i></a>
                           </div>
                            <div role="tabpanel" class="tab-pane active" id="view11">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/<?php if(isset($_GET["item_id"]))echo $row['images']; else echo $rows['custom_img']; ?>"><img src="images/product/<?php if(isset($_GET["item_id"]))echo $row['images']; else echo $rows['custom_img']; ?>" alt="Single portfolio" /></a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="view22">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/<?php if(isset($_GET["item_id"])) echo $row['imgs']; else echo $rows['custom_imgs'];?>"><img src="images/product/<?php if(isset($_GET["item_id"])) echo $row['imgs']; else echo $rows['custom_imgs'];?>" alt="Single portfolio" /></a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="view33">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/03.jpg"><img src="images/product/03.jpg" alt="Single portfolio" /></a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="view44">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/04.jpg"><img src="images/product/04.jpg" alt="Single portfolio" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-5">
                        <div class="single-product-description">
                            <form action="" method="post">
                                <div class="sp-top-des">
                                    <h3><?php if(isset($_GET["item_id"]))echo $row['item']; else echo 'Customize';?><span>(<?php if(isset($_GET["item_id"])) echo $row['brand_name']; else echo 'Custom Design';?>)</span></h3>
                                    <div class="prodcut-ratting-price">
                                        <div class="prodcut-ratting"> 
                                            <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                            <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                            <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                            <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                            <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                        </div>
                                        <div class="prodcut-price">
                                            <div class="new-price">RM <?php if(isset($_GET["item_id"])) echo $row['cost']; else echo '100';?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="sp-des">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum</p>
                                </div>
                                <div class="sp-bottom-des">
                                    <div class="single-product-option">
                                        <!--<div class="sort product-type">
                                            <label>Color: </label>
                                            <select id="input-sort-color">
                                                <option value="#">Black</option>
                                                <option value="#">White</option>
                                                <option value="#" selected>Chose Your Color</option>
                                            </select>
                                        </div>-->
                                        <div class="sort product-type">
                                            <label>Size: </label>
                                            <select id="input-sort-size" name=sizing required>
                                                <option value="1" name="1">1</option>
                                                <option value="2" name="2">2</option>
                                                <option value="#" selected="">Chose Your Size</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="quantity-area">
                                        <label>Qty :</label>
                                        <div class="cart-quantity">
                                            <div class="product-qty">
                                                <div class="cart-quantity">
                                                    <div class="cart-plus-minus">
                                                        <div class="dec qtybutton">-</div>
                                                            <input type="text" value="1" name="qtybutton" class="cart-plus-minus-box" readonly>
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="social-icon socile-icon-style-1" id="addToCartContainer" style="display: none;">
                                    <ul>
                                        <li><input type="submit" name="addtocart" value="Add To Cart" style="padding: 5px; background-color:white; border-color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"></li>
                                        <!--<li><a href="#" data-tooltip="Wishlist" class="w-list" tabindex="0"><i class="fa fa-heart-o"></i></a></li>
                                        <li><a href="#" data-tooltip="Compare" class="cpare" tabindex="0"><i class="fa fa-refresh"></i></a></li>
                                        <li><a href="#" data-tooltip="Quick View" class="q-view" data-bs-toggle="modal" data-bs-target=".modal" tabindex="0"><i class="fa fa-eye"></i></a></li>-->
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
          </div>  
        </div>
        </div>
        <!--single-protfolio-area are start-->
        
        <!--descripton-area start -->
        <div class="descripton-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-area tab-cars-style">
                            <div class="title-tab-product-category row">
                                <div class="col-lg-12 text-center">
                                    <ul class="nav mb-40 heading-style-2" role="tablist">
                                        <li role="presentation"><a href="#newarrival" aria-controls="newarrival" role="tab" data-bs-toggle="tab">Description</a></li>
                                        <li role="presentation"><a class="active" href="#bestsellr" aria-controls="bestsellr" role="tab" data-bs-toggle="tab">Review</a></li>
                                        <li role="presentation"><a href="#specialoffer" aria-controls="specialoffer" role="tab" data-bs-toggle="tab">Size Chart</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="content-tab-product-category">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fix fade in" id="newarrival">
                                        <div class="review-wraper">
                                            <img src="images/product/<?php echo $row['brand_img'];?>" alt="" style="max-width: 100%; max-height: 100%; display: block;">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                <br> veniam, quis nostrud exercitation.</p>
                                            <h5>ABOUT ME</h5>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English</p>
                                            <h5>SIZE & FIT</h5>
                                            <ul>
                                                <li>Model wears: Style Photoliya U2980</li>
                                                <li>Model's height: 185”66</li>
                                            </ul>
                                            <h5>Overview</h5>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fix fade show active" id="bestsellr">
                                        <div class="review-wraper">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim <br> veniam, quis nostrud exercitation.</p>
                                           <h5>SIZE & FIT</h5>
                                           <ul>
                                               <li>Model wears: Style Photoliya U2980</li>
                                               <li>Model's height: 185”66</li>
                                           </ul>
                                            <h5>ABOUT ME</h5>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English</p>
                                           <h5>Overview</h5>
                                           <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.</p>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fix fade in" id="specialoffer">
                                        <b>
                                        The size and cutting of each brand are different. Please refer to the size table when choosing items. <br>

                                        If your size is between two sizes, please contact our customer service for further assistance.
                                        </b>
                                        <img src="images/product/<?php echo $row['brand_chart'];?>" style="max-width: 100%; max-height: 100%; display: block;" alt="">
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <br>
        <!--descripton-area end--> 
        
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                              <div class="product-images"> 
                                   <!--modal tab start-->
                                    <div class="portfolio-thumbnil-area-2">
                                        <div class="tab-content active-portfolio-area-2">
                                            <div role="tabpanel" class="tab-pane active" id="view1">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/01.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view2">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/02.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view3">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/03.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view4">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/04.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-more-views-2">
                                            <div class="thumbnail-carousel-modal-2 nav" data-tabs="tabs">
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
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--modal tab end-->
                                    <!-- .product-images -->
                                    <div class="product-info">
                                        <h1>Aenean eu tristique</h1>
                                        <div class="price-box-3">
                                            <div class="s-price-box"> <span class="new-price">$160.00</span> <span class="old-price">$190.00</span> </div>
                                        </div> <a href="shop.html" class="see-all">See all features</a>
                                        <div class="quick-add-to-cart">
                                            <form method="post" class="cart">
                                                <div class="numbers-row">
                                                    <input type="number" id="french-hens" value="3" min="1"> </div>
                                                <button class="single_add_to_cart_button" type="submit">Add to cart</button>
                                            </form>
                                        </div>
                                        <div class="quick-desc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.Nam fringilla tristique auctor. </div>
                                        <div class="social-sharing-modal">
                                            <div class="widget widget_socialsharing_widget">
                                                <h3 class="widget-title-modal">Share this product</h3>
                                                <ul class="social-icons-modal">
                                                    <li><a  title="Facebook" href="#" class="facebook m-single-icon"><i class="fa fa-facebook"></i></a></li>
                                                    <li><a  title="Twitter" href="#" class="twitter m-single-icon"><i class="fa fa-twitter"></i></a></li>
                                                    <li><a  title="Pinterest" href="#" class="pinterest m-single-icon"><i class="fa fa-pinterest"></i></a></li>
                                                    <li><a  title="Google +" href="#" class="gplus m-single-icon"><i class="fa fa-google-plus"></i></a></li>
                                                    <li><a  title="LinkedIn" href="#" class="linkedin m-single-icon"><i class="fa fa-linkedin"></i></a></li>
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
    document.getElementById("input-sort-size").addEventListener("change", function() {
        var selectedSize = this.value;
        var addToCartContainer = document.getElementById("addToCartContainer");

        if (selectedSize !== "#") {
            addToCartContainer.style.display = "block";
        } else {
            addToCartContainer.style.display = "none";
        }
    });

    document.getElementById("addToCart").addEventListener("click", function() {
        // Perform the add to cart action here
        alert("Item added to cart!");
    });
    </script>

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