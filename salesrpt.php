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

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

</style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <?php 
        $user = "SELECT * FROM user WHERE id = ".$_SESSION['id'];
        $userR = mysqli_query($link, $user);
        $row = (mysqli_fetch_assoc($userR));
    ?>

        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Sales Report</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                    <li class="active">Sales Report</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

    <div id="main">
        <!-- Trigger/Open The Modal -->
        <button id="myBtn" style="background-color: #04AA6D; border: none; float: right;">Sales Filters</button>
        <div class="stats">
            <div class="stat-box" style="width: 900px; height: auto; margin-left: 95px;">
                <?php
                    
                    // Check if year and month filters are set by the user
                    $selectedYear = isset($_GET['year']) ? $_GET['year'] : null;
                    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : null;

                    $days = [];
                    $dailyOrderCounts = [];
                    $months = [];
                    $orderCounts = [];
                    $salesChartColors = [];

                    if ($selectedYear && $selectedMonth) {
                        // Query for daily data
                        $dailyCountQuery = "SELECT DAY(created) AS day, COUNT(*) AS order_count 
                                            FROM orders 
                                            WHERE YEAR(created) = $selectedYear AND MONTH(created) = $selectedMonth 
                                            GROUP BY DAY(created)";
                        $result = mysqli_query($link, $dailyCountQuery);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $days[] = 'Day ' . $row['day'];
                            $dailyOrderCounts[] = $row['order_count'];
                        }
                    } else {
                        // Query for monthly data
                        $monthlyCountQuery = "SELECT YEAR(created) AS year, MONTH(created) AS month, COUNT(*) AS order_count 
                                            FROM orders 
                                            GROUP BY YEAR(created), MONTH(created)";
                        $result = mysqli_query($link, $monthlyCountQuery);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $months[] = "{$row['year']}-{$row['month']}";
                            $orderCounts[] = $row['order_count'];
                        }
                    }

                    // Generate random background colors for the chart
                    for ($i = 0; $i < max(count($days), count($months)); $i++) {
                        $salesChartColors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    }


                    $orderidc = "SELECT COUNT(order_id) FROM orders";

                    // Apply the same filter conditions as before
                    if ($selectedYear && $selectedMonth) {
                        $orderidc .= " WHERE YEAR(created) = $selectedYear AND MONTH(created) = $selectedMonth";
                    } elseif ($selectedYear) {
                        $orderidc .= " WHERE YEAR(created) = $selectedYear";
                    } elseif ($selectedMonth) {
                        $orderidc .= " WHERE MONTH(created) = $selectedMonth";
                    }
                    
                    // Perform the query
                    $resultccc = mysqli_query($link, $orderidc);
                    $rowccc = mysqli_fetch_assoc($resultccc);
                    
                    // Display the count
                    $totalSalesCount = $rowccc ? $rowccc['COUNT(order_id)'] : 0;

                   
                ?>

                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total Sales (<?=$totalSalesCount?> order made)</h3>
                <canvas id="revenueChart" width="1000" height="400"></canvas>
            </div>
        </div>
        <div class="stats">
            <div class="stat-box" style="width: 900px; height: auto;">
            <?php
                // Adjust the totalsum query based on the selected options
                $totalsumCondition = $selectedYear && $selectedMonth ? " WHERE YEAR(created) = $selectedYear AND MONTH(created) = $selectedMonth" : "";
                $totalsum = "SELECT SUM(total) FROM orders" . $totalsumCondition;
                $resultsum = mysqli_query($link, $totalsum);
                $rowsum = mysqli_fetch_assoc($resultsum);

                // Default monthly revenue query
                $revenueCount = "SELECT YEAR(created) AS year, MONTH(created) AS month, SUM(total) AS total_cost 
                                FROM orders 
                                GROUP BY YEAR(created), MONTH(created) 
                                ORDER BY YEAR(created), MONTH(created)";
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

                // Daily revenue data if year and month are selected
                if ($selectedYear && $selectedMonth) {
                    $dailyRevenueQuery = "SELECT DAY(created) AS day, SUM(total) AS total_cost 
                                        FROM orders 
                                        WHERE YEAR(created) = $selectedYear AND MONTH(created) = $selectedMonth 
                                        GROUP BY DAY(created)";
                    $resultDailyRevenue = mysqli_query($link, $dailyRevenueQuery);
                    
                    $days = [];
                    $dailyTotalCosts = [];

                    while ($row = mysqli_fetch_assoc($resultDailyRevenue)) {
                        $days[] = 'Day ' . $row['day'];
                        $dailyTotalCosts[] = $row['total_cost'];
                    }
                }
            ?>

            <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total Revenue (RM <?=$rowsum['SUM(total)']?>)</h3>
            <canvas id="revenueeChart" width="1000" height="400"></canvas>
            </div>
        </div>
        <button id="toggleTableButton" style="color: white; margin-bottom: 10px; border: none; margin-left: 1288px; padding: 5px; background-color: #04AA6D;">Sales Report Table</button>
        <div id="tableContainer" style="display: none;">
            <table id="yourDataTableID" class="display">
                <thead>
                    <tr style="background-color: #D6EEEE;">
                        <th>Order ID</th>
                        <th>Recipient Name</th>
                        <th>Contact</th>
                        <th>Total</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $userlist = "SELECT * FROM orders";
                        $result = mysqli_query($link, $userlist);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                    <tr>
                                        <td>' . $row['order_id'] . '</td>
                                        <td>' . $row['recipient_name'] . '</td>
                                        <td>' . $row['phoneNo'] . '</td>
                                        <td>' . $row['total'] . '</td>
                                        <td>' . $row['created'] . '</td>
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Add more content and features as needed --> 
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <form action="" method="get">
            <span class="close">&times;</span>
            <h2>Filter Data</h2>
            
            <!-- Year Filter -->
            <div class="filter-section">
                <h4>Year</h4>
                <select id="yearSelect" name="year">
                    <?php for($y = 2022; $y <= date('Y'); $y++): ?>
                        <option value="<?= $y ?>"><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <!-- Month Filter -->
            <div class="filter-section">
                <h4>Month</h4>
                <select id="monthSelect" name="month">
                    <?php for($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 10)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Filter Button -->
            <button type="button" style="border: none; background-color: #04AA6D; margin-top: 10px;" onclick="window.location.href='salesrpt.php';">Reset</button>
            <button type="submit" style="border: none; background-color: #04AA6D; float: right; margin-top: 10px;">Apply Filters</button>
        </form>
    </div>


    </div>


    <!-- footer area start-->


        <!--footer bottom area start-->
        <?php include('footer.php');?>
        <!--footer bottom area end-->

    
    <script>
        $(document).ready(function() {
            $('#yourDataTableID').DataTable();
        });
    </script>

