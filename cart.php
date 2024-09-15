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
 
    if (isset($_POST['updates'])) 
    {
        $qty = $_POST['qtybutton'];
        $cartID = $_POST['updates'];

        //$cart = "SELECT * FROM cart WHERE uid = ".$_SESSION['id'];
        //$cResult = mysqli_query($link, $cart);
        //$cRow = mysqli_fetch_assoc($cResult);

        if($qty < 1)
        {
            echo "
                    <script>
                        Swal.fire({
                            title: 'Oops',
                            text: 'Your quantity cannot be zero.',
                            icon: 'error'
                        }).then(function() {
                        location.href = 'cart.php'
                        })
                    </script>  
                    ";
        }
        else
        {
            $SQL = "UPDATE cart SET quantity = $qty WHERE cart_id = $cartID";
            if (mysqli_query($link, $SQL)) {
                echo "
                    <script>
                        Swal.fire({
                            title: 'Successful',
                            text: 'Your quantity have updated.',
                            icon: 'success'
                        }).then(function() {
                        location.href = 'cart.php'
                        })
                    </script>  
                    ";
            }
        }

        
            
         
        
        
    }

    if (isset($_GET['remove'])) 
    {
        $removeID = $_GET['remove'];
        //echo $removeID;

        $sql = "DELETE FROM cart where cart_id = $removeID";
        if (mysqli_query($link, $sql)) {
            echo "
                <script>
                    Swal.fire({
                        title: 'Successful',
                        text: 'Your product have been removed.',
                        icon: 'success'
                    }).then(function() {
                    location.href = 'cart.php'
                    })
                </script>  
                ";
        }

        
        
    }
