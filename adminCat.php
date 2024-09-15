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

    $catErr = "";

    if(isset($_POST['addC']))
    {
        $filename1 = $_FILES["bimg"]["name"];
        $tempname1 = $_FILES["bimg"]["tmp_name"];
        $folder1 = "images/product/".$filename1;

        $filename2 = $_FILES["simg"]["name"];
        $tempname2 = $_FILES["simg"]["tmp_name"];
        $folder2 = "images/product/".$filename2;

        $upload1 = move_uploaded_file($tempname1, $folder1);
        $upload2 = move_uploaded_file($tempname2, $folder2);

        if(empty($_POST['cat_name']))
        {
            $catErr = "<b>Please enter a category name</b>";
        }
        elseif(strlen(trim($_POST['cat_name'])) == 0)
        {
            $catErr = "<b>Category name cannot be blank</b>";
        }
        else
        {
            $catName = $_POST['cat_name'];
        }

        if(empty($catErr))
        {
            $addCate = "INSERT INTO brand (brand_name, brand_img, brand_chart) VALUES ('$catName', '$filename1', '$filename2')";
            if(mysqli_query($link, $addCate))
            {
                echo "
                <script>
                Swal.fire({
                    title: 'New category added',
                    text: '$catName is published',
                    icon: 'success'
                }).then(function() {
                location.href = 'adminCATE.php'
                })
                </script>";
            }
        }
        
        
    }

?>
<style>
    .dataTable thead th {
    background-color: #f2f2f2;
}

/* Add some padding to the table cells */
.dataTable tbody td {
    padding: 8px;
}

.custom-datatable {
    border-collapse: collapse;
    width: 100%;
}

.custom-datatable tbody td {
    border: 1px solid #ddd;
    padding: 8px;
}

.single-prodcut-img {
    /* Set a specific width and height for the div */
    width: 100px;
    height: 100px;
    /* Add any other styles you need */
    
}

.single-prodcut-img img {
    /* Set a specific width and height for the images */
    width: 100%;
    height: 100%;
    /* Ensure images fill the container */
    object-fit: cover;
}
</style>
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Add Product</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                    <li class="active">Add Category</li>
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
                                        <li><a class="" href="modProd.php">Modify Product</a></li>
                                        <li><a class="active" href="adminCat.php">Add Category</a></li>
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
                                <div class="row">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="col-md-12">
                                            <div class="input-box mb-20">
                                                <label>Category Name<em>*</em></label>
                                                <input type="text" name="cat_name" class="info" placeholder="Example" value="" required>
                                                <span class="invalid-feedback d-block"><?php echo $catErr; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-box mb-20">
                                                <label>Brand Image<em>*</em></label>
                                                <input type="file" name="bimg" required>
                                            </div>
                                            <div class="input-box mb-20">
                                                <label>Size Chart<em>*</em></label>
                                                <input type="file" name="simg" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4 text-end">
                                            <input type="submit" name="addC" class="btn btn-dark" value="Add Category" style="margin-left: 773px;">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--service idea area are end -->

        <!-- footer area start-->
        

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

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#yourDataTableID').DataTable({
                "scrollY": "70vh",
                "scrollCollapse": true,
                "pagingType": "full_numbers",
                paging: false,
                dom: 'Bfrtip',
            });
        });
    </script>

    

</body>

</html>