<script>
// JavaScript variables
var labels = <?php echo json_encode($selectedYear && $selectedMonth ? $days : $monthss); ?>;
var data = <?php echo json_encode($selectedYear && $selectedMonth ? $dailyTotalCosts : $totalCosts); ?>;
var chartColors = <?php echo json_encode($revenueChartColors); ?>;

// Create the Total Revenue bar chart
var ctx = document.getElementById('revenueeChart').getContext('2d');
var revenueChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Revenue',
            data: data,
            backgroundColor: chartColors,
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


<script>
        $(document).ready(function() {
            $('#yourDataTableID').DataTable();
        });

        // Add an event listener to the button to toggle the table visibility
        document.getElementById('toggleTableButton').addEventListener('click', function() {
            var tableContainer = document.getElementById('tableContainer');
            tableContainer.style.display = (tableContainer.style.display === 'none') ? 'block' : 'none';
        });
    </script>

<script>
var days = <?php echo json_encode($days); ?>;
var dailyOrderCounts = <?php echo json_encode($dailyOrderCounts); ?>;
var months = <?php echo json_encode($months); ?>;
var orderCounts = <?php echo json_encode($orderCounts); ?>;
var salesChartColors = <?php echo json_encode($salesChartColors); ?>;

// Choose the dataset based on whether days or months data is available
var labels = days.length > 0 ? days : months;
var data = days.length > 0 ? dailyOrderCounts : orderCounts;

var ctx = document.getElementById('revenueChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Order Count',
            data: data,
            backgroundColor: salesChartColors,
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

<script>
    // Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById('myBtn');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>


</body>

</html>