?>

        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Cart Details</h5>
                </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.html">Home</a></li>
                    <li class="active">Cart</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->

        <!--cart-checkout-area start -->
        <div class="cart-checkout-area  pt-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-area">
                            <!--<div class="title-tab-product-category row">
                                <div class="col-lg-12 text-center pb-60">
                                    <ul class="nav heading-style-3" role="tablist">
                                        <li role="presentation"><a class="active shadow-box" href="#cart"
                                                aria-controls="cart" role="tab" data-bs-toggle="tab"><span>01</span>
                                                Shopping
                                                cart</a></li>
                                        <li role="presentation"><a class="shadow-box" href="#checkout"
                                                aria-controls="checkout" role="tab"
                                                data-bs-toggle="tab"><span>02</span>Checkout</a></li>
                                        <li role="presentation"><a class="shadow-box" href="#complete-order"
                                                aria-controls="complete-order" role="tab"
                                                data-bs-toggle="tab"><span>03</span>
                                                complete-order</a></li>
                                    </ul>
                                </div>
                            </div>-->
                            <div class="clearfix"></div>
                            <div class="content-tab-product-category pb-70">
                                <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade show active" id="cart">
                                            <!-- cart are start-->
                                            <div class="cart-page-area">
                                                <div class="table-responsive mb-20">
                                                    <table class="shop_table-2 cart table">
                                                        <?php 
                                                            $sql = "SELECT * FROM cart INNER JOIN product ON cart.item = product.item_id WHERE paid = 'no' AND uid = ".$_SESSION["id"];
                                                            $result = mysqli_query($link, $sql);   
                                                            if(mysqli_num_rows($result)>0)
                                                            {
                                                                $empty_cart = false;
                                                                $subTotal = 0.00;
                                                                $totalPrice = 0.00;
                                                                echo'<thead>
                                                                        <tr>
                                                                            <th class="product-thumbnail ">Image</th>
                                                                            <th class="product-name ">Product Name</th>
                                                                            <th class="product-price ">Size</th>
                                                                            <th class="product-price ">Price (RM)</th>
                                                                            <th class="product-quantity">Quantity</th>
                                                                            <th class="product-subtotal ">Total (RM)</th>
                                                                            <th class="product-update">Update</th>
                                                                            <th class="product-remove">Remove</th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>';
                                                                while($row = mysqli_fetch_assoc($result))
                                                                {
                                                                    $totalPrice = $row['quantity'] * $row['cost'];
                                                                    $subTotal += $totalPrice;
                                                                
                                                                    echo'  
                                                                    <tr class="cart_item">
                                                                    <td class="item-img"><a href="single-product.php?item_id='.$row['item_id'].'"><img src="images/product/'.$row['images'].'" alt=""></a> </td>
                                                                    <td class="item-title"><a href="single-product.php?item_id='.$row['item_id'].'">'. $row['item'].'</a></td>
                                                                    <td class="item-price">'.$row['size'].' </td>
                                                                    <td class="item-price">'.$row['cost'].' </td>
                                                                    <form action="" method="POST">
                                                                    <td class="item-qty">
                                                                        <div class="cart-quantity product_data">
                                                                            <div class="product-qty">
                                                                                <div class="cart-quantity"> 
                                                                                    <div class="cart-plus-minus">
                                                                                        <div class="dec qtybutton updateQty">-</div>
                                                                                        <input value="'.$row['quantity'].'" name="qtybutton" class="cart-plus-minus-box input-qty" type="text" readonly>
                                                                                        <div class="inc qtybutton updateQty">+</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="total-price"><strong>'. $totalPrice .'</strong></td>
                                                                    <td class="update-item"><input type="hidden" name="updates" value="'.$row['cart_id'].'"><button style="color: black; background-color: transparent; border-color: white; padding: 4px 10px; border-radius: 2px;" type="submit" data-tooltip="Update" class="update-action" data-placement="right">
                                                                    <i class="fa fa-refresh"></i>
                                                                    </button></td>
                                                                    </form>
                                                                    <form action="" method="POST">
                                                                    <td class="remove-item"><a href="cart.php?remove='.$row['cart_id'].'"<button style="color: black; background-color: transparent; border-color: white; padding: 4px 10px; border-radius: 2px;" type="submit" data-tooltip="Delete" class="delete-action" data-placement="right">
                                                                    <i class="fa fa-trash"></i><a/>
                                                                    </form>
                                                                    </button></td>
                                                                    
                                                                    </tr>';
                                                                }
                                                                echo'</tbody>';
                                                            }
                                                            else
                                                            {
                                                                $empty_cart = true;
                                                                echo "
                                                                <script>
                                                                Swal.fire({
                                                                    title: 'No product in your cart',
                                                                    text: 'Add some product into cart to view it now.',
                                                                    icon: 'question'
                                                                }).then(function() {
                                                                location.href = 'shop.php'
                                                                })</script>";
                                                            }
                                                        ?>
                                                    </table>
                                                </div>
                                                <div class="cart-bottom-area">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-7">
                                                            <div class="update-coupne-area">
                                                                <div class="update-continue-btn text-end pb-20">
                                                                    <a href="shop.php" class="btn-def btn2">Continue
                                                                        Shopping</a>
                                                                </div>
                                                                <div class="coupn-area">
                                                                    <div class="catagory-title cat-tit-5 mb-20">
                                                                        <h3>Coupon</h3>
                                                                        <p>Enter your coupon code if you have one.
                                                                        </p>
                                                                    </div>
                                                                    <div class="input-box input-box-2 mb-20">
                                                                        <input type="text" placeholder="Coupn"
                                                                            class="info" name="subject">
                                                                    </div>
                                                                    <a href="#" class="btn-def btn2">Apply Coupn</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-5">
                                                            <div class="cart-total-area">
                                                                <div
                                                                    class="catagory-title cat-tit-5 mb-20 text-end">
                                                                    <h3>Cart Totals</h3>
                                                                </div>
                                                                <div class="sub-shipping">
                                                                    <p>Subtotal <span><?php 
                                                                                            if($empty_cart)
                                                                                            {
                                                                                                $subTotal = 0.00;
                                                                                            } 
                                                                                            else 
                                                                                            {
                                                                                                $subTotal;
                                                                                            }
                                                                                                echo 'RM '.$subTotal; 
                                                                                        ?></span></p>
                                                                    <p>Shipping <span>
                                                                    <?php 
                                                                        $shipping = 0.00; 
                                                                    
                                                                        if($empty_cart) 
                                                                        {
                                                                            $shipping = 0.00;
                                                                        } 
                                                                        else if($subTotal <= 299) 
                                                                        {
                                                                            $shipping = 5.00;
                                                                        }
                                                                        else if($subTotal >= 300)
                                                                        {
                                                                            $shipping = 0.00;
                                                                        }

                                                                        echo 'RM '.$shipping;
                                                                        ?>
                                                                    </span></p>
                                                                </div>
                                                                <!--<div class="shipping-method text-end">
                                                                    <div class="shipp">
                                                                        <input type="radio" name="ship"
                                                                            id="pay-toggle1">
                                                                        <label for="pay-toggle1">Flat Rate</label>
                                                                    </div>
                                                                    <div class="shipp">
                                                                        <input type="radio" name="ship"
                                                                            id="pay-toggle3">
                                                                        <label for="pay-toggle3">Direct Bank
                                                                            Transfer</label>
                                                                    </div>
                                                                    <p><a href="#">Calculate Shipping</a></p>
                                                                </div>-->
                                                                <div class="process-cart-total">
                                                                    <p>Total <span><?php $TOTAL = 0.00; $TOTAL = $subTotal + $shipping; echo 'RM '.$TOTAL; ?></span></p>
                                                                </div>
                                                                <div class="process-checkout-btn text-end" style="margin-top: 37px;">
                                                                    <a class="btn-def btn2" href="complete-order.php">Proceed To
                                                                        Checkout</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- cart are end-->
                                        </div>
                                        <div role="tabpanel" class="tab-pane  fade in " id="checkout">
                                            <!-- Checkout are start-->
                                            <div class="checkout-area">
                                                <div class="">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="coupne-customer-area mb50">
                                                                <!--<div class="panel-group" id="accordion" role="tablist"
                                                                    aria-multiselectable="true">
                                                                    <div class="panel panel-checkout">
                                                                        <div class="panel-heading" role="tab"
                                                                            id="headingTwo">
                                                                            <h4 class="panel-title">
                                                                                <img src="images/icons/acc.jpg" alt="">
                                                                                Returning customer?
                                                                                <a class="collapsed" role="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-parent="#accordion"
                                                                                    href="#collapseTwo"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseTwo">
                                                                                    Click here to login
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapseTwo"
                                                                            class="panel-collapse collapse"
                                                                            role="tabpanel"
                                                                            aria-labelledby="headingTwo">
                                                                            <div class="panel-body">
                                                                                <div class="sm-des pb20">
                                                                                    If you have shopped with us before,
                                                                                    please enter your details in the
                                                                                    boxes
                                                                                    below. If you are a new customer
                                                                                    please
                                                                                    proceed to the Billing & Shipping
                                                                                    section.
                                                                                </div>
                                                                                <div class="first-last-area">
                                                                                    <div class="input-box mtb-20">
                                                                                        <label>User Name Or
                                                                                            Email</label>
                                                                                        <input type="email"
                                                                                            placeholder="Your Email"
                                                                                            class="info" name="email">
                                                                                    </div>
                                                                                    <div class="input-box mb-20">
                                                                                        <label>Password</label>
                                                                                        <input type="password"
                                                                                            placeholder="Password"
                                                                                            class="info" name="padd">
                                                                                    </div>
                                                                                    <div class="frm-action cc-area">
                                                                                        <div class="input-box tci-box">
                                                                                            <a href="#"
                                                                                                class="btn-def btn2">Login</a>
                                                                                        </div>
                                                                                        <span>
                                                                                            <input type="checkbox"
                                                                                                class="remr"> Remember
                                                                                            me
                                                                                        </span>
                                                                                        <a class="forgotten forg"
                                                                                            href="#">Forgotten
                                                                                            Password</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel panel-checkout">
                                                                        <div class="panel-heading" role="tab"
                                                                            id="headingThree">
                                                                            <h4 class="panel-title">
                                                                                <img src="images/icons/acc.jpg" alt="">
                                                                                Have A Coupon?
                                                                                <a class="collapsed" role="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-parent="#accordion"
                                                                                    href="#collapseThree"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseThree">
                                                                                    Click here to enter your code
                                                                                </a>
                                                                            </h4>
                                                                        </div>
                                                                        <div id="collapseThree"
                                                                            class="panel-collapse collapse"
                                                                            role="tabpanel"
                                                                            aria-labelledby="headingThree">
                                                                            <div class="panel-body coupon-body">

                                                                                <div class="first-last-area">
                                                                                    <div class="input-box mtb-20">
                                                                                        <input type="text"
                                                                                            placeholder="Coupon Code"
                                                                                            class="info" name="code">
                                                                                    </div>
                                                                                    <div class="frm-action">
                                                                                        <div class="input-box tci-box">
                                                                                            <a href="#"
                                                                                                class="btn-def btn2">Apply
                                                                                                Coupon</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="billing-details">
                                                                        <div class="contact-text right-side">
                                                                            <h2>Shipping Details</h2>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Your Name
                                                                                                <em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="namm" class="info"
                                                                                                placeholder="First Name">
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--<div class="col-lg-6 col-md-6">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Last
                                                                                                Name<em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="namm" class="info"
                                                                                                placeholder="Last Name">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Company Name</label>
                                                                                            <input type="text"
                                                                                                name="cpany"
                                                                                                class="info"
                                                                                                placeholder="Company Name">
                                                                                        </div>
                                                                                    </div>-->

                                                                                    <div class="col-md-6">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Email
                                                                                                Address<em>*</em></label>
                                                                                            <input type="email"
                                                                                                name="email"
                                                                                                class="info"
                                                                                                placeholder="Your Email">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Phone
                                                                                                Number<em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="phone"
                                                                                                class="info"
                                                                                                placeholder="Phone Number">
                                                                                        </div>
                                                                                    </div>

                                                                                    <!--<div class="col-lg-12">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Country
                                                                                                <em>*</em></label>
                                                                                            <select
                                                                                                class="selectpicker select-custom"
                                                                                                data-live-search="true">
                                                                                                <option
                                                                                                    data-tokens="Bangladesh">
                                                                                                    Bangladesh</option>
                                                                                                <option
                                                                                                    data-tokens="India">
                                                                                                    India</option>
                                                                                                <option
                                                                                                    data-tokens="Pakistan">
                                                                                                    Pakistan</option>
                                                                                                <option
                                                                                                    data-tokens="Pakistan">
                                                                                                    Pakistan</option>
                                                                                                <option
                                                                                                    data-tokens="Srilanka">
                                                                                                    Srilanka</option>
                                                                                                <option
                                                                                                    data-tokens="Nepal">
                                                                                                    Nepal</option>
                                                                                                <option
                                                                                                    data-tokens="Butan">
                                                                                                    Butan</option>
                                                                                                <option
                                                                                                    data-tokens="USA">
                                                                                                    USA</option>
                                                                                                <option
                                                                                                    data-tokens="England">
                                                                                                    England</option>
                                                                                                <option
                                                                                                    data-tokens="Brazil">
                                                                                                    Brazil</option>
                                                                                                <option
                                                                                                    data-tokens="Canada">
                                                                                                    Canada</option>
                                                                                                <option
                                                                                                    data-tokens="China">
                                                                                                    China</option>
                                                                                                <option
                                                                                                    data-tokens="Koeria">
                                                                                                    Koeria</option>
                                                                                                <option
                                                                                                    data-tokens="Soudi">
                                                                                                    Soudi Arabia
                                                                                                </option>
                                                                                                <option
                                                                                                    data-tokens="Spain">
                                                                                                    Spain</option>
                                                                                                <option
                                                                                                    data-tokens="France">
                                                                                                    France</option>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>-->

                                                                                    <div class="col-lg-12">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Address
                                                                                                <em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="add1"
                                                                                                class="info mb-10"
                                                                                                placeholder="Street Address">
                                                                                            <input type="text"
                                                                                                name="add2"
                                                                                                class="info mt10"
                                                                                                placeholder="Apartment, suite, unit etc. (optional)">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12">
                                                                                        <div class="input-box mb-20">
                                                                                            <label>Town/City
                                                                                                <em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="add1" class="info"
                                                                                                placeholder="Town/City">
                                                                                        </div>
                                                                                    </div>

                                                                                    <!--<div class="col-md-6">
                                                                                        <div class="input-box">
                                                                                            <label>State/Divison
                                                                                                <em>*</em></label>
                                                                                            <select
                                                                                                class="selectpicker select-custom"
                                                                                                data-live-search="true">
                                                                                                <option
                                                                                                    data-tokens="Barisal">
                                                                                                    Barisal</option>
                                                                                                <option
                                                                                                    data-tokens="Dhaka">
                                                                                                    Dhaka</option>
                                                                                                <option
                                                                                                    data-tokens="Kulna">
                                                                                                    Kulna</option>
                                                                                                <option
                                                                                                    data-tokens="Rajshahi">
                                                                                                    Rajshahi</option>
                                                                                                <option
                                                                                                    data-tokens="Sylet">
                                                                                                    Sylet</option>
                                                                                                <option
                                                                                                    data-tokens="Chittagong">
                                                                                                    Chittagong</option>
                                                                                                <option
                                                                                                    data-tokens="Rangpur">
                                                                                                    Rangpur</option>
                                                                                                <option
                                                                                                    data-tokens="Maymanshing">
                                                                                                    Maymanshing</option>
                                                                                                <option
                                                                                                    data-tokens="Cox">
                                                                                                    Cox's Bazar</option>
                                                                                                <option
                                                                                                    data-tokens="Saint">
                                                                                                    Saint Martin
                                                                                                </option>
                                                                                                <option
                                                                                                    data-tokens="Kuakata">
                                                                                                    Kuakata</option>
                                                                                                <option
                                                                                                    data-tokens="Sajeq">
                                                                                                    Sajeq</option>
                                                                                            </select>

                                                                                        </div>
                                                                                    </div>-->
                                                                                    <div class="col-md-6">
                                                                                        <div class="input-box">
                                                                                            <label>Post Code/Zip
                                                                                                Code<em>*</em></label>
                                                                                            <input type="text"
                                                                                                name="zipcode"
                                                                                                class="info"
                                                                                                placeholder="Zip Code">
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--<div class="col-lg-12">
                                                                                        <div
                                                                                            class="create-acc clearfix mtb-20">
                                                                                            <div class="acc-toggle">
                                                                                                <input type="checkbox"
                                                                                                    id="acc-toggle">
                                                                                                <label
                                                                                                    for="acc-toggle">Create
                                                                                                    an Account ?</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="create-acc-body">
                                                                                                <div class="sm-des">
                                                                                                    Create an account by
                                                                                                    entering the
                                                                                                    information
                                                                                                    below. If you are a
                                                                                                    returning customer
                                                                                                    please login at the
                                                                                                    top
                                                                                                    of the page.
                                                                                                </div>
                                                                                                <div class="input-box">
                                                                                                    <label>Account
                                                                                                        password
                                                                                                        <em>*</em></label>
                                                                                                    <input
                                                                                                        type="password"
                                                                                                        name="pass"
                                                                                                        class="info"
                                                                                                        placeholder="Password">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>-->

                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="col-lg-6">
                                                                    <div class="billing-details">
                                                                        <div class="right-side">
                                                                            <div class="ship-acc clearfix">
                                                                                <div class="ship-toggle pb20">
                                                                                    <input type="checkbox"
                                                                                        id="ship-toggle">
                                                                                    <label for="ship-toggle">Ship to a
                                                                                        different address?</label>
                                                                                </div>
                                                                                <div class="ship-acc-body">
                                                                                    <form action="#">
                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>First Name
                                                                                                        <em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="namm"
                                                                                                        class="info"
                                                                                                        placeholder="First Name">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Last
                                                                                                        Name<em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="namm"
                                                                                                        class="info"
                                                                                                        placeholder="Last Name">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Company
                                                                                                        Name</label>
                                                                                                    <input type="text"
                                                                                                        name="cpany"
                                                                                                        class="info"
                                                                                                        placeholder="Company Name">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Email
                                                                                                        Address<em>*</em></label>
                                                                                                    <input type="email"
                                                                                                        name="email"
                                                                                                        class="info"
                                                                                                        placeholder="Your Email">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Phone
                                                                                                        Number<em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="phone"
                                                                                                        class="info"
                                                                                                        placeholder="Phone Number">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Country
                                                                                                        <em>*</em></label>
                                                                                                    <select
                                                                                                        class="selectpicker select-custom"
                                                                                                        data-live-search="true">
                                                                                                        <option
                                                                                                            data-tokens="Bangladesh">
                                                                                                            Bangladesh
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="India">
                                                                                                            India
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Pakistan">
                                                                                                            Pakistan
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Pakistan">
                                                                                                            Pakistan
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Srilanka">
                                                                                                            Srilanka
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Nepal">
                                                                                                            Nepal
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Butan">
                                                                                                            Butan
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="USA">
                                                                                                            USA</option>
                                                                                                        <option
                                                                                                            data-tokens="England">
                                                                                                            England
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Brazil">
                                                                                                            Brazil
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Canada">
                                                                                                            Canada
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="China">
                                                                                                            China
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Koeria">
                                                                                                            Koeria
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Soudi">
                                                                                                            Soudi Arabia
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Spain">
                                                                                                            Spain
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="France">
                                                                                                            France
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Address
                                                                                                        <em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="add1"
                                                                                                        class="info mb-10"
                                                                                                        placeholder="Street Address">
                                                                                                    <input type="text"
                                                                                                        name="add2"
                                                                                                        class="info mt10"
                                                                                                        placeholder="Apartment, suite, unit etc. (optional)">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Town/City
                                                                                                        <em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="add1"
                                                                                                        class="info"
                                                                                                        placeholder="Town/City">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>State/Divison
                                                                                                        <em>*</em></label>
                                                                                                    <select
                                                                                                        class="selectpicker select-custom"
                                                                                                        data-live-search="true">
                                                                                                        <option
                                                                                                            data-tokens="Barisal">
                                                                                                            Barisal
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Dhaka">
                                                                                                            Dhaka
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Kulna">
                                                                                                            Kulna
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Rajshahi">
                                                                                                            Rajshahi
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Sylet">
                                                                                                            Sylet
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Chittagong">
                                                                                                            Chittagong
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Rangpur">
                                                                                                            Rangpur
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Maymanshing">
                                                                                                            Maymanshing
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Cox">
                                                                                                            Cox's Bazar
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Saint">
                                                                                                            Saint Martin
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Kuakata">
                                                                                                            Kuakata
                                                                                                        </option>
                                                                                                        <option
                                                                                                            data-tokens="Sajeq">
                                                                                                            Sajeq
                                                                                                        </option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div
                                                                                                    class="input-box mb-20">
                                                                                                    <label>Post Code/Zip
                                                                                                        Code<em>*</em></label>
                                                                                                    <input type="text"
                                                                                                        name="zipcode"
                                                                                                        class="info"
                                                                                                        placeholder="Zip Code">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form">
                                                                                <div class="input-box">
                                                                                    <label>Order Notes</label>
                                                                                    <textarea
                                                                                        placeholder="Notes about your order, e.g. special notes for delivery."
                                                                                        class="area-tex"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Checkout are end-->
                                        </div>
                                        <div role="tabpanel" class="tab-pane  fade in" id="complete-order">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="checkout-payment-area">
                                                        <div class="checkout-total mt20">
                                                            <h3>Your order</h3>
                                                            <div class="table-responsive">
                                                                <table class="checkout-area table">
                                                                    <thead>
                                                                        <tr class="cart_item check-heading">
                                                                            <td class="ctg-type"> Product</td>
                                                                            <td class="cgt-des"> Total</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                            <?php 
                                                                                $sqle = "SELECT * FROM cart INNER JOIN product ON cart.item = product.item_id WHERE uid = ".$_SESSION["id"];
                                                                                $resulte = mysqli_query($link, $sqle);
                                                                                if(mysqli_num_rows($resulte)>0)
                                                                                {
                                                                                    while($rowe = mysqli_fetch_assoc($resulte))
                                                                                    {
                                                                                        $totaL = 0.00;
                                                                                        $totaL = $rowe['cost'] * $rowe['quantity']; 
                                                                                        echo '
                                                                                        <tr class="cart_item check-item prd-name">
                                                                                        <td class="ctg-type">'.$rowe['item'].' *
                                                                                        <span>'.$rowe['quantity'].'</span></td>
                                                                                        <td class="cgt-des"> RM '.$totaL.'</td>
                                                                                        </tr>';
                                                                                    }
                                                                                }
                                                                            ?>
                                                                            
                                                                        
                                                                        <tr class="cart_item">
                                                                            <td class="ctg-type"> Subtotal</td>
                                                                            <td class="cgt-des"><?php echo 'RM '.$subTotal;?></td>
                                                                        </tr>
                                                                        <!--<tr class="cart_item">
                                                                            <td class="ctg-type">Shipping</td>
                                                                            <td class="cgt-des ship-opt">
                                                                                <div class="shipp">
                                                                                    <input type="radio"
                                                                                        id="pay-toggle" name="ship">
                                                                                    <label for="pay-toggle">Flat
                                                                                        Rate:
                                                                                        <span>$03</span></label>
                                                                                </div>
                                                                                <div class="shipp">
                                                                                    <input type="radio"
                                                                                        id="pay-toggle2"
                                                                                        name="ship">
                                                                                    <label for="pay-toggle2">Free
                                                                                        Shipping</label>
                                                                                </div>
                                                                            </td>
                                                                        </tr>-->
                                                                        <tr class="cart_item">
                                                                            <td class="ctg-type crt-total"> Total (include shipping fees)
                                                                            </td>
                                                                            <td class="cgt-des prc-total"> <?php echo 'RM '.$TOTAL;?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="payment-section mt-20 clearfix">
                                                            <div class="pay-toggle">
                                                                <!--<div class="pay-type-total">
                                                                    <div class="pay-type">
                                                                        <input type="radio" id="pay-toggle01"
                                                                            name="pay">
                                                                        <label for="pay-toggle01">Direct Bank
                                                                            Transfer</label>
                                                                    </div>
                                                                    <div class="pay-type">
                                                                        <input type="radio" id="pay-toggle02"
                                                                            name="pay">
                                                                        <label for="pay-toggle02">Cheque
                                                                            Payment</label>
                                                                    </div>
                                                                    <div class="pay-type">
                                                                        <input type="radio" id="pay-toggle03"
                                                                            name="pay">
                                                                        <label for="pay-toggle03">Cash on
                                                                            Delivery</label>
                                                                    </div>
                                                                    <div class="pay-type">
                                                                        <input type="radio" id="pay-toggle04"
                                                                            name="pay">
                                                                        <label for="pay-toggle04">Paypal</label>
                                                                    </div>
                                                                </div>-->
                                                                <div class="pay-type-total">
                                                                    <label><b>Payment Method:</b> </label>
                                                                    <select id="pay-type" name=methods required>
                                                                        <option value="Direct Bank Transfer" name="bank">Direct Bank Transfer</option>
                                                                        <option value="Cash On Delivery" name="cash">Cash On delivery</option>
                                                                        <option value="#" selected="">Select your method</option>
                                                                    </select>
                                                                </div>
                                                                <div class="input-box mt-20" id="payContainer" style="display: none;">
                                                                    <input type="submit" name="orders" style="background-color: gray;"class="btn btn-dark" value="Place Order">
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
                </div>
            </div>
        </div>
        <!--cart-checkout-area end-->

        <?php include('footer.php')?>
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

    <script>
        document.getElementById("pay-type").addEventListener("change", function() {
            var selectedSize = this.value;
            var payContainer = document.getElementById("payContainer");

            if (selectedSize !== "#") {
                payContainer.style.display = "block";
            } else {
                payContainer.style.display = "none";
            }
        });
    </script>
</body>

</html>