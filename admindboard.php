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
                <?php
                    $activeTimeFrame = date('Y-m-d H:i:s', strtotime('-30 days'));
                    $userCountActive = "SELECT COUNT(id) AS active_users FROM user WHERE mode = 'cust' AND lastLogin >= '$activeTimeFrame'";
                    $resultActive = mysqli_query($link, $userCountActive);
                    $rowActive = mysqli_fetch_assoc($resultActive);
                    $totalActiveUsers = $rowActive['active_users'];

                    $userCountNonActive = "SELECT COUNT(id) AS non_active_users FROM user WHERE mode = 'cust' AND lastLogin < '$activeTimeFrame'";
                    $resultNonActive = mysqli_query($link, $userCountNonActive);
                    $rowNonActive = mysqli_fetch_assoc($resultNonActive);
                    $totalNonActiveUsers = $rowNonActive['non_active_users'];
                ?>
                <div class="stat-box" style="width: 500px; height: 300px;">
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total Users</h3>
                    <canvas id="userChart" width="400" height="200"></canvas>
                </div>
            </a>
            <a href="adminproduct.php">
                <?php
                    $prodCount = "SELECT
                    (SELECT COUNT(*) FROM product ) AS total_products,
                    (SELECT COUNT(*) FROM brand WHERE brand_name != 'Custom') AS total_brands,
                    (SELECT SUM(CASE WHEN active IS NULL THEN 1 ELSE 0 END) FROM product) AS total_published,
                    (SELECT SUM(CASE WHEN active = 'no' THEN 1 ELSE 0 END)FROM product) AS total_archived;
                ";

                    $resultC = mysqli_query($link, $prodCount);
                    $row = mysqli_fetch_assoc($resultC);

                    $dataPoints = array(
                        "Total Product" => $row['total_products'],
                        "Published Product" => $row['total_published'],
                        "Archived Product" => $row['total_archived'],
                        "Total Brand" => $row['total_brands'],
                    );
                ?>
                <div class="stat-box" style="width: 530px; height: 300px;">
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Product</h3>
                    <canvas id="prodChart" style="width: 500px; height: 200px;"></canvas>
                </div>
            </a>
            <!--<a href="adminCATE.php">
                <div class="stat-box">
                    <?php
                        $catCount = "SELECT COUNT(*) AS brand_count FROM brand WHERE brand_name != 'Custom'";
                        $resultCat = mysqli_query($link, $catCount);
                        $row = mysqli_fetch_assoc($resultCat);
                    ?>
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Category</h3>
                    <p style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)"><?=$row['brand_count']?></p>
                </div>
            </a>-->
            
            <!-- Add more stat boxes as needed -->
        </div>
        <div class="stats">
            <a href="orderList.php">
                <?php
                    $ordCount = "SELECT status, COUNT(*) as status_count FROM orders GROUP BY status";

                    $resultO = mysqli_query($link, $ordCount);

                    $labels = [];
                    $data = [];

                    while ($row = mysqli_fetch_assoc($resultO)) {
                    $labels[] = $row['status'];
                    $data[] = $row['status_count'];
                    }
                ?>
                <div class="stat-box" style="width: 530px; height: 300px;">
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Orders</h3>
                    <canvas id="orderChart" style="width: 500px; height: 200px;"></canvas>
                </div>
            </a>
            <a href="adminfed.php">
                <?php
                $repliedFeedbackCountQuery = "SELECT COUNT(*) as repliedCount FROM contact WHERE reply = 'closed'";
                $repliedFeedbackCountResult = mysqli_query($link, $repliedFeedbackCountQuery);
                $repliedFeedbackCount = mysqli_fetch_assoc($repliedFeedbackCountResult)['repliedCount'];
            
                $unrepliedFeedbackCountQuery = "SELECT COUNT(*) as unrepliedCount FROM contact WHERE reply = 'pending'";
                $unrepliedFeedbackCountResult = mysqli_query($link, $unrepliedFeedbackCountQuery);
                $unrepliedFeedbackCount = mysqli_fetch_assoc($unrepliedFeedbackCountResult)['unrepliedCount'];
                ?>
                <div class="stat-box" style="width: 530px; height: 320px;">
                    <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total Feedback</h3>
                    <canvas id="replyChart" width="400" height="200"></canvas>
                </div>
            </a>
        </div>
        <div class="stat">
            <a href="salesrpt.php">
                <?php

                    $revenueCount = " SELECT
                                    YEAR(created) AS year,
                                    MONTH(created) AS month,
                                    SUM(total) AS total_cost
                                FROM
                                    orders
                                GROUP BY
                                    YEAR(created), MONTH(created)
                                ORDER BY
                                    YEAR(created), MONTH(created)";

                    $resultrSales = mysqli_query($link, $revenueCount);
                    $monthss = [];
                    $totalCosts = [];

                    while ($row = mysqli_fetch_assoc($resultrSales)) {
                        $monthss[] = "{$row['year']}-{$row['month']}";
                        $totalCosts[] = $row['total_cost'];
                    }

                    // Generate random background colors
                    $revenueChartColors = [];
                    for ($i = 0; $i < count(array_unique($monthss)); $i++) {
                        $revenueChartColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    }


                ?>
                <div class="stat-box" style="width: 900px; height: auto; margin-left: 300px;">
                <?php
                    $totalsum = "SELECT SUM(total) FROM orders";
                    $resultsum = mysqli_query($link, $totalsum);
                    $rowsum = mysqli_fetch_assoc($resultsum);
                ?>

                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total Revenue (RM <?=$rowsum['SUM(total)']?>)</h3>
                <canvas id="revenueeChart" width="1000" height="400"></canvas>
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

