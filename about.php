<?php include_once('header.php'); ?>
<!-- Modern CSS with animations -->
<link rel="stylesheet" href="assets/css/style-starter.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --primary-color: #ff6b6b;
        --secondary-color: #ffa31a;
        --text-color: #333333;
        --light-bg: #f8f9fa;
        --dark-bg: #343a40;
        --accent: #4ecdc4;
    }
    
    /* Modern animations */
    .fade-in-up {
        animation: fadeInUp 1s ease-out;
    }
    
    .bounce-in {
        animation: bounceIn 0.8s ease-out;
    }
    
    .slide-in-right {
        animation: slideInRight 0.8s ease-out;
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    /* Food item cards */
    .food-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 20px;
        background: white;
    }
    
    .food-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .food-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        transition: all 0.5s ease;
    }
    
    .food-card:hover img {
        transform: scale(1.1);
    }
    
    .food-card-body {
        padding: 15px;
    }
    
    .food-card-title {
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--dark-bg);
    }
    
    .food-card-price {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.2rem;
    }
    
    .food-card-desc {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }
    
    /* Testimonial section */
    .testimonial-card {
        background: var(--light-bg);
        border-radius: 10px;
        padding: 25px;
        margin: 20px 0;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .testimonial-card:before {
        content: """;
        font-size: 80px;
        color: var(--primary-color);
        opacity: 0.2;
        position: absolute;
        top: -10px;
        left: 20px;
    }
    
    .customer-img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
    }
    
    .customer-details {
        display: flex;
        align-items: center;
        margin-top: 15px;
    }
    
    .customer-name {
        font-weight: 700;
        color: var(--dark-bg);
        margin-bottom: 0;
    }
    
    .customer-profession {
        font-size: 0.8rem;
        color: #666;
    }
    
    /* Hero section enhancement */
    .hero-section {
        position: relative;
        padding: 80px 0;
        background-color: var(--light-bg);
    }
    
    .hero-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,107,107,0.1) 0%, rgba(255,163,26,0.1) 100%);
    }
    
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    /* Special Badge */
    .badge-special {
        position: absolute;
        top: -10px;
        right: 10px;
        background: var(--primary-color);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        box-shadow: 0 5px 10px rgba(255,107,107,0.3);
        z-index: 1;
    }
    
    /* Order button */
    .btn-order {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-order:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
</style>

<!-- Breadcrumb with animation -->
<section class="w3l-breadcrumb animate__animated animate__fadeIn">
    <div class="container">
        <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> About Us</li>
        </ul>
    </div>
</section>

<!-- Hero Section with Animation -->
<section class="hero-section" id="intro">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate__animated animate__fadeInLeft">
                <h1 class="display-4 fw-bold mb-4">The Taste of <span style="color: var(--primary-color);">India</span> in Your Campus</h1>
                <p class="lead mb-4">Experience authentic Indian flavors with a modern twist. Our canteen brings you the best of traditional and fusion cuisine at student-friendly prices.</p>
                <div class="d-flex gap-3">
                    <a href="#menu" class="btn-order btn-lg pulse">View Menu</a>
                    <a href="#testimonials" class="btn btn-outline-dark">Our Customers</a>
                </div>
            </div>
            <div class="col-lg-6 animate__animated animate__fadeInRight">
                <div class="position-relative">
                    <img src="assets/images/hero-food.jpg" alt="Delicious Indian Food" class="img-fluid rounded-lg floating" 
                         onerror="this.src='https://www.tastingtable.com/img/gallery/20-delicious-indian-dishes-you-have-to-try-at-least-once/l-intro-1733153567.jpg'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="w3l-about1 py-5 animate__animated animate__fadeIn" id="about">
    <div class="new-block top-bottom py-lg-5 py-md-4">
        <div class="container">
            <div class="title-content text-center">
                <h6 class="sub-title slide-in-right">who we are</h6>
                <h3 class="title-big bounce-in">About us</h3>
            </div>
            <div class="row mt-lg-5 mt-4">
                <div class="col-md-6 middle-section text-center align-self fade-in-up">
                    <div class="section-width mb-lg-4 py-4">
                        <h2>Authentic Indian Cuisine in Your Campus</h2>
                        <p class="mt-4">Started by Chef Rahul Sharma in 2018, our canteen has been serving delicious, hygienic, and affordable meals to students. We use fresh ingredients and authentic spices to prepare food that reminds you of home.</p>
                        <p class="mt-3">Every dish is prepared with love and care, ensuring that you get not just food, but an experience that makes your day better.</p>
                    </div>
                    
                    <!-- Video popup with animation -->
                    <div class="video-popup mt-4">
                        <a href="#small-dialog" class="popup-with-zoom-anim play-view text-center position-absolute">
                            <span class="video-play-icon pulse">
                                <span class="fa fa-play"></span>
                            </span>
                            <h6>Watch our story</h6>
                        </a>
                    </div>
                    
                    <!-- Dialog for video popup -->
                    <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                        <iframe src="https://www.youtube.com/embed/oWP9Riq-ZBg" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6 right-section mt-md-0 mt-4 fade-in-up" style="animation-delay: 0.3s;">
                    <div class="row">
                        <div class="col-6">
                            <img src="assets/images/about-img1.jpg" alt="Our Kitchen" class="img-fluid rounded shadow mb-4" 
                                 onerror="this.src='https://via.placeholder.com/400x300/ffa31a/ffffff?text=Our+Kitchen'">
                            <img src="assets/images/about-img2.jpg" alt="Our Team" class="img-fluid rounded shadow" 
                                 onerror="this.src='https://via.placeholder.com/400x300/4ecdc4/ffffff?text=Our+Team'">
                        </div>
                        <div class="col-6 pt-4">
                            <img src="assets/images/about-img3.jpg" alt="Food Preparation" class="img-fluid rounded shadow mb-4" 
                                 onerror="this.src='https://via.placeholder.com/400x300/ff6b6b/ffffff?text=Food+Preparation'">
                            <img src="assets/images/about-img4.jpg" alt="Our Canteen" class="img-fluid rounded shadow" 
                                 onerror="this.src='https://via.placeholder.com/400x300/343a40/ffffff?text=Our+Canteen'">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Menu Section with Animation -->
<section class="w3l-form-12 bg-light" id="menu">
    <div class="form-12-content py-5">
        <div class="container py-lg-5 py-md-4">
            <div class="row mb-5">
                <div class="col-lg-4 column1 align-self animate__animated animate__fadeInLeft">
                    <h4 class="mb-4">We serve the best Indian and fusion food items in campus</h4>
                    <p>From North Indian thalis to South Indian dosas, from street food chaats to Indo-Chinese fusion - we have it all at affordable prices!</p>
                    
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-utensils me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-1">Freshly Prepared</h5>
                                <p class="mb-0 text-muted">Every dish made fresh daily</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-rupee-sign me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-1">Student Budget</h5>
                                <p class="mb-0 text-muted">Affordable prices for everyone</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <h5 class="mb-1">Quick Service</h5>
                                <p class="mb-0 text-muted">No long waits between classes</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8 column2 mt-lg-0 mt-sm-5 mt-4 animate__animated animate__fadeInRight">
                    <div class="row">
                        <!-- Food Item 1 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <div class="position-relative">
                                    <span class="badge-special">Bestseller</span>
                                    <img src="assets/images/butter-chicken.jpg" alt="Butter Chicken" 
                                         onerror="this.src='https://www.spiceroots.com/spiceroots/wp-content/uploads/2008/05/butterchicken-1024x682.jpg'">
                                </div>
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Butter Chicken</h5>
                                    <p class="food-card-desc">Tender chicken pieces in creamy tomato gravy</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹120</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Item 2 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <img src="assets/images/masala-dosa.jpg" alt="Masala Dosa" 
                                     onerror="this.src='https://vismaifood.com/storage/app/uploads/public/8b4/19e/427/thumb__700_0_0_0_auto.jpg'">
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Masala Dosa</h5>
                                    <p class="food-card-desc">Crispy rice crepe with spicy potato filling</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹80</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Item 3 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <div class="position-relative">
                                    <span class="badge-special">New</span>
                                    <img src="assets/images/paneer-tikka.jpg" alt="Paneer Tikka" 
                                         onerror="this.src='https://www.krumpli.co.uk/wp-content/uploads/2024/12/Paneer-Tikka-Kebabs-2-1200-735x735.jpg'">
                                </div>
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Paneer Tikka</h5>
                                    <p class="food-card-desc">Marinated cottage cheese chunks, grilled to perfection</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹150</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Item 4 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <img src="assets/images/chole-bhature.jpg" alt="Chole Bhature" 
                                     onerror="this.src='https://sitaramdiwanchand.com/blog/wp-content/uploads/2024/04/Image-1-1-1024x576.webp'">
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Chole Bhature</h5>
                                    <p class="food-card-desc">Spicy chickpea curry with fluffy fried bread</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹100</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Item 5 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <img src="assets/images/veg-biryani.jpg" alt="Veg Biryani" 
                                     onerror="this.src='https://media.istockphoto.com/id/179085494/photo/indian-biryani.jpg?s=612x612&w=0&k=20&c=VJAUfiuavFYB7PXwisvUhLqWFJ20-9m087-czUJp9Fs='">
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Veg Biryani</h5>
                                    <p class="food-card-desc">Fragrant rice cooked with vegetables and spices</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹90</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Food Item 6 -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="food-card">
                                <div class="position-relative">
                                    <span class="badge-special">Spicy</span>
                                    <img src="assets/images/chilli-chicken.jpg" alt="Chilli Chicken" 
                                         onerror="this.src='https://www.solara.in/cdn/shop/articles/How_to_Make_Chilli_Chicken_Best_Online_Recipe.png?v=1710761859&width=2048'">
                                </div>
                                <div class="food-card-body">
                                    <h5 class="food-card-title">Chilli Chicken</h5>
                                    <p class="food-card-desc">Indo-Chinese spicy chicken with bell peppers</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="food-card-price">₹130</span>
                                        <button class="btn-order">Order Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="menu.php" class="btn btn-lg btn-outline-dark">View Full Menu <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials py-5" id="testimonials">
    <div class="container py-lg-5 py-md-4">
        <div class="title-content text-center mb-5 animate__animated animate__fadeIn">
            <h6 class="sub-title">what they say</h6>
            <h3 class="title-big">Our Happy Customers</h3>
        </div>
        
        <div class="row">
            <!-- Testimonial 1 -->
            <div class="col-md-4 animate__animated animate__fadeInUp">
                <div class="testimonial-card">
                    <p>"The best butter chicken I've had in any college canteen. It reminds me of home-cooked food. Affordable and delicious!"</p>
                    <div class="customer-details">
                        <img src="images/1.jpg" alt="Aryan" class="customer-img" 
                             onerror="this.src=''">
                        <div>
                            <h5 class="customer-name">Aryan</h5>
                            <p class="customer-profession">B.Tech Student</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="testimonial-card">
                    <p>"I look forward to their masala dosa every Tuesday. The chutney is authentic South Indian style, just like my grandmother makes!"</p>
                    <div class="customer-details">
                        <img src="images/2.jpg" alt="Aarushi Sharma" class="customer-img" 
                             onerror="this.src=''">
                        <div>
                            <h5 class="customer-name">Aarushi Sharma</h5>
                            <p class="customer-profession">B.tech Student</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="col-md-4 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <div class="testimonial-card">
                    <p>"The staff is friendly and the food is always fresh. Their chai and samosa combo is my go-to snack during evening classes."</p>
                    <div class="customer-details">
                        <img src="assets/images/customer3.jpg" alt="Neha Patel" class="customer-img" 
                             onerror="this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrrif5P4osJwZNIy43k7G9F453aPo4Zn2G-w&s'">
                        <div>
                            <h5 class="customer-name">Aastha</h5>
                            <p class="customer-profession">B.tech Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Features Section -->
<section class="special-features py-5 bg-light">
    <div class="container py-lg-5 py-md-4">
        <div class="row align-items-center">
            <div class="col-lg-6 animate__animated animate__fadeInLeft">
                <h2 class="mb-4">Why Choose Our Canteen?</h2>
                
                <div class="d-flex mb-4">
                    <div class="feature-icon me-4">
                        <i class="fas fa-utensils" style="font-size: 2rem; color: var(--primary-color);"></i>
                    </div>
                    <div>
                        <h4>Authentic Indian Flavors</h4>
                        <p>We use traditional recipes and authentic spices to bring you the true taste of India.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="feature-icon me-4">
                        <i class="fas fa-rupee-sign" style="font-size: 2rem; color: var(--primary-color);"></i>
                    </div>
                    <div>
                        <h4>Student-Friendly Prices</h4>
                        <p>Enjoy quality food without burning a hole in your pocket. Most items under ₹100.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="feature-icon me-4">
                        <i class="fas fa-leaf" style="font-size: 2rem; color: var(--primary-color);"></i>
                    </div>
                    <div>
                        <h4>Fresh Ingredients</h4>
                        <p>We source our ingredients daily from local vendors to ensure freshness and quality.</p>
                    </div>
                </div>
                
                <div class="d-flex">
                    <div class="feature-icon me-4">
                        <i class="fas fa-mobile-alt" style="font-size: 2rem; color: var(--primary-color);"></i>
                    </div>
                    <div>
                        <h4>Quick Mobile Ordering</h4>
                        <p>Skip the line with our mobile app. Order in advance and pick up when ready.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mt-lg-0 mt-5 animate__animated animate__fadeInRight">
                <div class="position-relative">
                    <img src="assets/images/canteen-interior.jpg" alt="Our Canteen Interior" class="img-fluid rounded shadow-lg" 
                         onerror="this.src='https://www.touchbistro.com/wp-content/uploads/2021/09/commercial-kitchen-layout-design-for-restaurants-thumbnail.jpg'">
                    
                    <div class="position-absolute" style="bottom: -30px; right: -30px; z-index: -1;">
                        <img src="assets/images/pattern.svg" alt="" class="img-fluid" style="width: 200px; opacity: 0.2;"
                             onerror="this.src='https://via.placeholder.com/200x200/ff6b6b/ffffff?text=Pattern'">
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-6">
                        <div class="text-center p-4 bg-white rounded shadow-sm">
                            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">100+</h3>
                            <p class="mb-0">Food Items</p>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="text-center p-4 bg-white rounded shadow-sm">
                            <h3 class="fw-bold mb-0" style="color: var(--primary-color);">500+</h3>
                            <p class="mb-0">Happy Students</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);">
    <div class="container py-4">
        <div class="row align-items-center">
            <div class="col-lg-8 text-lg-start text-center mb-lg-0 mb-4">
                <h3 class="text-white mb-2">Hungry? We're Open Now!</h3>
                <p class="text-white mb-0">Visit our canteen in the main campus building or order online for pickup.</p>
            </div>
            <div class="col-lg-4 text-lg-end text-center">
                <a href="order.php" class="btn btn-light btn-lg pulse">Order Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include_once('footer.php'); ?>

<!-- Animation and JS Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
    // Initialize animations on scroll
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Magnific Popup for video
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
        
        // Animate on scroll
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate__animated');
            
            elements.forEach(function(element) {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.style.visibility = 'visible';
                    element.classList.add(element.classList[1]);
                }
            });
        };
        
        // Hide elements initially
        const elements = document.querySelectorAll('.animate__animated');
        elements.forEach(function(element) {
            element.style.visibility = 'hidden';
        });
        
        // Add scroll event listener
        window.addEventListener('scroll', animateOnScroll);
        
        // Trigger once on load
        animateOnScroll();
    });
</script>