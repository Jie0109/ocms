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

    if(isset($_POST['arcP']))
    {
        $arcItem = $_POST['mod_name'];

        $sql = "UPDATE product SET active = 'no' WHERE item_id = $arcItem";
        if(mysqli_query($link, $sql))
        {
            echo "
            <script>
            Swal.fire({
                title: 'Product has been archived',
                text: 'An item has been archived',
                icon: 'success'
            }).then(function() {
            location.href = 'adminproduct.php'
           })
            </script>";
        }
        
    }

    if(isset($_POST['pbeP']))
    {

        $sql = "UPDATE product SET active = NULL WHERE item_id =".$_POST['mods_name'];
        if(mysqli_query($link, $sql))
        {
            echo "
            <script>
            Swal.fire({
                title: 'Product has been published',
                text: 'An item has been published',
                icon: 'success'
            }).then(function() {
            location.href = 'adminproduct.php'
            })
            </script>";
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
                    <li class="active">Modify Product</li>
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
                                            <li><a class="" href="addProduct.php">Add Product</a></li>
                                            <li><a class="active" href="modProd.php">Modify Product</a></li>
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
                                        <form action="" method="post">
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Archive Product<em>*</em></label>   
                                                    <select id="name-type" name="mod_name" required>
                                                        <?php
                                                            $pName = "SELECT * FROM product WHERE userID is null AND active is null";
                                                            $result = mysqli_query($link, $pName);
                                                            if(mysqli_num_rows($result) > 0)
                                                            {
                                                                while($row = mysqli_fetch_assoc($result))
                                                                {
                                                                    echo'<option value="'.$row['item_id'].'" name="mod_name">'.$row['item'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="#" selected="">Select Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-4 text-end" id="payContainer" style="display: none;">
                                                <input type="submit" name="arcP" class="btn btn-dark" value="Archive Product" style="margin-left: 750px;">
                                            </div>
                                        </form>
                                        <form action="" method="post">
                                            <div class="col-md-12">
                                                <div class="input-box mb-20">
                                                    <label>Publish Product<em>*</em></label>
                                                    <select id="names-type" name="mods_name" required>
                                                        <?php
                                                            $PName = "SELECT * FROM product WHERE userID is null AND active = 'no'";
                                                            $result = mysqli_query($link, $PName);
                                                            if(mysqli_num_rows($result) > 0)
                                                            {
                                                                while($row = mysqli_fetch_assoc($result))
                                                                {
                                                                    echo'<option value="'.$row['item_id'].'" name="mod_name">'.$row['item'].'</option>';
                                                                }
                                                            }
                                                        ?>
                                                        <option value="#" selected="">Select Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-4 text-end" id="payContainers" style="display: none;">
                                                <input type="submit" name="pbeP" class="btn btn-dark" value="Publish Product" style="margin-left: 752px;">
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
        document.getElementById("name-type").addEventListener("change", function() {
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

    <script>
        document.getElementById("names-type").addEventListener("change", function() {
            var selectedSize = this.value;
            var payContainer = document.getElementById("payContainers");

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