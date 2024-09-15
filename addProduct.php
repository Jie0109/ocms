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

    $nameErr = $brandErr = $priceErr = "";

    if(isset($_POST['addP']))
    {
        function isImage($filename)
    {
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        $file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($file_extension, $allowed_extensions);
    }

    $filename1 = $_FILES["img1"]["name"];
    $tempname1 = $_FILES["img1"]["tmp_name"];
    $folder1 = "images/product/" . $filename1;

    $filename2 = $_FILES["img2"]["name"];
    $tempname2 = $_FILES["img2"]["tmp_name"];
    $folder2 = "images/product/" . $filename2;

    $upload1 = move_uploaded_file($tempname1, $folder1);
    $upload2 = move_uploaded_file($tempname2, $folder2);

    if (empty($_POST['item_name'])) {
        $nameErr = "<b>Please enter an item name</b>";
    } elseif (strlen(trim($_POST['item_name'])) == 0) {
        $nameErr = "<b>Item name cannot be blank</b>";
    } else {
        $itemName = $_POST['item_name'];
    }

    if (empty($_POST['item_price'])) {
        $priceErr = "<b>Please enter item price</b>";
    } elseif (strlen(trim($_POST['item_price'])) == 0) {
        $priceErr = "<b>Item price cannot be blank</b>";
    } else {
        $itemPrice = $_POST['item_price'];
    }

    if (empty($_POST['brand'])) {
        $brandErr = "<b>Please enter item brand</b>";
    } elseif (strlen(trim($_POST['brand'])) == 0) {
        $brandErr = "<b>Item brand cannot be blank</b>";
    } else {
        $itemBrand = $_POST['brand'];
    }

    if (empty($nameErr) && empty($priceErr) && empty($brandErr) && isImage($filename1) && isImage($filename2)) {
        $addProd = "INSERT INTO product (item, cost, images, imgs, brand_id, userID) VALUES ('$itemName', '$itemPrice', '$filename1', '$filename2', '$itemBrand', NULL)";
        if (mysqli_query($link, $addProd)) {
            echo "
                <script>
                Swal.fire({
                    title: 'New product added',
                    text: '$itemName is published',
                    icon: 'success'
                }).then(function() {
                location.href = 'adminproduct.php'
                })
                </script>";
        } else {
            // Display error message if sName or image validation fails
            echo "
                    <script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Invalid input or file type. Please check your inputs and make sure you upload valid images.',
                        icon: 'error'
                    }).then(function() {
                    location.href = 'addProduct.php'
                    })</script>";
        }
    } else {
        // Display error message if sName or image validation fails
        echo "
                <script>
                Swal.fire({
                    title: 'Error',
                    text: 'Invalid input or file type. Please check your inputs and make sure you upload valid images.',
                    icon: 'error'
                }).then(function() {
                location.href = 'addProduct.php'
                })</script>";
    }
        
        
    }
