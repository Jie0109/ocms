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
.log-container 
{
    max-width: 600px;
    margin: 0 auto;
    height: 500px;
    padding: 20px;
    border: 1px solid #ddd;
    overflow-y: auto;
}

.log-entry {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
    padding: 10px;
    margin-bottom: 10px;
}

.timestamp {
    color: #black;
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
                    <li class="active">Activity Log</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

    <div id="main">
        <div class="stats">
            <div class="stat-box" style="width: 600px; height: auto;">
                <h3 style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">Activity Log</h3>
                <div class="log-container">
                    <?php
                        $log = "SELECT * FROM userlogs INNER JOIN user ON userlogs.userid = user.id";
                        $result = mysqli_query($link, $log);
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo'
                                <div class="log-entry">
                                <div>'.$row['uname'].'('.$row['id'].') '.$row['activity'].'</div>
                                <div class="timestamp">'.$row['times'].'</div>
                                </div>';
                            }
                        }
                    ?>
                    <!-- Repeat log entries as needed -->
                </div>
            </div>
        </div>  
        <!-- Add more content and features as needed --> 
    </div>

    <!-- footer area start-->


        <!--footer bottom area start-->
        <?php include('footer.php');?>
        <!--footer bottom area end-->

</body>

</html>
