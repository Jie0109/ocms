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
                <h5>Product Lists</h5>
            </div>
            <ol class="breadcrumb">
                <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                <li class="active">Product Lists</li>
            </ol>
        </div> 
    </div>
        <!--breadcumb area end -->
    <div id="main">
        <div class="stats">
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
            <div class="stat-box">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Details</h3>
                <canvas id="myPieChart" style="width: 500px; height: 200px;"></canvas>
            </div>
            <?php
                $best = "SELECT item, cSold
                FROM product
                WHERE cSold > 0 AND brand_id != 800000003
                ORDER BY cSold DESC
                LIMIT 5";
      
                $resultb = mysqli_query($link, $best);
                
                $bests = array();
                while ($row = mysqli_fetch_assoc($resultb)) {
                    $bests[] = $row;
                }

                // Prepare data for Chart.js
                $productNames = array_column($bests, 'item');
                $salesCounts = array_column($bests, 'cSold');

                // Convert data to JSON for JavaScript
                $jsonProductNames = json_encode($productNames);
                $jsonSalesCounts = json_encode($salesCounts);
            ?>
            <div class="stat-box">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Best Selling Product</h3>
                <canvas id="bestSellingChart" style="width: 500px; height: 200px;"></canvas>
            </div>
            <?php
                $query = "SELECT b.brand_name, COUNT(p.brand_id) AS total_products 
                FROM brand b 
                LEFT JOIN product p ON b.brand_id = p.brand_id 
                WHERE b.brand_name != 'Custom'
                GROUP BY b.brand_id";
      
                $result = mysqli_query($link, $query);
                
                $brandNames = array();
                $brandCounts = array();
                
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $brandNames[] = $row['brand_name'];
                        $brandCounts[] = $row['total_products'];
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($link);
                }
                
                // Convert arrays to JSON format
                $jsonBrandNames = json_encode($brandNames);
                $jsonBrandCounts = json_encode($brandCounts);
            ?>
            <div class="stat-box">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Product Quantity</h3>
                <canvas id="userChart" style="width: 500px; height: 200px;"></canvas>
            </div>
        </div>
        <button id="toggleTableButton" style="color: white; margin-bottom: 10px; border: none; margin-left: 1288px; padding: 5px; background-color: #04AA6D;">Show Product Table</button>
        <div id="tableContainer" style="display: none;">
            <table id="yourDataTableID" class="display">
                <thead>
                    <tr style="background-color: #D6EEEE;">
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Price</th>
                        <th>Quantity Sold</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    
                    $itemlist = "SELECT * FROM product WHERE userID IS NULL";
                    $result = (mysqli_query($link, $itemlist));
                    if(mysqli_num_rows($result)>0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            if($row['active'] == NULL)
                            {
                                $status = "Published";
                            }
                            else
                            {
                                $status = "Archived";
                            }
                            echo'
                                
                                    <tr>
                                        <td>'.$row['item_id'].'</td>
                                        <td>'.$row['item'].'</td>
                                        <td>RM '.$row['cost'].'</td>
                                        <td>'.$row['cSold'].'</td>
                                        <td>'.$status.'</td>
                                    </tr>
                                ';
                        }
                    }
                ?>
                </tbody>
                
            </table>
        </div>
        <!-- Add more content and features as needed -->
    </div>

    <!-- footer area start-->
    
    <!--footer area start-->

        <!--footer bottom area start-->
        <?php include('footer.php');?>
        <!--footer bottom area end-->

        <script>
        $(document).ready(function() {
            $('#yourDataTableID').DataTable();
        });
    </script>
<script>
    // Get the data from PHP
    var dataPoints = <?php echo json_encode($dataPoints); ?>;

    // Create a new Chart instance for the pie chart
    var ctx = document.getElementById('myPieChart').getContext('2d');
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
  var brandNames = <?php echo $jsonBrandNames; ?>;
    var brandCounts = <?php echo $jsonBrandCounts; ?>;

    // Function to generate random colors
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Generate random colors for each brand
    var brandColors = brandNames.map(function () {
        return getRandomColor();
    });

    // Create the Doughnut Chart
    var ctxCombined = document.getElementById('userChart').getContext('2d');
    var myCombinedChart = new Chart(ctxCombined, {
        type: 'doughnut',
        data: {
            labels: brandNames,
            datasets: [
                {
                    data: brandCounts,
                    backgroundColor: brandColors,
                    hoverBackgroundColor: brandColors
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '50%', // Adjust the size of the hole in the center
            legend: {
                display: true,
                position: 'right' // Adjust the legend position
            },
            layout: {
            padding: {
                left: 50,
                right: 50,
                bottom: 50
            }
        },
        }
    });
</script>

<script>
     var productNames = <?php echo $jsonProductNames; ?>;
    var salesCounts = <?php echo $jsonSalesCounts; ?>;

    // Create the Best Selling Products Bar Chart
    var ctx = document.getElementById('bestSellingChart').getContext('2d');
    var bestSellingChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Sales Count',
                data: salesCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Adjust the color as needed
                borderColor: 'orange', // Adjust the border color as needed
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            legend: {
                display: false // Hide the legend if not needed
            }
        }
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

</body>
</html>