?>

        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Add Product</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                    <li class="active">Add Product</li>
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
                                            <li><a class="active" href="my-account.php">Personal Info</a></li>
                                            <li><a class="" href="my-design.php">Customization</a></li>
                                            <li><a class="" href="my-password.php">Password</a></li>
                                            <li><a class="" href="my-order.php">My Order</a></li>
                                            <li><a class="" href="paymentmethod.php">Payment Method</a></li>
                                        ';
                                    }
                                    else
                                    {
                                        echo'
                                        <li><a class="active" href="addProduct.php">Add Product</a></li>
                                        <li><a class="" href="modProd.php">Modify Product</a></li>
                                        <li><a class="" href="adminCat.php">Add Category</a></li>
                                        <li><a class="" href="my-password.php">Password</a></li>
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
                                <div role="tabpanel" class="tab-pane fade show active" id="">
                                    <div class="row">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Product Name<em>*</em></label>
                                                    <input type="text" name="item_name" class="info" placeholder="Shirt" value="" required>
                                                    <span class="invalid-feedback d-block"><?php echo $nameErr; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Product Price<em>*</em></label>
                                                    <input type="number" name="item_price" class="info" placeholder="188" value="" required>
                                                    <span class="invalid-feedback d-block"><?php echo $priceErr; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Product Brand<em>*</em></label>
                                                    <select id="brand-type" name="brand" required>
                                                        <?php
                                                            $brand = "SELECT * FROM brand";
                                                            $result = mysqli_query($link, $brand);
                                                            if(mysqli_num_rows($result) > 0)
                                                            {
                                                                while($row = mysqli_fetch_assoc($result))
                                                                {
                                                                    echo'<option value="'.$row['brand_id'].'" name="brand">'.$row['brand_name'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="#" selected="">Select Brand</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>Front Image<em>*</em></label>
                                                    <input type="file" name="img1" required>
                                                </div>
                                                <div class="input-box mb-20">
                                                    <label>Rear Image<em>*</em></label>
                                                    <input type="file" name="img2" required>
                                                </div>
                                            </div>
                                        
                                            <!--<div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>Phone Number<em>*</em></label>
                                                    <input type="text" name="phone" class="info" placeholder="Phone Number">
                                                </div>
                                            </div>-->
                                            <!--<div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>Country <em>*</em></label>
                                                    <select class="selectpicker select-custom" data-live-search="true">
                                                        <option data-tokens="Bangladesh">Bangladesh</option>
                                                        <option data-tokens="India">India</option>
                                                        <option data-tokens="Pakistan">Pakistan</option>
                                                        <option data-tokens="Pakistan">Pakistan</option>
                                                        <option data-tokens="Srilanka">Srilanka</option>
                                                        <option data-tokens="Nepal">Nepal</option>
                                                        <option data-tokens="Butan">Butan</option>
                                                        <option data-tokens="USA">USA</option>
                                                        <option data-tokens="England">England</option>
                                                        <option data-tokens="Brazil">Brazil</option>
                                                        <option data-tokens="Canada">Canada</option>
                                                        <option data-tokens="China">China</option>
                                                        <option data-tokens="Koeria">Koeria</option>
                                                        <option data-tokens="Soudi">Soudi Arabia</option>
                                                        <option data-tokens="Spain">Spain</option>
                                                        <option data-tokens="France">France</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <!--<div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>Town/City <em>*</em></label>
                                                    <input type="text" name="add1" class="info" placeholder="Town/City">
                                                </div>
                                            </div>-->
                                            <!--<div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>State/Divison <em>*</em></label>
                                                    <select class="selectpicker select-custom" data-live-search="true">
                                                        <option data-tokens="Barisal">Barisal</option>
                                                        <option data-tokens="Dhaka">Dhaka</option>
                                                        <option data-tokens="Kulna">Kulna</option>
                                                        <option data-tokens="Rajshahi">Rajshahi</option>
                                                        <option data-tokens="Sylet">Sylet</option>
                                                        <option data-tokens="Chittagong">Chittagong</option>
                                                        <option data-tokens="Rangpur">Rangpur</option>
                                                        <option data-tokens="Maymanshing">Maymanshing</option>
                                                        <option data-tokens="Cox">Cox's Bazar</option>
                                                        <option data-tokens="Saint">Saint Martin</option>
                                                        <option data-tokens="Kuakata">Kuakata</option>
                                                        <option data-tokens="Sajeq">Sajeq</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                            <!--<div class="col-md-6">
                                                <div class="input-box mb-20">
                                                    <label>Post Code/Zip Code<em>*</em></label>
                                                    <input type="text" name="zipcode" class="info" placeholder="Zip Code">
                                                </div>
                                            </div>-->
                                            <!--<div class="col-lg-12">
                                                <div class="input-box mb-20">
                                                    <label>Address <em>*</em></label>
                                                    <input type="text" name="add1" class="info mb-10"
                                                        placeholder="Street Address">
                                                    <input type="text" name="add2" class="info mt10"
                                                        placeholder="Apartment, suite, unit etc. (optional)">
                                                </div>
                                            </div>-->
                                            <div class="col-lg-6 col-md-8">
                                                <div class="checkbox checkbox-2">
                                                    <!--<label> <small>
                                                            <input name="signup" type="checkbox">I wish to subscribe to the The
                                                            clothing newsletter.
                                                        </small> </label>
                                                    <br>-->
                                                    <!--<label> <small>
                                                            <input name="signup" type="checkbox">I have read and agree to the <a
                                                                href="#">Privacy Policy</a>
                                                        </small> </label>-->
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-4 text-end" id="payContainer" style="display: none;">
                                                <input type="submit" name="addP" class="btn btn-dark" value="Add Product" style="margin-left: 773px;">
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

        <!-- footer area start-->
       
        <!--footer area start-->

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
        document.getElementById("brand-type").addEventListener("change", function() {
            var selectedSize = this.value;
            var payContainer = document.getElementById("payContainer");

            if (selectedSize !== "#") {
                payContainer.style.display = "block";
            }
            else {
                payContainer.style.display = "none";
            }
        });
    </script>

</body>

</html>