<script>
        var totalActiveUsers = <?php echo json_encode($totalActiveUsers); ?>;
        var totalNonActiveUsers = <?php echo json_encode($totalNonActiveUsers); ?>;
        
        var ctxCombined = document.getElementById('userChart').getContext('2d');
        var myCombinedChart = new Chart(ctxCombined, {
            type: 'bar',
            data: {
                labels: ['Active Users', 'Non-Active Users'],
                datasets: [
                    {
                        label: 'Active Users',
                        data: [totalActiveUsers, null],
                        backgroundColor: '#36A2EB',
                        borderColor: '#36A2EB',
                        borderWidth: 1,
                        barPercentage: 1, // Adjust bar width
                        categoryPercentage: 0.3,
                    },
                    {
                        label: 'Non-Active Users',
                        data: [null, totalNonActiveUsers],
                        backgroundColor: '#FFCE56',
                        borderColor: '#FFCE56',
                        borderWidth: 1,
                        barPercentage: 1, // Adjust bar width
                        categoryPercentage: 0.3,
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true
                }
            }
        });
    </script>

<script>
    // Get the data from PHP
    var dataPoints = <?php echo json_encode($dataPoints); ?>;

    // Create a new Chart instance for the pie chart
    var ctx = document.getElementById('prodChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(dataPoints),
            datasets: [{
                data: Object.values(dataPoints),
                backgroundColor: [
                    '#87CEEB',
                    '#228B22',
                    '#FFD700',
                    '#F4A460',
                ],
                borderColor: [
                    '#87CEEB',
                    '#228B22',
                    '#FFD700',
                    '#F4A460',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Disable responsive resizing
            aspectRatio: 2.5, // Adjust the aspect ratio to your desired value
            plugins: {
                legend: {
                    position: 'left', // Set legend position to left
                    labels: {
                        boxWidth: 20, // Adjust box width if needed
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            return label + ': ' + value;
                        }
                    }
                }

            }
        }
    });
</script>

<script>

    var labels = <?php echo json_encode($labels); ?>;
    var data = <?php echo json_encode($data); ?>;

    // Create data for the Chart.js
    var chartData = {
    labels: labels,
    datasets: [{
        data: data,
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
    }]
    };

    // Get the canvas element
    var ctx = document.getElementById('orderChart').getContext('2d');

    // Create a pie chart
    var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: chartData,
    options: {
        title: {
            display: true,
            text: 'Distribution of Order Status'
        },
        aspectRatio: 2.5
    }
    });

    // Set legend position to left
    myPieChart.legend.options.position = 'left';
    myPieChart.update();
</script>

<script>
    // Get the canvas element
    var ctx = document.getElementById('replyChart').getContext('2d');

    // Data for the pie chart
    var data = {
        labels: ['Replied Feedback', 'Unreplied Feedback'],
        datasets: [{
            data: [<?php echo $repliedFeedbackCount; ?>, <?php echo $unrepliedFeedbackCount; ?>],
            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
            borderWidth: 1,
        }]
    };

    // Configuration options
    var options = {
        legend: {
            position: 'left', // Position the legend on the left side
        },
        aspectRatio: 2
    };

    // Create a pie chart
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });

    myPieChart.legend.options.position = 'left';
    myPieChart.update();
</script>
<script>
var monthss = <?php echo json_encode($monthss); ?>;
var totalCosts = <?php echo json_encode($totalCosts); ?>;
var revenueChartColors = <?php echo json_encode($revenueChartColors); ?>;

// Create the Total Revenue bar chart
var ctx = document.getElementById('revenueeChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: monthss,
        datasets: [{
            label: 'Total Revenue',
            data: totalCosts,
            backgroundColor: revenueChartColors,
        }],
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
});
</script>

</body>

</html> 