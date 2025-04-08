<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu - Premium Experience</title>
    <!-- Core CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --dark-color: #1a1a2e;
            --light-color: #f7f7f7;
            --success-color: #6ab04c;
            --warning-color: #f9ca24;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            color: #333;
            overflow-x: hidden;
        }
        
        /* Navbar Styling */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .nav-fixed {
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Breadcrumb Styling */
        .breadcrumb-section {
            background-color: var(--light-color);
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        
        .breadcrumb-custom-path {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            align-items: center;
        }
        
        .breadcrumb-custom-path li {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
        }
        
        .breadcrumb-custom-path li a {
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-custom-path li a:hover {
            color: var(--primary-color);
        }
        
        .breadcrumb-custom-path li.active {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        /* Order Steps */
        .top-links {
            background-color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .links {
            display: flex;
            justify-content: space-between;
            padding: 0;
            list-style: none;
        }
        
        .link-item {
            position: relative;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        
        .link-item.active {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.2);
        }
        
        .link-item span {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .link-item.active span {
            background-color: white;
            color: var(--primary-color);
        }
        
        .link-item a {
            color: inherit;
            text-decoration: none;
            font-weight: 500;
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            height: 250px;
            background-color: #333;
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        /* Menu Categories Section */
        .menu-title {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .menu-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .category-card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            border: none;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .category-img {
            height: 180px;
            overflow: hidden;
            position: relative;
        }
        
        .category-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            border: none !important;
        }
        
        .category-card:hover .category-img img {
            transform: scale(1.1);
        }
        
        .category-body {
            padding: 20px;
        }
        
        .category-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark-color);
        }
        
        .category-icons {
            margin-bottom: 15px;
        }
        
        .category-icons i {
            margin-right: 10px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }
        
        .category-card:hover .category-icons i {
            transform: bounce;
            animation: iconBounce 0.5s ease infinite alternate;
        }
        
        .btn-view-menu {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-view-menu:hover {
            background-color: var(--dark-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Popular Tags */
        .sidebar-widget {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
            color: var(--dark-color);
        }
        
        .tags {
            display: flex;
            flex-wrap: wrap;
            padding: 0;
            list-style: none;
        }
        
        .tags li {
            margin: 5px;
        }
        
        .tag {
            display: inline-block;
            padding: 6px 15px;
            background-color: var(--light-color);
            color: var(--dark-color);
            border-radius: 50px;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        
        .tag:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Back to top button */
        #movetop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: var(--primary-color);
            color: white;
            cursor: pointer;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        #movetop.visible {
            opacity: 1;
            visibility: visible;
        }
        
        #movetop:hover {
            background-color: var(--dark-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        /* Footer */
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 20px;
        }
        
        /* Animations */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes iconBounce {
            from { transform: translateY(0); }
            to { transform: translateY(-5px); }
        }
        
        .fade-in {
            animation: fade-in 0.5s ease forwards;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                height: 180px;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .links {
                flex-direction: column;
            }
            
            .link-item {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>


    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <div class="container">
            <ul class="breadcrumb-custom-path">
                <li><a href="index.php">Home</a></li>
                <li class="mx-2"><i class="fas fa-chevron-right" aria-hidden="true"></i></li>
                <li class="active">Menu</li>
            </ul>
        </div>
    </section>

    <div class="page-wrapper">
        <!-- Order Steps -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-md-4 link-item active" data-aos="fade-up" data-aos-delay="100">
                        <span>1</span><a href="restaurants.php">Choose Item from Category</a>
                    </li>
                    <li class="col-md-4 link-item" data-aos="fade-up" data-aos-delay="200">
                        <span>2</span><a href="#">Select Your Dish & Pick-up Time</a>
                    </li>
                    <li class="col-md-4 link-item" data-aos="fade-up" data-aos-delay="300">
                        <span>3</span><a href="#">Pick-Up Your Food and Pay online/COD</a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Hero Section -->
        <div class="container">
            <div class="hero-section" style="background-image: url('images/img/banner-bg.jpg');" data-aos="zoom-in">
                <div class="hero-content">
                    <h1 class="hero-title">Discover Our Menu</h1>
                    <p>Explore our delicious offerings prepared with fresh ingredients</p>
                </div>
            </div>
        </div>
        
        <!-- Menu Categories -->
        <section class="menu-categories py-5">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3" data-aos="fade-right">
                        <div class="sidebar-widget">
                            <h3 class="widget-title">
                                <i class="fas fa-tags mr-2"></i> Popular Tags
                            </h3>
                            <div class="widget-body">
                                <ul class="tags">
                                    <li><a href="#" class="tag">Pizza</a></li>
                                    <li><a href="#" class="tag">Sandwich</a></li>
                                    <li><a href="#" class="tag">Burger</a></li>
                                    <li><a href="#" class="tag">Fish</a></li>
                                    <li><a href="#" class="tag">Dessert</a></li>
                                    <li><a href="#" class="tag">Salad</a></li>
                                    <li><a href="#" class="tag">Pasta</a></li>
                                    <li><a href="#" class="tag">Vegan</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3 class="widget-title">
                                <i class="fas fa-filter mr-2"></i> Dietary Options
                            </h3>
                            <div class="widget-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="vegetarian">
                                    <label class="form-check-label" for="vegetarian">Vegetarian</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="vegan">
                                    <label class="form-check-label" for="vegan">Vegan</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="gluten-free">
                                    <label class="form-check-label" for="gluten-free">Gluten Free</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="low-carb">
                                    <label class="form-check-label" for="low-carb">Low Carb</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu Items -->
                    <div class="col-lg-9">
                        <h2 class="menu-title" data-aos="fade-in">Our Categories</h2>
                        <div class="row">
                            <?php 
                            $ress = mysqli_query($db,"select * from res_category");
                            $delay = 100;
                            while($rows = mysqli_fetch_array($ress)) {
                                echo '<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="'.$delay.'">
                                    <div class="category-card">
                                        <div class="category-img">
                                            <img src="admin/Category_Image/'.$rows['image'].'" alt="'.$rows['c_name'].'">
                                            <div class="category-overlay"></div>
                                        </div>
                                        <div class="category-body">
                                            <h5 class="category-title">'.$rows['c_name'].'</h5>
                                            <div class="category-icons">
                                                <i class="fas fa-bread-slice" style="color:#6d3200"></i>
                                                <i class="fas fa-apple-alt" style="color:Green"></i>
                                                <i class="fas fa-pizza-slice" style="color:red"></i>
                                                <i class="fas fa-carrot" style="color:orange"></i>
                                                <i class="fas fa-ice-cream" style="color:purple"></i>
                                            </div>
                                            <a href="dishes.php?c_id='.$rows['c_id'].'" class="btn-view-menu">View Menu</a>
                                        </div>
                                    </div>
                                </div>';
                                $delay += 100;
                                if($delay > 500) $delay = 100;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Special Offers Section -->
        <section class="special-offers py-5 bg-light">
            <div class="container">
                <h2 class="menu-title" data-aos="fade-up">Today's Special Offers</h2>
                <div class="row">
                    <div class="col-md-4" data-aos="flip-left" data-aos-delay="100">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-utensils fa-3x text-primary"></i>
                                </div>
                                <h4 class="card-title">Lunch Special</h4>
                                <p class="card-text">Get 20% off on all lunch menu items between 12PM - 3PM.</p>
                                <div class="badge bg-danger p-2">Limited Time</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-delay="200">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-hamburger fa-3x text-warning"></i>
                                </div>
                                <h4 class="card-title">Combo Deal</h4>
                                <p class="card-text">Order any burger and get a free drink and fries.</p>
                                <div class="badge bg-success p-2">Popular</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" data-aos="flip-left" data-aos-delay="300">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-gift fa-3x text-danger"></i>
                                </div>
                                <h4 class="card-title">Family Package</h4>
                                <p class="card-text">Order for 4+ people and get 15% off your total bill.</p>
                                <div class="badge bg-info p-2">Great Value</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Testimonials Section -->
        <section class="testimonials py-5">
            <div class="container">
                <h2 class="menu-title" data-aos="fade-up">What Our Customers Say</h2>
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="owl-carousel owl-theme testimonial-slider">
                            <div class="item p-4 bg-white rounded shadow" data-aos="zoom-in" data-aos-delay="100">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3">
                                        <img src="/api/placeholder/60/60" class="rounded-circle" alt="">
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Vishal Soni</h5>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                                <p>"The food quality and service are outstanding. I particularly love their pasta dishes!"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Back to top button -->
        <button onclick="topFunction()" id="movetop" title="Go to top">
            <i class="fas fa-chevron-up"></i>
        </button>
        
        <!-- Footer -->
        <?php include_once('footer.php'); ?>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="js/owl.carousel.js"></script>
    
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });
        
        // Back to top button functionality
        window.onscroll = function() {
            scrollFunction();
        };
        
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").classList.add("visible");
            } else {
                document.getElementById("movetop").classList.remove("visible");
            }
            
            // Add fixed class to navbar
            if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
                document.getElementById("site-header").classList.add("nav-fixed");
            } else {
                document.getElementById("site-header").classList.remove("nav-fixed");
            }
        }
        
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        
        // Initialize testimonial slider
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: [
                    "<i class='fas fa-chevron-left'></i>",
                    "<i class='fas fa-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    }
                }
            });
            
            // Add hover animation to category cards
            $('.category-card').hover(
                function() {
                    $(this).find('.category-icons i').each(function(index) {
                        setTimeout(() => {
                            $(this).addClass('animated bounce');
                        }, index * 100);
                    });
                },
                function() {
                    $(this).find('.category-icons i').removeClass('animated bounce');
                }
            );
        });
    </script>
</body>
</html>