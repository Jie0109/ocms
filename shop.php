<?php
    include("header.php");
?>
<style>
    .single-prodcut-img {
    /* Set a specific width and height for the div */
    width: 250px;
    height: 250px;
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
        <!--breadcumb area start -->
        <div class="breadcumb-area overlay pos-rltv">
            <div class="bread-main">
                <div class="bred-hading text-center">
                    <h5>Product</h5> </div>
                <ol class="breadcrumb">
                    <li class="home"><a title="Go to Home Page" href="index.php">Home</a></li>
                    <li class="active">Shop</li>
                </ol>
            </div>
        </div>
        <!--breadcumb area end -->
        
        <!--shop main area are start-->
        <div class="shop-main-area grid-view_area ptb-70">
            <div class="container">
                <div class="row">
                    <!--main-shop-product start-->
                    <div class="col-lg-9 col-md-8 order-lg-2 order-md-2 order-1">
                        <div class="shop-wraper">
                            <div class="col-lg-12">
                                <div class="shop-area-top">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-9 col-md-9">
                                            <!--<div class="sort product-show">
                                                <label>View</label>
                                                <select id="input-amount">
                                                    <option value="volvo">10</option>
                                                    <option value="saab">15</option>
                                                    <option value="vw">20</option>
                                                    <option value="audi" selected>25</option>
                                                </select>
                                            </div>-->
                                            <div class="sort product-type">
                                                <form action="" method="GET">
                                                    <label>Sort By</label>
                                                    <select name="sort" id="input-sort">
                                                        <option value="#">Filter</option>
                                                        <option value="ASC" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'a-z'){echo "selected";}?>>Brand (A - Z)</option>
                                                        <option value="DSC" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'z-a'){echo "selected";}?>>Brand (Z - A)</option>
                                                        <option value="LH"  <?php if(isset($_GET['sort']) && $_GET['sort'] == 'lh'){echo "selected";}?>>Price (Low &gt; High)</option>
                                                        <option value="HL"  <?php if(isset($_GET['sort']) && $_GET['sort'] == 'hl'){echo "selected";}?>>Price (High &gt; Low)</option>
                                                        <!--<option value="#">Rating (Highest)</option>
                                                        <option value="#">Rating (Lowest)</option>
                                                        <option value="#">Model (A - Z)</option>
                                                        <option value="#">Model (Z - A)</option>-->
                                                    </select>
                                                    <button style="color: white; background-color: black; border-color: white; padding: 2px 10px;" type="submit" class="thm-btn"><i class="fa fa-search"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <!--<div class="col-xl-3 col-lg-3 col-md-3">
                                            <div class="list-grid-view text-center">
                                                <ul class="nav" role="tablist">
                                                    <li role="presentation"><a class="active" href="#grid" aria-controls="grid"
                                                            role="tab" data-bs-toggle="tab"><i class="zmdi zmdi-widgets"></i></a>
                                                    </li>
                                                    <li role="presentation"><a href="#list" aria-controls="list" role="tab"
                                                            data-bs-toggle="tab"><i class="zmdi zmdi-view-list-alt"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>-->
                                        <!--<div class="col-xl-3 d-lg-none d-xl-block d-none">
                                            <div class="total-showing text-end">
                                                Showing - <span>10</span> to <span>18</span> Of Total <span>36</span>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="shop-total-product-area clearfix mt-35">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <!--tab grid are start-->
                                        <div role="tabpanel" class="tab-pane fade show active" id="grid">
                                            <div class="total-shop-product-grid row">
                                            <!--<div class="product-icon socile-icon-tooltip text-center">
                                                <ul>
                                                    <li><a href="#" data-tooltip="Add To Cart" class="add-cart"
                                                            data-placement="left"><i
                                                                class="fa fa-cart-plus"></i></a>
                                                    </li>
                                                </ul>
                                            </div>-->
                                            <!-- single product start-->
                                                <?php
                                                    
                                                    if(isset($_GET['start_price']) && isset($_GET['end_price']))
                                                    {
                                                        $startprice = $_GET['start_price'];
                                                        $endprice = $_GET['end_price'];
                                                        $sqll = "SELECT * FROM product WHERE cost BETWEEN $startprice AND $endprice AND userID IS NULL AND active IS NULL";
                                                    }
                                                    else if(isset($_GET['search']))
                                                    {
                                                        $sValue = $_GET['search'];
                                                        $sqll = "SELECT * FROM product WHERE CONCAT(item) like '%$sValue%' AND userID IS NULL AND active IS NULL";
                                                    }
                                                    else if(isset($_GET['sort']))
                                                    {
                                                        if($_GET['sort'] == 'ASC')
                                                        {
                                                            $sort_option = "ASC";
                                                            $sqll = "SELECT * FROM product WHERE userID IS NULL AND active IS NULL ORDER BY item $sort_option";
                                                        }
                                                        else if($_GET['sort'] == 'DSC')
                                                        {
                                                            $sort_option = "DESC"; 
                                                            $sqll = "SELECT * FROM product WHERE userID IS NULL AND active IS NULL ORDER BY item $sort_option";
                                                        }
                                                        else if($_GET['sort'] == 'LH')
                                                        {
                                                            $sort_option = "ASC"; 
                                                            $sqll = "SELECT * FROM product WHERE userID IS NULL AND active IS NULL ORDER BY cost $sort_option";
                                                        }
                                                        else if($_GET['sort'] == 'HL')
                                                        {
                                                            $sort_option = "DESC"; 
                                                            $sqll = "SELECT * FROM product WHERE userID IS NULL AND active IS NULL ORDER BY cost $sort_option";
                                                        }   
                                                    }
                                                    else
                                                    {
                                                        $sqll = "SELECT * from product WHERE userID IS NULL AND active IS NULL";
                                                    }

                                                    $results = mysqli_query($link, $sqll);

                                                    if(isset($_GET['brand']))
                                                    {
                                                        $brandchecked = [];
                                                        $brandchecked = $_GET['brand'];
                                                        foreach($brandchecked as $rowbrand)
                                                        {
                                                            $products = "SELECT * FROM product WHERE brand_id = $rowbrand AND active IS NULL";
                                                            $products_run = mysqli_query($link, $products);
                                                            if(mysqli_num_rows($products_run) > 0)
                                                            {
                                                                foreach($products_run as $row)
                                                                {
                                                                    echo '
                                                                    <div class="col-lg-4 col-md-6 item">
                                                                    <div class="single-product">
                                                                        <div class="product-img">
                                                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                                                <a href="single-product.php?item_id='.$row['item_id'].'"> <img alt=""
                                                                                        src="images/product/'.$row['images'].'" class="primary-image"> <img
                                                                                        alt="" src="images/product/'.$row['imgs'].'"
                                                                                        class="secondary-image">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-text">
                                                                            <div class="prodcut-name"> <a href="single-product.php?item_id='.$row['item_id'].'">'.$row['item'].'</a> </div>
                                                                            <div class="prodcut-ratting-price">
                                                                                <div class="prodcut-price">
                                                                                    <div class="new-price"> RM '.$row['cost'].' </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>';
                                                                }
                                                                
                                                            }
                                                        }
                                                    }
                                                    else if(mysqli_num_rows($results)>0)
                                                    {
                                                        while($row = mysqli_fetch_assoc($results))
                                                        echo'
                                                        <div class="col-lg-4 col-md-6 item">
                                                            <div class="single-product">
                                                                <div class="product-img">
                                                                    <div class="single-prodcut-img  product-overlay pos-rltv">
                                                                        <a href="single-product.php?item_id='.$row['item_id'].'"> <img alt=""
                                                                                src="images/product/'.$row['images'].'" class="primary-image"> <img
                                                                                alt="" src="images/product/'.$row['imgs'].'"
                                                                                class="secondary-image">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-text">
                                                                    <div class="prodcut-name"> <a href="single-product.php?item_id='.$row['item_id'].'">'.$row['item'].'</a> </div>
                                                                    <div class="prodcut-ratting-price">
                                                                        <div class="prodcut-price">
                                                                            <div class="new-price"> RM '.$row['cost'].' </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                    }
                                                    else
                                                    {
                                                        echo "No Record Found!";
                                                    }
                                                ?>
                                            <!-- single product end-->
                                            </div>
                                        </div>
                                        <!--shop grid are end-->
        
                                        <!--shop product list start-->
                                        <div role="tabpanel" class="tab-pane fade" id="list">
                                            <div class="total-shop-product-list row">
                                                <?php

                                                $sqll = "SELECT * from product WHERE userID IS NULL AND active IS NULL";
                                                $results = mysqli_query($link, $sqll);
                                                if(mysqli_num_rows($results)>0)
                                                while($row = mysqli_fetch_assoc($results))
                                                {
                                                    echo'
                                                    <div class="col-lg-12 item">
                                                        <!-- single product start-->
                                                        <div class="single-product single-product-list">
                                                            <div class="product-img">
                                                                <div class="product-label red">
                                                                    <div class="new">Sale</div>
                                                                </div>
                                                                <div class="single-prodcut-img  product-overlay pos-rltv">
                                                                    <a href="single-product.php?item_id='.$row['item_id'].'"> <img alt=""
                                                                            src="images/product/'.$row['images'].'" class="primary-image"> <img
                                                                            alt="" src="images/product/'.$row['imgs'].'"
                                                                            class="secondary-image">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="product-text prodcut-text-list fix">
                                                                <div class="prodcut-name list-name montserrat"> <a
                                                                        href="single-product.php?item_id='.$row['item_id'].'">'.$row['item'].'</a>
                                                                </div>
                                                                <div class="prodcut-ratting-price">
                                                                    <div class="prodcut-ratting list-ratting">
                                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                                    </div>
                                                                    <div class="prodcut-price list-price">
                                                                        <div class="new-price"> RM '.$row['cost'].' </div>
                                                                    </div>
                                                                </div>
                                                                <div class="list-product-content">
                                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing
                                                                        elit.
                                                                        Fusce
                                                                        dolor tellus, bibendum eu lacus ids suscipit
                                                                        blandit tortor. Aenean eget posuere augue, vel
                                                                        molestie
                                                                        turpis.
                                                                        Ut tempor mauris ut justo luctus aliquam. Nullam
                                                                        id quam vitae odio scelerisque ultrices.</p>
                                                                </div>
                                                                <div class="social-icon-wraper mt-25">
                                                                    <div class="social-icon socile-icon-style-1">
                                                                        <ul>
                                                                            <li><a href="#"><i
                                                                                        class="zmdi zmdi-shopping-cart"></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i
                                                                                        class="zmdi zmdi-favorite-outline"></i></a>
                                                                            </li>
                                                                            <li><a href="#" data-tooltip="Quick View" class="q-view"
                                                                                    data-bs-toggle="modal" data-bs-target=".modal"
                                                                                    tabindex="0"><i class="zmdi zmdi-eye"></i></a>
                                                                            </li>
                                                                            <li><a href="#"><i class="zmdi zmdi-repeat"></i></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- single product end-->
                                                    </div>';
                                                }

                                                ?>
                                                
                                            </div>
                                        </div>
                                        <!--shop product list end-->
        
                                        <!--pagination start
                                        <div class="col-lg-12">
                                            <div class="pagination-btn text-center">
                                                <ul class="page-numbers">
                                                    <li><a href="#" class="next page-numbers"><i
                                                                class="zmdi zmdi-long-arrow-left"></i></a></li>
                                                    <li><span class="page-numbers current">1</span></li>
                                                    <li><a href="#" class="page-numbers">2</a></li>
                                                    <li><a href="#" class="page-numbers">3</a></li>
                                                    <li><a href="#" class="next page-numbers"><i
                                                                class="zmdi zmdi-long-arrow-right"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        pagination end-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--main-shop-product start-->
        
                    <!--shop sidebar start-->
                    <div class="col-lg-3 col-md-4 order-lg-1 order-md-1 order-2">
                        <div class="shop-sidebar">
                            <!--single aside start-->
                            <aside class="single-aside search-aside search-box">
                                <form action="" method="GET">
                                    <div class="input-box">
                                        <input name="search" class="single-input" placeholder="Search...." type="text" value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                                        <button class="src-btn sb-2"><i class="fa fa-search" type="submit"></i></button>
                                    </div>
                                </form>
                            </aside>
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <aside class="single-aside catagories-aside">
                                <form action="" method="GET">
                                    <div class="heading-title aside-title pos-rltv">
                                        <h5 class="uppercase">categories</h5>
                                    </div>
                                    <div id="cat-treeview" class="product-cat">
                                        <?php
                                            $sql ="SELECT brand.brand_id, brand.brand_name, brand.brand_img, brand.brand_chart, COUNT(product.brand_id) AS product_count FROM product INNER JOIN brand ON product.brand_id = brand.brand_id WHERE brand.brand_name != 'Custom' AND active IS NULL GROUP BY brand.brand_id, brand.brand_name, brand.brand_img, brand.brand_chart;";
                                            $result = mysqli_query($link, $sql);

                                            if(mysqli_num_rows($result) > 0)
                                            {
                                                while($row = mysqli_fetch_assoc($result))
                                                {
                                                    $checked = [];
                                                    if(isset($_GET['brand']))
                                                    {
                                                        $checked = $_GET['brand'];
                                                    }
                                                    echo
                                                    '
                                                        <ul>
                                                        '.$row['brand_name'].'<input type="checkbox" name="brand[]" value="'.$row['brand_id'].'">
                                                        </ul>
                                                    ';  
                                                    
                                                }
                                                
                                            }
                                        ?><br>
                                                <!--ul example
                                                <ul>
                                                    <li><a href="#">T-Shirt</a></li>
                                                    <li><a href="#">Shirt</a></li>
                                                    <li><a href="#">Pant</a></li>
                                                    <li><a href="#">Shoe</a></li>
                                                    <li><a href="#">Gifts</a></li>
                                                </ul> -->
                                            <button type="submit" class="btn btn-success px-4"><b>Filter</b></button>
                                    </div>
                                </form>
                                <br>
                            </aside>
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <form action="" method="GET">
                                <aside class="single-aside price-aside fix">
                                    <div class="heading-title aside-title pos-rltv">
                                        <h5 class="uppercase">price</h5>
                                    </div>
                                    <div class="price_filter">
                                        <label for="">Start price:</label> 
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="number" name="start_price" min="1" value="<?php if(isset($_GET['start_price'])){echo $_GET['start_price']; }else{echo "1";} ?>" class="form-control">
                                        </div>
                                        <label for="">End price:</label> 
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="number" name="end_price" min="2" value="<?php if(isset($_GET['end_price'])){echo $_GET['end_price']; }else{echo "2";} ?>" class="form-control">
                                        </div>
                                        <div class="input-group input-group-sm mb-3">
                                            <button type="submit" class="btn btn-success px-4"><b>Filter</b></button>
                                        </div>
                                    </div>
                                </aside>
                            </form>
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <!--<aside class="single-aside color-aside">
                                <div class="heading-title aside-title pos-rltv">
                                    <h5 class="uppercase">Color</h5>
                                </div>
                                <ul class="color-filter mt-30">
                                    <li><a href="#" class="color-1"></a></li>
                                    <li><a href="#" class="color-2 active"></a></li>
                                    <li><a href="#" class="color-3"></a></li>
                                    <li><a href="#" class="color-4"></a></li>
                                    <li><a href="#" class="color-5"></a></li>
                                    <li><a href="#" class="color-6"></a></li>
                                    <li><a href="#" class="color-7"></a></li>
                                    <li><a href="#" class="color-8"></a></li>
                                    <li><a href="#" class="color-9"></a></li>
                                </ul>
                            </aside>-->
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <!--<aside class="single-aside size-aside">
                                <div class="heading-title aside-title pos-rltv">
                                    <h5 class="uppercase">Size Option</h5>
                                </div>
                                <ul class="size-filter mt-30">
                                    <li><a href="#" class="size-s">S</a></li>
                                    <li><a href="#" class="size-m">M</a></li>
                                    <li><a href="#" class="size-l">L</a></li>
                                    <li><a href="#" class="size-xl">XL</a></li>
                                    <li><a href="#" class="size-xxl">XXL</a></li>
                                </ul>
                            </aside>-->
        
                            <!--single aside start-->
                            <!--<aside class="single-aside tag-aside">
                                <div class="heading-title aside-title pos-rltv">
                                    <h5 class="uppercase">Product Tags</h5>
                                </div>
                                <ul class="tag-filter mt-30">
                                    <li><a href="#">Fashion</a></li>
                                    <li><a href="#">Women</a></li>
                                    <li><a href="#">Winter</a></li>
                                    <li><a href="#">Street Style</a></li>
                                    <li><a href="#">Style</a></li>
                                    <li><a href="#">Shop</a></li>
                                    <li><a href="#">Collection</a></li>
                                    <li><a href="#">Spring 2022</a></li>
                                </ul>
                            </aside>-->
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <aside class="single-aside product-aside">
                                <div class="heading-title aside-title pos-rltv">
                                    <h5 class="uppercase">Popular Product</h5>
                                </div>
                                <div class="recent-prodcut-wraper total-rectnt-slider">
                                    <div class="single-rectnt-slider">
                                        <!-- single product start-->
                                        <?php
                                            $rand = "SELECT * FROM product WHERE userID IS NULL ORDER BY RAND() LIMIT 2";
                                            $resultR = (mysqli_query($link, $rand));
                                            if(mysqli_num_rows($resultR) > 0)
                                            {
                                                while($rowd = mysqli_fetch_assoc($resultR))
                                                {
                                                    echo'
                                                    <div class="single-product recent-single-product">
                                                        <div class="product-img">
                                                            <div class="single-prodcut-img  product-overlay pos-rltv">
                                                                <a href="single-product.php?item_id='.$rowd['item_id'].'"> <img alt="" src="images/product/'.$rowd['images'].'"
                                                                        class="primary-image">
                                                                    <img alt="" src="images/product/'.$rowd['imgs'].'" class="secondary-image"> </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-text">
                                                            <div class="prodcut-name"> <a href="single-product.php">Copenhagen
                                                                    Spitfire Chair</a> </div>
                                                            <div class="prodcut-ratting-price">
                                                                <div class="prodcut-ratting"> <a href="#"><i class="fa fa-star"></i></a> <a
                                                                        href="#"><i class="fa fa-star"></i></a> <a href="#"><i
                                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                                            class="fa fa-star"></i></a> <a href="#"><i
                                                                            class="fa fa-star-o"></i></a> </div>
                                                                <div class="prodcut-price">
                                                                    <div class="new-price"> $220 </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ';
                                                }
                                            }
                                        ?>
                                        <!-- single product end-->
                                    </div>
                                    
                                </div>
        
                            </aside>
                            <!--single aside end-->
        
                            <!--single aside start-->
                            <!--<aside class="single-aside add-aside">
                                <a href="single-product.php"><img src="images/banner/add.jpg" alt=""></a>
                            </aside>-->
                            <!--single aside end-->
                        </div>
                    </div>
                    <!--shop sidebar end-->
                </div>
            </div>
        </div>
        <!--shop main area are end-->
        
        
        <!--footer area start-->
        
        <?php include('footer.php');?>
        
        <!-- QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                              <div class="product-images"> 
                                   <!--modal tab start-->
                                    <div class="portfolio-thumbnil-area-2">
                                        <div class="tab-content active-portfolio-area-2">
                                            <div role="tabpanel" class="tab-pane active" id="view1">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/01.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view2">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/02.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view3">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/03.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="view4">
                                                <div class="product-img">
                                                    <a href="#"><img src="images/product/04.jpg" alt="Single portfolio" /></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-more-views-2">
                                            <div class="thumbnail-carousel-modal-2 nav" data-tabs="tabs">
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
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--modal tab end-->
                                    <!-- .product-images -->
                                    <div class="product-info">
                                        <h1>Aenean eu tristique</h1>
                                        <div class="price-box-3">
                                            <div class="s-price-box"> <span class="new-price">$160.00</span> <span class="old-price">$190.00</span> </div>
                                        </div> <a href="shop.php" class="see-all">See all features</a>
                                        <div class="quick-add-to-cart">
                                            <form method="post" class="cart">
                                                <div class="numbers-row">
                                                    <input type="number" id="french-hens" value="3" min="1"> </div>
                                                <button class="single_add_to_cart_button" type="submit">Add to cart</button>
                                            </form>
                                        </div>
                                        <div class="quick-desc"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.Nam fringilla tristique auctor. </div>
                                        <div class="social-sharing-modal">
                                            <div class="widget widget_socialsharing_widget">
                                                <h3 class="widget-title-modal">Share this product</h3>
                                                <ul class="social-icons-modal">
                                                    <li><a  title="Facebook" href="#" class="facebook m-single-icon"><i class="fa fa-facebook"></i></a></li>
                                                    <li><a  title="Twitter" href="#" class="twitter m-single-icon"><i class="fa fa-twitter"></i></a></li>
                                                    <li><a  title="Pinterest" href="#" class="pinterest m-single-icon"><i class="fa fa-pinterest"></i></a></li>
                                                    <li><a  title="Google +" href="#" class="gplus m-single-icon"><i class="fa fa-google-plus"></i></a></li>
                                                    <li><a  title="LinkedIn" href="#" class="linkedin m-single-icon"><i class="fa fa-linkedin"></i></a></li>
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

</body>

</html>