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
                    <h5>User Lists</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                    <li class="active">User Lists</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

    <div id="main">
        <div class="stats">
            <?php
                $userCount = "SELECT
                COUNT(id) AS total_users,
                SUM(CASE WHEN verify = 'yes' THEN 1 ELSE 0 END) AS verified_users,
                SUM(CASE WHEN verify IS NULL THEN 1 ELSE 0 END) AS unverified_users,
                SUM(CASE WHEN registrationDate >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS new_users
            FROM
                user
            WHERE
                mode = 'cust'
                ";
                $resultC = mysqli_query($link, $userCount);
                $row = mysqli_fetch_assoc($resultC);

                $dataPoints = array(
                    "Total User" => $row['total_users'],
                    "New User(1 weeks)" => $row['new_users'],
                    "Verified User" => $row['verified_users'],
                    "Unverified User" => $row['unverified_users'],
                );
            ?>
            <div class="stat-box" style="width: 530px; height: 300px;">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Total User</h3>
                <canvas id="myPieChart" style="width: 500px; height: 200px;"></canvas>
            </div>
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
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Recent Active Users</h3>
                <canvas id="userChart" width="400" height="200"></canvas>
            </div>
        </div>
        <button id="toggleTableButton" style="color: white; margin-bottom: 10px; border: none; margin-left: 1288px; padding: 5px; background-color: #04AA6D;">Show User Table</button>
        <div id="tableContainer" style="display: none;">
            <table id="yourDataTableID" class="display">
                <thead>
                    <tr style="background-color: #D6EEEE;">
                        <th>User ID</th>
                        <th>E-mail</th>
                        <th>User Name</th>
                        <th>Registration Date</th>
                        <th>Verified</th>
                        <th>Last Online</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $userlist = "SELECT * FROM user WHERE mode = 'cust'";
                        $result = mysqli_query($link, $userlist);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                                    <tr>
                                        <td>' . $row['id'] . '</td>
                                        <td>' . $row['email'] . '</td>
                                        <td>' . $row['uname'] . '</td>
                                        <td>' . $row['registrationDate'] . '</td>
                                        <td>' . $row['verify'] . '</td>
                                        <td>' . $row['lastLogin'] . '</td>
                                    </tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Add more content and features as needed --> 
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
