<?php
    include("header.php");

    if(isset($_GET["item_id"])) 
    {
        $sql = "SELECT * FROM product INNER JOIN brand ON product.brand_id = brand.brand_id WHERE item_id = " . $_GET["item_id"];
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    $sNameErr = "";

    if(isset($_POST['upload']))
    {
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
        else
        {
            function isImage($file)
            {
                $allowed_mime_types = array("image/jpeg", "image/png", "image/gif");
                $mime_type = mime_content_type($file);
                return in_array($mime_type, $allowed_mime_types);
            }

            $filename1 = $_FILES["img1"]["name"];
            $tempname1 = $_FILES["img1"]["tmp_name"];
            $folder1 = "images/product/".$filename1;
    
            $filename2 = $_FILES["img2"]["name"];
            $tempname2 = $_FILES["img2"]["tmp_name"];
            $folder2 = "images/product/".$filename2;

    
            if(empty($_POST["sName"]))
            {
                $sNameErr = "<b>Please enter a name</b>";
            }
            elseif(strlen(trim($_POST['sName'])) == 0)
            {
                $sNameErr = "<b>Cannot be blank</b>";
            }
            else
            {
                $sName = $_POST["sName"];
            }
    
            if(empty($sNameErr) && isImage($tempname1) && isImage($tempname2))
            {
                $sql = "INSERT INTO product (images, userID, imgs, item, cost, brand_id) VALUES ('$filename1', ".$_SESSION['id'].", '$filename2' ,'$sName','100','800000003')";
                $run = mysqli_query($link, $sql);
        
                //move uploaded image into folder
                $upload1 = move_uploaded_file($tempname1, $folder1);
                $upload2 = move_uploaded_file($tempname2, $folder2);
        
                 if ($upload1 && $upload2) {
                    $msg = "Images uploaded successfully";
                } else {
                    $msg = "Failed to upload images";
                }
                $activeTimeFrame = date('Y-m-d H:i:s'); 
                $actCustom = "INSERT INTO userlogs (userid, activity, times) VALUES (".$_SESSION['id'].", 'uploaded an customize image', '$activeTimeFrame')";
                mysqli_query($link,$actCustom);
                /*echo "
                <script>
                alert('$msg');
                location.href = 'customize.php';
                </script>";*/
                
                echo "
                    <script>
                    Swal.fire({
                        title: 'Submitted',
                        text: '$msg.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'my-design.php'
                    })</script>";
            }else {
                // Display error message if sName or image validation fails
                echo "
                    <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Invalid input or file type. Please check your inputs and make sure you upload valid images.',
                        icon: 'error'
                    }).then(function() {
                    location.href = 'customize.php'
                    })</script>";
            }
           
        }

       
    }
