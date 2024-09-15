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
    
    if(isset($_GET['receive']))
    {
        $ooid = $_GET['order_id'];
        $sql = "UPDATE orders SET status = 'Completed' WHERE order_id = ".$_GET['order_id'];
        if(mysqli_query($link, $sql))
        {
            echo "
                <script>
                Swal.fire({
                    title: 'Updated',
                    text: 'Thank you for shopping with us ! ',
                    icon: 'success'
                }).then(function() {
                    location.href = 'my-orderDetails.php?order_id=$ooid'
                })
                </script>";
        }

    }
                                                                   
?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Assistant');
body {
  background: #eee;
  font-family: Assistant, sans-serif;
}

.cell-1 {
  border-collapse: separate;
  border-spacing: 0 4em;
  background: #fff;
  border-bottom: 5px solid transparent;
  /*background-color: gold;*/
  background-clip: padding-box;
}

thead {
  background: #dddcdc;
}

@import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
body
{background-color: #eeeeee;font-family: 'Open Sans',serif}
</style>


        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>My Account</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Account</li>
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
                                <li><a class="" href="my-account.php">Personal Info</a></li>
                                <li><a class="" href="my-design.php">Customization</a></li>
                                <li><a class="" href="my-password.php">Password</a></li>
                                <li><a class="active" href="my-order.php">My Order</a></li>
                                <li><a class="" href="paymentmethod.php">Payment Method</a></li>
                                <li role=""><a href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="rounded">
                            <div class="table-responsive table-borderless">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Recipient name</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Created</th>
                                            <th>Confirmation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body">
                                    <?php
                                    
                                        $sql = "SELECT * FROM orders WHERE UID = ".$_SESSION['id'];
                                        $result = mysqli_query($link, $sql);
                                        if(mysqli_num_rows($result)>0)
                                        {
                                            while($row = mysqli_fetch_assoc($result))
                                            {
                                                echo '                                                
                                                    <tr class="cell-1">     
                                                        <td><a href="my-orderDetails.php?order_id='.$row['order_id'].'" style="color: black;" onmouseover="changeColor(this)" onmouseout="restoreColor(this)">'.$row['order_id'].'</td>
                                                        <td>'.$row['recipient_name'].'</td>
                                                        <td>'.$row['status'].'</td>
                                                        <td>RM '.$row['total'].'</td>
                                                        <td>'.$row['created'].'</td>';

                                                    if ($row['status'] != 'Completed') {
                                                        echo '<td><button type="submit" style="color: black; background-color: #F6AF44;" onclick="receiveOrder('.$row['order_id'].')">Order Received</button></td>';
                                                    } else {
                                                        echo '<td><i class="fa fa-ellipsis-h text-black-50"></i></td>';
                                                    }

                                                    echo '</tr>';

                                            }
                                        }
                                        else
                                        {
                                            echo "
                                            <script>
                                            Swal.fire({
                                                title: 'No order found',
                                                text: 'Currently do not have any orders for you.',
                                                icon: 'question'
                                            }).then(function() {
                                            location.href = 'shop.php'
                                            })</script>";
                                        }
                                        

                                    ?>
                                    </tbody>
                                </table>
                                <div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content" style="margin-top: 100px;">
                                                <!-- Add image inside the body of modal -->
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <article class="card">
                                                            <header class="card-header"> My Orders / Tracking </header>
                                                            <div class="card-body">
                                                                <h6>Order ID: OD45345345435</h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> <strong>Recipient:</strong> <br>'.$row['recipient_name'].'</div>
                                                                        <div class="col"> <strong>Shipping BY:</strong> <br> BLUEDART, | <i class="fa fa-phone"></i> +1598675986 </div>
                                                                        <div class="col"> <strong>Status:</strong> <br> Picked by the courier </div>
                                                                        <div class="col"> <strong>Tracking #:</strong> <br> BD045903594059 </div>
                                                                    </div>
                                                                </article>                                           
                                                                <div class="track">
                                                                    <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order confirmed</span> </div>
                                                                    <div class="step active"> <span class="icon"> <i class="fa fa-user"></i> </span> <span class="text"> Picked by courier</span> </div>
                                                                    <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                                                    <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Ready for pickup</span> </div>
                                                                </div>
                                                                <hr>
                                                                <ul class="row">
                                                                    <li class="col-md-4">
                                                                        <figure class="itemside mb-3">
                                                                            <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border"></div>
                                                                            <figcaption class="info align-self-center">
                                                                                <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$950 </span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </li>
                                                                    <li class="col-md-4">
                                                                        <figure class="itemside mb-3">
                                                                            <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border"></div>
                                                                            <figcaption class="info align-self-center">
                                                                                <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$850 </span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </li>
                                                                    <li class="col-md-4">
                                                                        <figure class="itemside mb-3">
                                                                            <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border"></div>
                                                                            <figcaption class="info align-self-center">
                                                                                <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$650 </span>
                                                                            </figcaption>
                                                                        </figure>
                                                                    </li>
                                                                </ul>
                                                                <hr>
                                                            </div>
                                                        </article>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" style="border-radius: 5px;" class="btn btn-danger" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--service idea area are end -->

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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
     </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous">
     </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous">
     </script>
     <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready( function () {
    $('#myTable').DataTable({
        scrollCollapse: true,
        scrollY: '450px',
        searching: false,
        paging: false,
        ordering: false,
        info: false
    });
  });
</script>

<script>
    function changeColor(element) {
        element.style.color = "red";
    }

    function restoreColor(element) {
        element.style.color = "black";
    }
</script>
 
<script>
    function receiveOrder(id) {
        Swal.fire({
            title: 'Order received ?',
            text: 'Please be advised that this action is irreversible.',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.href = "my-order.php?receive&order_id="+id
            }
        });
    }
</script>

</body>

</html>