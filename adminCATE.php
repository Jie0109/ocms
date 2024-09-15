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
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 95%;
  margin-left:40px;
  margin-bottom: 50px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}
#yourDataTableID_wrapper {
    margin-left: 50px;
    margin-right: 50px;
}

.single-prodcut-img {
    /* Set a specific width and height for the div */
    width: 160px;
    height: 120px;
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!--breadcumb area start -->
    <div class="breadcumb-area overlay pos-rltv">
        <div class="bread-main">
            <div class="bred-hading text-center">
                <h5>Orders</h5>
            </div>
            <ol class="breadcrumb">
                <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                <li class="active">Category</li>
            </ol>
        </div>
    </div>
        <!--breadcumb area end -->
    <div id="main" style="margin-top :10px;">
        <section>
            <table id="yourDataTableID" class="display">
                <thead>
                    <tr style="background-color: #D6EEEE;">
                        <th>Brand ID</th>
                        <th>Brand Name</th>
                        <th>Product Quantity</th>
                        <th>Brand Image</th>
                        <th>Size Chart</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                                                
                    $itemlist = "SELECT 
                    brand.brand_id,
                    brand.brand_name,
                    brand.brand_img,
                    brand.brand_chart,
                    COUNT(product.brand_id) AS product_count 
                FROM 
                    brand 
                LEFT JOIN 
                    product ON product.brand_id = brand.brand_id 
                WHERE 
                    brand.brand_name != 'Custom'
                GROUP BY 
                    brand.brand_id, brand.brand_name, brand.brand_img, brand.brand_chart";
                    $result = (mysqli_query($link, $itemlist));
                    if(mysqli_num_rows($result)>0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            
                            echo'
                                
                                    <tr>
                                        <td>'.$row['brand_id'].'</td>
                                        <td>'.$row['brand_name'].'</td>
                                        <td>'.$row['product_count'].'</td>
                                        <td><div class="single-prodcut-img"><img alt=""
                                        src="images/product/'.$row['brand_img'].'"</div></td>
                                        <td><div class="single-prodcut-img"><img alt=""
                                        src="images/product/'.$row['brand_chart'].'"</div></td>
                                    </tr>
                                ';
                        }
                    }
                ?>
                </tbody>
                
            </table>
            <!-- Add more content and features as needed -->
        </section>
    </div>

    <!-- footer area start-->
    
    <!--footer area start-->

        <!--footer bottom area start-->
        <?php include('footer.php');?>
        <!--footer bottom area end-->

        <script>
            $(document).ready(function () {
                var table = $('#yourDataTableID').DataTable({
                    "scrollY": "70vh",
                    "scrollCollapse": true,
                    "pagingType": "full_numbers",
                    dom: 'Bfrtip',
                    className: 'dt-body-right'
                });
            });
        </script>

</body>
</html>