?>
        
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Customization</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Customization</li>
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
                                        <a class="active" href="#view11" class="shadow-box" aria-controls="view11" data-bs-toggle="tab"><img src="images/product/infront.jpg" alt="" /></a></li>
                                        <li>
                                        <a href="#view22" class="shadow-box" aria-controls="view22" data-bs-toggle="tab"><img src="images/product/back.png" alt="" /></a></li>
                                        <li>
                                        <a href="#view33" class="shadow-box" aria-controls="view33" data-bs-toggle="tab"><img src="images/product/custom.jpg" alt="" /></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content active-portfolio-area pos-rltv">
                            <div role="tabpanel" class="tab-pane active" id="view11">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/infront.jpg"><img src="images/product/infront.jpg" alt="Single portfolio" /></a>
                                    <a style="height: 35px; margin-left: 185px;" class="btn btn-success px-4" href="infront.php">Customize</a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="view22">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/back.png"><img src="images/product/back.png" alt="Single portfolio" /></a>
                                    <a style="height: 35px; margin-left: 185px;" class="btn btn-success px-4" href="back.php">Customize</a>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="view33">
                                <div class="product-img">
                                    <a class="fancybox" data-fancybox-group="group" href="images/product/custom.jpg"><img src="images/product/custom.jpg" alt="Single portfolio" /></a>
                                    <form action="" method="POST" style="margin-top: 15px;" enctype="multipart/form-data">
                                        <h5>Front images you have capture screenshot.</h5>
                                        <input type="file" name="img1" required>

                                        <h5>Second images you have capture screenshot.</h5>
                                        <input type="file" name="img2" required>
                                        <br>
                                        <div class="input-box mb-20">
                                            <label class="control-label">Shirt Name:</label>
                                            <input type="text" placeholder="Custom" value="" name="sName" class="info" required>
                                            <span class="invalid-feedback d-block"><?php echo $sNameErr; ?></span>
                                        </div>

                                        <br>

                                        <input type="submit" name="upload" value="Upload Image" required>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-lg-5">
                        <div class="single-product-description">
                           <div class="sp-top-des">
                                <h3>Customization<span>(Your Design)</span></h3>
                                <div class="prodcut-ratting-price">
                                    <div class="prodcut-ratting"> 
                                        <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                        <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                        <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                        <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                        <a href="#" tabindex="0"><i class="fa fa-star-o"></i></a> 
                                    </div>
                                    <div class="prodcut-price">
                                        <div class="new-price">RM 100</div>
                                        <div class="old-price"> <del>$250</del> </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="sp-des">
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum</p>
                            </div>
                            <div class="sp-bottom-des">
                                <div>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Guide</button>
                                        <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="max-width: 60%;">
                                                <div class="modal-content">
                                                    <!-- Add image inside the body of modal -->
                                                    <div class="modal-body">
                                                        <img id="image1" src="images/icons/here.png" alt="Click on button" style="width:100%; height: 100%;"></img>
                                                        <img id="image2" src="images/icons/front2.png" alt="Click on button" style="width:100%; height: 100%;"></img>
                                                        <img id="image3" src="images/icons/uploadcus.png" alt="Click on button" style="width:100%; height: 100%;"></img>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" style="border-radius: 5px;" class="btn btn-danger" data-dismiss="modal">
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            <!--<div class="single-product-option">
                                <div class="sort product-type">
                                    <label>Color: </label>
                                    <select id="input-sort-color">
                                        <option value="#">Red</option>
                                        <option value="#">Blue</option>
                                        <option value="#">Green</option>
                                        <option value="#">Purple</option>
                                        <option value="#">Yellow</option>
                                        <option value="#">Black</option>
                                        <option value="#">Grey</option>
                                        <option value="#">White</option>
                                        <option value="#" selected>Chose Your Color</option>
                                    </select>
                                </div>
                                <div class="sort product-type">
                                    <label>Size: </label>
                                    <select id="input-sort-size">
                                        <option value="#">S</option>
                                        <option value="#">M</option>
                                        <option value="#">L</option>
                                        <option value="#">XL</option>
                                        <option value="#">XXL</option>
                                        <option value="#" selected="">Chose Your Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="quantity-area">
                                <label>Qty :</label>
                                <div class="cart-quantity">
                                    <form action="#" method="POST" id="myform">
                                        <div class="product-qty">
                                            <div class="cart-quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                        <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="social-icon socile-icon-style-1">
                                <ul>
                                    <li><a href="#" data-tooltip="Add To Cart" class="add-cart add-cart-text" data-placement="left" tabindex="0">Add To Cart<i class="fa fa-cart-plus"></i></a></li>
                                    <li><a href="#" data-tooltip="Wishlist" class="w-list" tabindex="0"><i class="fa fa-heart-o"></i></a></li>
                                    <li><a href="#" data-tooltip="Compare" class="cpare" tabindex="0"><i class="fa fa-refresh"></i></a></li>
                                    <li><a href="testing.php"><i class="fa fa-eye"></i></a></li>
                                </ul>
                            </div>-->
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
                                            <img src="images/product/<?php $sql = "SELECT * FROM brand WHERE brand_name = 'Custom'";
                                                                            $results = mysqli_query($link, $sql);
                                                                            $rows = mysqli_fetch_assoc($results);
                                                                            echo $rows['brand_img'];?>" alt="" style="max-width: 100%; max-height: 100%; display: block;">
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
                                        <img src="images/product/chart.jpg" style="max-width: 100%; max-height: 100%; display: block;" alt="">
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

    <script>
        // Add this JavaScript to automatically open the modal on page load
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        });
    </script>

</body>

</html>