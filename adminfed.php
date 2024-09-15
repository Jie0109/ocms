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
    <!--breadcumb area start -->
    <div class="breadcumb-area overlay pos-rltv">
        <div class="bread-main">
            <div class="bred-hading text-center">
                <h5>Feedback</h5>
            </div>
            <ol class="breadcrumb">
                <li class="home"><a title="Go to Home Page" href="admin.php">Admin</a></li>
                <li class="active">Feedback</li>
            </ol>
        </div> 
    </div>
        <!--breadcumb area end -->
    <div id="main">
        <div class="stats">
            <?php
            // Generate random data for the chart
            $feedbackCountQuery = "SELECT COUNT(*) as feedbackCount FROM contact";
            $feedbackCountResult = mysqli_query($link, $feedbackCountQuery);
            $totalFeedbackCount = mysqli_fetch_assoc($feedbackCountResult)['feedbackCount'];

            $currentMonth = date('Y-m');
            $currentMonthCountQuery = "SELECT COUNT(*) as currentMonthCount FROM contact WHERE DATE_FORMAT(conDate, '%Y-%m') = '$currentMonth'";
            $currentMonthCountResult = mysqli_query($link, $currentMonthCountQuery);
            $currentMonthFeedbackCount = mysqli_fetch_assoc($currentMonthCountResult)['currentMonthCount'];
            ?>
            <div class="stat-box" style="width: 530px; height: auto;">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Count Feedback</h3>
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>

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
                <canvas id="myPieChart" width="400" height="200"></canvas>
            </div>
        </div>
        <button id="toggleTableButton" style="color: white; margin-bottom: 10px; border: none; margin-left: 1288px; padding: 5px; background-color: #04AA6D; width: 100px;">Reply</button>
        <div id="tableContainer" style="display: none;">
            <table id="yourDataTableID" class="display">
                <thead>
                    <tr style="background-color: #D6EEEE;">
                        <th>Feedback ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Content</th>
                        <th>Ticket</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    
                    $conlist = "SELECT * FROM contact";
                    $result = (mysqli_query($link, $conlist));
                    if(mysqli_num_rows($result)>0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo'
                                
                                    <tr>
                                        <td>'.$row['conID'].'</td>
                                        <td>'.$row['conName'].'</td>
                                        <td>'.$row['conEmail'].'</td>
                                        <td>'.$row['conPH'].'</td>
                                        <td><a href="adminfedd.php?conID='.$row['conID'].'"><i class="fa fa-ellipsis-h text-black-50"></i></a></td>
                                        <td>'.$row['reply'].'</td>
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

            document.getElementById('toggleTableButton').addEventListener('click', function() {
            var tableContainer = document.getElementById('tableContainer');
            tableContainer.style.display = (tableContainer.style.display === 'none') ? 'block' : 'none';
        });
        </script>

<script>
        // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

// Data for the chart
var data = {
    labels: ['Total Feedback', 'Current Month Feedback'],
    datasets: [{
        label: 'Feedback Count',
        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
        borderWidth: 1,
        data: [<?php echo $totalFeedbackCount; ?>, <?php echo $currentMonthFeedbackCount; ?>]
    }]
};

// Configuration options
var options = {
    scales: {
        y: {
            beginAtZero: true
        }
    }
};

// Create a bar chart
var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});
    </script>

<script>
    // Get the canvas element
    var ctx = document.getElementById('myPieChart').getContext('2d');

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

</body>
</html>
