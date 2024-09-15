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
    width: 500px;
    height: 300px;
    background-color: #fff;
    padding: 1em;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 0 10px;
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
                <li class="active">Orders</li>
            </ol>
        </div>
    </div>
        <!--breadcumb area end -->
    <div id="main">
        <div class="stats">
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
            <div class="stat-box">
                <?php
                    $statusOrderA = "SELECT COUNT(*) AS order_count FROM orders ";
                    $resultOrderA = mysqli_query($link, $statusOrderA);
                    $allorderA = mysqli_fetch_assoc($resultOrderA);
                ?>
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Orders Status (Total:<?=$allorderA['order_count'] ?>)</h3>
                <canvas id="myPieChart" style="width: 500px; height: 200px;"></canvas>
            </div>
            <?php
                $mCount = "SELECT 
                    COUNT(*) AS order_count,
                    methods
                FROM 
                    orders
                WHERE 
                    methods IN ('Cash On Delivery', 'Direct Bank Transfer')
                GROUP BY 
                    methods";
                
                $resultm = mysqli_query($link, $mCount);
                
                $labelss = [];
                $datas = [];
                
                while ($row = mysqli_fetch_assoc($resultm)) {
                    $labelss[] = $row['methods'];
                    $datas[] = $row['order_count'];
                }
            ?>
            <div class="stat-box">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Payment Methods</h3>
                <canvas id="myBarChart" style="width: 500px; height: 200px;"></canvas>
            </div>
        </div>

        <div class="stats">
            <div class="stat-box" style="width: 1260px; height: auto;">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Orders List</h3>
                <form method="get" action="">
                    <select id="status" name="status" style="width: 150px; float: right; cursor: pointer; background-color: #04AA6D; color: white; border-radius: 5px;" onchange="this.form.submit()">
                        <option style="color: black;" value="all" <?php echo (isset($_GET['status']) && $_GET['status'] === 'all') ? 'selected' : ''; ?>>All</option>
                        <option style="color: black;" value="threeo" <?php echo (isset($_GET['status']) && $_GET['status'] === 'threeo') ? 'selected' : ''; ?>>Last 30 Days</option>
                        <option style="color: black;" value="nineo" <?php echo (isset($_GET['status']) && $_GET['status'] === 'nineo') ? 'selected' : ''; ?>>Last 90 Days</option>
                        <option style="color: black;" value="halfmon" <?php echo (isset($_GET['status']) && $_GET['status'] === 'halfmon') ? 'selected' : ''; ?>>Last 180 Days</option>
                    </select>
                    <?php 

                        if (isset($_GET['status']) && $_GET['status'] == 'threeo')
                        {
                            $countThree0 = "SELECT COUNT(*) AS total_orders_count FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                            $RcountThree0 = mysqli_query($link, $countThree0);
                            $rowCountThreeO = mysqli_fetch_assoc($RcountThree0);

                            echo '<p style="float: left; font-size: 20px;">Total: '.$rowCountThreeO['total_orders_count'] .'</p><br/><br/>';

                            $threeo = "SELECT * FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                            $Rthreeo = mysqli_query($link, $threeo);
                            if(mysqli_num_rows($Rthreeo) > 0)
                            {
                                echo'
                                <table id="yourDataTableID" class="display">
                                    <thead>
                                        <tr style="background-color: #D6EEEE;">
                                            <th>Order ID</th>
                                            <th>Recipient Name</th>
                                            <th>Status</th>
                                            <th>Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';
                                while($rowT0 = mysqli_fetch_assoc($Rthreeo))
                                {
                                    echo'   <tr>
                                                <td><a href="adminOrderDetails.php?order_id='.$rowT0['order_id'].'" style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">'.$rowT0['order_id'].'</td>
                                                <td>'.$rowT0['recipient_name'].'</td>
                                                <td>'.$rowT0['status'].'</td>
                                                <td>'.$rowT0['created'].'</td>
                                            </tr>';
                                }
                            }
                        }
                        elseif(isset($_GET['status']) && $_GET['status'] == 'nineo')
                        {

                            $countNine0 = "SELECT COUNT(*) AS total_orders_count FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND created <= DATE_SUB(CURDATE(), INTERVAL 31 DAY)";
                            $RcountNine0 = mysqli_query($link, $countNine0);
                            $rowCountNine0 = mysqli_fetch_assoc($RcountNine0);
                            
                            echo '<p style="float: left; font-size: 20px;">Total: '.$rowCountNine0['total_orders_count'] .'</p><br/><br/>';

                            $nine0 = "SELECT * FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND created <= DATE_SUB(CURDATE(), INTERVAL 31 DAY)";
                            $Rnine0 = mysqli_query($link, $nine0);
                            if(mysqli_num_rows($Rnine0) > 0)
                            {
                                echo'
                                <table id="yourDataTableID" class="display">
                                    <thead>
                                        <tr style="background-color: #D6EEEE;">
                                            <th>Order ID</th>
                                            <th>Recipient Name</th>
                                            <th>Status</th>
                                            <th>Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';
                                while($rowN0 = mysqli_fetch_assoc($Rnine0))
                                {
                                    echo'   <tr>
                                                <td><a href="adminOrderDetails.php?order_id='.$rowN0['order_id'].'" style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">'.$rowN0['order_id'].'</td>
                                                <td>'.$rowN0['recipient_name'].'</td>
                                                <td>'.$rowN0['status'].'</td>
                                                <td>'.$rowN0['created'].'</td>
                                            </tr>';
                                }
                            }
                        }
                        elseif(isset($_GET['status']) && $_GET['status'] == 'halfmon')
                        {
                            $count180 = "SELECT COUNT(*) AS total_orders_count FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 180 DAY) AND created <= DATE_SUB(CURDATE(), INTERVAL 91 DAY)";
                            $Rcount180 = mysqli_query($link, $count180);
                            $rowCount180 = mysqli_fetch_assoc($Rcount180);
                            
                            echo '<p style="float: left; font-size: 20px;">Total: '.$rowCount180['total_orders_count'] .'</p><br/><br/>';
                        

                            $One80 = "SELECT * FROM orders WHERE created >= DATE_SUB(CURDATE(), INTERVAL 180 DAY) AND created <= DATE_SUB(CURDATE(), INTERVAL 91 DAY)";
                            $ROne80 = mysqli_query($link, $One80);
                            if(mysqli_num_rows($ROne80) > 0)
                            {
                                echo'
                                <table id="yourDataTableID" class="display">
                                    <thead>
                                        <tr style="background-color: #D6EEEE;">
                                            <th>Order ID</th>
                                            <th>Recipient Name</th>
                                            <th>Status</th>
                                            <th>Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';
                                while($rowO80 = mysqli_fetch_assoc($ROne80))
                                {
                                    echo'   <tr>
                                                <td><a href="adminOrderDetails.php?order_id='.$rowO80['order_id'].'" style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">'.$rowO80['order_id'].'</td>
                                                <td>'.$rowO80['recipient_name'].'</td>
                                                <td>'.$rowO80['status'].'</td>
                                                <td>'.$rowO80['created'].'</td>
                                            </tr>';
                                }
                            }
                        }
                        else
                        {
                            $statusOrder = "SELECT COUNT(*) AS order_count FROM orders ";
                            $resultOrder = mysqli_query($link, $statusOrder);
                            $allorder = mysqli_fetch_assoc($resultOrder);
                            
                            echo '<p style="float: left; font-size: 20px;">Total: '.$allorder['order_count'] .'</p><br/><br/>';

                            $allOrder = "SELECT * FROM orders";
                            $rowOrders = mysqli_query($link, $allOrder);

                            if(mysqli_num_rows($rowOrders) > 0) 
                            {
                                echo'
                                <table id="yourDataTableID" class="display">
                                    <thead>
                                        <tr style="background-color: #D6EEEE;">
                                            <th>Order ID</th>
                                            <th>Recipient Name</th>
                                            <th>Status</th>
                                            <th>Purchased</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                ';
                                while($rowOrder = mysqli_fetch_assoc($rowOrders)) {
                                    echo'   <tr>
                                    <td><a href="adminOrderDetails.php?order_id='.$rowOrder['order_id'].'" style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">'.$rowOrder['order_id'].'</td>
                                    <td>'.$rowOrder['recipient_name'].'</td>
                                    <td>'.$rowOrder['status'].'</td>
                                    <td>'.$rowOrder['created'].'</td>
                                </tr>';
                                }
                            }
                        }
                    ?>
                </form><br><br>
               
            </div>
        </div>
    </div>

    <!-- footer area start-->
    <!--footer area start-->

    <script>
    $(document).ready(function() {
            $('#yourDataTableID').DataTable();
        });
</script>



<script>
    function changeColor(element) {
        element.style.color = "red";
    }

    function restoreColor(element) {
        element.style.color = "black";
    }


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
    var ctx = document.getElementById('myPieChart').getContext('2d');

    // Create a pie chart
    var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: chartData,
    options: {
        title: {
            display: true,
            text: 'Distribution of Order Status'
        },
        aspectRatio: 2
    }
    });

    // Set legend position to left
    myPieChart.legend.options.position = 'left';
    myPieChart.update();
</script>

<script>
    var ctx = document.getElementById('myBarChart').getContext('2d');

var chartData = {
    labels: <?php echo json_encode($labelss); ?>,
    datasets: [
        {
            label: 'Methods Used',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
            data: <?php echo json_encode($datas); ?>,
        },
    ],
};

var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});
</script>

</body>
</html>
