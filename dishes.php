<?php
include("connection/connect.php"); // connection to db
session_start();

include_once 'product-action.php'; //including controller
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <!-- Favicon -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter2.css">
    
    <style>
        /* Global Styles */
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #4ECDC4;
            --dark-color: #292F36;
            --light-color: #F7F7F7;
            --success-color: #51cf66;
            --warning-color: #fcc419;
            --danger-color: #ff6b6b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Header */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .nav-fixed {
            background-color: white !important;
            padding: 0.5rem 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Top links */
        .top-links {
            background-color: var(--light-color);
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .top-links .links {
            display: flex;
            justify-content: space-between;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .top-links .link-item {
            position: relative;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .top-links .link-item.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        .top-links .link-item span {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.1);
            margin-right: 10px;
            font-weight: bold;
        }
        
        .top-links .link-item.active span {
            background-color: white;
            color: var(--primary-color);
        }
        
        .top-links .link-item a {
            color: inherit;
            text-decoration: none;
            font-weight: 500;
        }
        
        /* Hero section */
        .inner-page-hero {
            position: relative;
            padding: 80px 0;
            background-size: cover;
            background-position: center;
            color: white;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .inner-page-hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
            z-index: 1;
        }
        
        .inner-page-hero .profile {
            position: relative;
            z-index: 2;
        }
        
        .inner-page-hero .image-wrap {
            background-color: white;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transform: rotate(-2deg);
            transition: transform 0.5s ease;
        }
        
        .inner-page-hero .image-wrap:hover {
            transform: rotate(0deg);
        }
        
        .inner-page-hero .image-wrap img {
            border-radius: 8px;
            width: 100%;
            height: auto;
            transition: all 0.3s ease;
        }
        
        .inner-page-hero h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        /* Food cart */
        .widget-cart {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .widget-cart:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
        }
        
        .widget-heading {
            padding: 20px;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        
        .widget-body {
            padding: 20px;
        }
        
        .order-row {
            margin-bottom: 20px;
        }
        
        .title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
            font-weight: 500;
        }
        
        .title-row i {
            cursor: pointer;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
            margin-left: 5px;
        }
        
        .title-row i.fa-trash {
            color: var(--danger-color);
        }
        
        .title-row i.fa-plus {
            color: var(--success-color);
        }
        
        .title-row i.fa-minus {
            color: var(--warning-color);
        }
        
        .title-row i:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .price-wrap {
            padding: 20px 0;
            border-top: 1px solid #f1f1f1;
        }
        
        .price-wrap p {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .price-wrap h3 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark-color);
        }
        
        /* Food items */
        .menu-widget {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .food-item {
            padding: 20px;
            border-bottom: 1px solid #f1f1f1;
            transition: all 0.3s ease;
        }
        
        .food-item:hover {
            background-color: #f9f9f9;
        }
        
        .food-item:last-child {
            border-bottom: none;
        }
        
        .restaurant-logo {
            display: block;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }
        
        .restaurant-logo img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
            border: none !important;
        }
        
        .restaurant-logo:hover img {
            transform: scale(1.05);
        }
        
        .rest-descr {
            margin-top: 15px;
        }
        
        .rest-descr h6 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .rest-descr h6 a {
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .rest-descr h6 a:hover {
            color: var(--primary-color);
        }
        
        .rest-descr p {
            font-size: 14px;
            color: #666;
            margin-bottom: 0;
        }
        
        .item-cart-info {
            display: flex;
            align-items: center;
        }
        
        .price {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        /* Quantity input */
        .quantity {
            display: flex;
            align-items: center;
        }
        
        .quantity .minus, .quantity .plus {
            width: 32px;
            height: 32px;
            background-color: #f1f1f1;
            border: none;
            color: #555;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .quantity .minus:hover, .quantity .plus:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .quantity input[type="number"] {
            width: 40px;
            height: 32px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
            border-radius: 4px;
        }
        
        .theme-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .theme-btn:hover {
            background-color: darken(var(--primary-color), 10%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        
        /* Move top button */
        #movetop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 999;
            display: none;
            transition: all 0.3s ease;
        }
        
        #movetop:hover {
            background-color: darken(var(--primary-color), 10%);
            transform: translateY(-5px);
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.5s ease-in-out;
        }
        
        .slide-down {
            animation: slideDown 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .inner-page-hero h1 {
                font-size: 36px;
                margin: 30px 0;
            }
            
            .food-item .row {
                flex-direction: column;
            }
            
            .item-cart-info {
                margin-top: 15px;
            }
        }
        
        @media (max-width: 768px) {
            .top-links .links {
                flex-direction: column;
            }
            
            .top-links .link-item {
                margin-bottom: 10px;
            }
            
            .inner-page-hero h1 {
                font-size: 28px;
                margin: 20px 0;
            }
        }
    </style>
</head>

<body>
    <?php include_once('header.php'); ?>
    
    <div class="page-wrapper">
        <!-- Top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active" data-aos="fade-right" data-aos-delay="100">
                        <span>1</span><a href="menu.php">Choose Item from Category</a>
                    </li>
                    <li class="col-xs-12 col-sm-4 link-item" data-aos="fade-right" data-aos-delay="200">
                        <span>2</span><a href="#">Choose Your Dish & Select Pick-up Time</a>
                    </li>
                    <li class="col-xs-12 col-sm-4 link-item" data-aos="fade-right" data-aos-delay="300">
                        <span>3</span><a href="#">Pick-Up Your Food and Pay online/COD</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <?php 
            $ress = mysqli_query($db, "select * from res_category where c_id='$_GET[c_id]'");
            $rows = mysqli_fetch_array($ress);							  
        ?>
        
        <!-- Hero Section -->
        <section class="inner-page-hero bg-image" style="background-image: url('images/food2.jpg');">
            <div class="profile">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 profile-img" data-aos="fade-right">
                            <div class="image-wrap">
                                <figure><?php echo '<img src="admin/Category_Image/'.$rows['image'].'" alt="Food Category logo">'; ?></figure>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 profile-desc" data-aos="fade-left">
                            <div class="pull-left right-text white-txt">
                                <h1 class="animate__animated animate__fadeInDown"><?php echo $rows['c_name']; ?></h1>
                            </div>
                        </div>													
                    </div>
                </div>
            </div>
        </section>
        
        <div class="container mt-5">
            <div class="row">
                <!-- Food Cart Section -->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-aos="fade-up">                      
                    <div class="widget widget-cart">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                Your Food Cart <i class="fas fa-shopping-cart animate__animated animate__tada animate__delay-2s"></i>
                            </h3>							  
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="order-row bg-white">
                            <div class="widget-body">																		
                                <?php
                                    $item_total = 0;
                                    if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
                                        foreach ($_SESSION["cart_item"] as $item)  // fetch items define current into session ID
                                        {
                                ?>									                                                                  
                                    <div class="title-row fade-in">
                                        <?php echo $item["title"]; ?>
                                        <div>
                                            <a href="dishes.php?c_id=<?php echo $_GET['c_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>" class="ms-2">     
                                                <i class="fas fa-trash pull-right"></i>
                                            </a>
                                            <a href="dishes.php?c_id=<?php echo $_GET['c_id'];?>&action=add1&id=<?php echo $item['d_id']; ?>" class="ms-2">     
                                                <i class="fas fa-plus pull-right"></i>
                                            </a> 
                                            <a href="dishes.php?c_id=<?php echo $_GET['c_id']; ?>&action=minus&id=<?php echo $item["d_id"]; ?>" class="ms-2">     
                                                <i class="fas fa-minus pull-right"></i>
                                            </a>
                                        </div>                                  
                                    </div>							
                                    
                                    <div class="form-group row no-gutter">
                                        <div class="col-xs-8 col-sm-8">
                                            <input type="text" class="form-control" value="₹<?php echo $item["price"]; ?>" readonly>                                                  
                                        </div>
                                        <div class="col-xs-4 col-sm-4">
                                            <input class="form-control" type="text" readonly value="<?php echo $item["quantity"]; ?>"> 
                                        </div>                                       
                                    </div>
                                
                                <?php
                                        $item_total += ($item["price"]*$item["quantity"]); // calculating current price into cart
                                        }
                                    } else {
                                        echo '<div class="text-center py-4">Your cart is empty</div>';
                                    }
                                ?>								    
                            </div>
                        </div>
                        
                        <div class="widget-body">
                            <div class="price-wrap text-center">
                                <p>TOTAL</p>
                                <h3 class="value animate__animated animate__pulse animate__infinite"><strong>₹<?php echo $item_total; ?></strong></h3>                                     
                                <?php
                                    $_SESSION["total"] = $item_total;
                                    if($item_total == 0) {
                                        unset($_SESSION["cart_item"]);
                                    } else {
                                ?>     
                                    <a href="checkout.php?c_id=<?php echo $_GET['c_id'];?>&action=check" class="btn theme-btn btn-lg animate__animated animate__bounceIn animate__delay-1s">
                                        <i class="fas fa-shopping-bag me-2"></i> Checkout
                                    </a>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>											
                    </div>
                </div>

                <!-- Food Items Section -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="menu-widget" id="popular-items">
                        <div class="widget-heading">
                            <h3 class="widget-title text-dark">
                                <b class="animate__animated animate__fadeIn">POPULAR ORDERS Delicious Hot Food is Here!</b>
                                <a class="btn btn-link pull-right" data-bs-toggle="collapse" href="#popular2" aria-expanded="true">
                                    <i class="fas fa-angle-down"></i>
                                </a>
                            </h3>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div class="collapse show" id="popular2">
                            <?php  // display values and item of food/dishes
                                $sql = mysqli_query($db, "SELECT * FROM dishes WHERE c_id='$_GET[c_id]'");
                                $products = [];
                                
                                while($row = mysqli_fetch_array($sql)) {
                                    $products[] = $row;
                                }							  
                   
                                if (!empty($products)) {
                                    foreach($products as $index => $product) {
                            ?>
                            
                            <div class="food-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                                <div class="row align-items-center">
                                    <div class="col-xs-12 col-sm-12 col-lg-5">
                                        <form method="post" action='dishes.php?c_id=<?php echo $_GET['c_id'];?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                            <div class="rest-logo pull-left">
                                                <?php                            
                                                    if ($product['status'] == '1') {                                                                                                                   
                                                ?>
                                                    <a class="restaurant-logo pull-left" href="#">
                                                        <?php echo '<img src="admin/Category_Image/dishes/'.$product['img'].'" alt="Food logo" class="img-fluid animate__animated animate__fadeIn">'; ?>
                                                    </a>
                                                <?php
                                                    } else {
                                                ?> 
                                                    <a class="restaurant-logo pull-left" href="#">
                                                        <?php echo '<img src="admin/Category_Image/dishes/'.$product['img'].'" alt="Food logo" style="filter: grayscale(100%);" class="img-fluid">'; ?>
                                                    </a>
                                                <?php
                                                    }                                          
                                                ?>           
                                            </div>
                                            
                                            <div class="rest-descr">
                                                <h6><a href="#"><?php echo $product['title']; ?></a></h6>
                                                <p><?php echo $product['slogan']; ?></p>
                                            </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-lg-2 text-end item-cart-info"> 
                                        <span class="price">₹<?php echo $product['price']; ?></span>
                                    </div>
                                    
                                    <?php                            
                                        if ($product['status'] == '1') {                                                                          
                                    ?>
                                    <div class="col-xs-12 col-sm-12 col-lg-2 item-cart-info quantity buttons_added"> 
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="0" max="" name="quantity" id="QTY_<?php echo $product['d_id']; ?>" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                                        <input type="button" value="+" class="plus">         
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-lg-3 text-end item-cart-info"> 
                                        <button type="submit" class="btn theme-btn animate__animated animate__fadeIn">
                                            <i class="fas fa-cart-plus me-2"></i> Add to cart
                                        </button>
                                    </div>
                                    <?php                            
                                        } else {
                                            echo '<div class="col-xs-12 col-sm-12 col-lg-5 text-end item-cart-info"> 
                                                <span class="badge bg-danger"><i class="fas fa-clock me-1"></i> Not Available</span>
                                            </div>';
                                        }                                            
                                    ?>
                                        </form>
                                </div>
                            </div>
                            
                            <?php
                                    }
                                } else {
                                    echo '<div class="text-center py-5">No dishes available in this category.</div>';
                                }
                            ?>		           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
        <?php include_once('footer.php'); ?>
    </div>
    
    <!-- Move to top button -->
    <button onclick="topFunction()" id="movetop" title="Go to top" class="animate__animated animate__fadeIn">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <!-- Custom JS -->
    <script src="js/quantity.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        
        // Prevent refresh with F5
        $(function() {  
            $(document).keydown(function(e) {  
                return (e.which || e.keyCode) != 116;  
            });  
        });
        
        // Add hover animations to food items
        $('.food-item').hover(
            function() {
                $(this).find('.theme-btn').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('.theme-btn').removeClass('animate__animated animate__pulse');
            }
        );
        
        // Cart items animation
        $('.title-row').hover(
            function() {
                $(this).find('i').addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).find('i').removeClass('animate__animated animate__pulse');
            }
        );
        
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    window.location.hash = hash;
                });
            }
        });
        
        // Page loading animation
        $(window).on('load', function() {
            $('body').addClass('fade-in');
        });
        
        // Navbar fixed on scroll
        $(window).on("scroll", function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });
        
        // Mobile navigation
        $(".navbar-toggler").on("click", function() {
            $("header").toggleClass("active");
        });
        
        $(document).ready(function() {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
            
            $(window).resize(function() {
                if ($(window).width() > 991) {
                    $("header").removeClass("active");
                }
            });
        });
    </script>
</body>
</html>