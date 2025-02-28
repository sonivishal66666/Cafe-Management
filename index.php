<?php include_once('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gourmet Delights - Restaurant</title>
  <link rel="stylesheet" href="assets/css/style-starter.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    /* Custom styles for enhanced sections */
    :root {
      --primary-color: #ff6b6b;
      --secondary-color: #4ecdc4;
      --dark-color: #2d3436;
      --light-color: #f9f9f9;
      --accent-color: #ffd166;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
    }
    
    h3, p {
      text-align: center;
    }
    
    /* Banner section enhancements */
    .w3l-banner {
      background: linear-gradient(135deg, rgba(255,107,107,0.1) 0%, rgba(78,205,196,0.1) 100%);
      position: relative;
      overflow: hidden;
    }
    
    .w3l-banner::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: url('assets/images/pattern.svg');
      opacity: 0.05;
      z-index: 0;
    }
    
    .banner-text {
      position: relative;
      z-index: 2;
    }
    
    .banner-text h5 {
      color: var(--primary-color);
      font-size: 1.5rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 1rem;
    }
    
    .banner-text h2 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 2rem;
      background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      line-height: 1.2;
    }
    
    .btn-order {
      padding: 12px 30px;
      border-radius: 50px;
      background: var(--primary-color);
      color: white;
      font-weight: 600;
      border: none;
      position: relative;
      overflow: hidden;
      z-index: 1;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
    }
    
    .btn-order:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 25px rgba(255, 107, 107, 0.4);
    }
    
    .btn-order::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: 0.5s;
      z-index: -1;
    }
    
    .btn-order:hover::before {
      left: 100%;
    }
    
    .banner-image-container {
      position: relative;
    }
    
    .floating {
      animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }
    
    /* About section */
    .about-heading {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      position: relative;
      display: inline-block;
    }
    
    .about-heading::after {
      content: '';
      position: absolute;
      width: 50px;
      height: 3px;
      background: var(--primary-color);
      bottom: -10px;
      left: 0;
    }
    
    .feature-card {
      background: white;
      border-radius: 15px;
      padding: 30px 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .feature-card::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
      bottom: 0;
      left: 0;
      transform: scaleX(0);
      transform-origin: left;
      transition: transform 0.3s ease;
      z-index: -1;
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .feature-card:hover::before {
      transform: scaleX(1);
    }
    
    .feature-icon {
      width: 80px;
      height: 80px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
    }
    
    .feature-card:hover .feature-icon {
      transform: rotate(10deg) scale(1.1);
    }
    
    .feature-title {
      font-weight: 600;
      margin-top: 1rem;
      font-size: 1.1rem;
      color: var(--dark-color);
      transition: all 0.3s ease;
    }
    
    .feature-card:hover .feature-title {
      color: var(--primary-color);
    }
    
    /* Food menu section */
    .w3l-food {
      background: var(--light-color);
      position: relative;
    }
    
    .w3l-food::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: url('assets/images/pattern-dots.svg');
      opacity: 0.05;
      z-index: 0;
    }
    
    .sub-title {
      color: var(--primary-color);
      font-size: 1.2rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 0.5rem;
    }
    
    .title-big {
      font-size: 2.8rem;
      font-weight: 700;
      margin-bottom: 2rem;
      position: relative;
      display: inline-block;
    }
    
    .title-big::after {
      content: '';
      position: absolute;
      width: 80px;
      height: 3px;
      background: var(--primary-color);
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
    }
    
    .food-card {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .food-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    
    .food-card::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      top: 0;
      left: 0;
      opacity: 0;
      z-index: -1;
      transition: opacity 0.3s ease;
    }
    
    .food-card:hover::before {
      opacity: 0.05;
    }
    
    .food-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }
    
    .food-card:hover .food-image {
      transform: scale(1.05);
      box-shadow: 0 15px 25px rgba(0,0,0,0.15);
    }
    
    .food-name {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--dark-color);
      margin: 1.5rem 0 0.5rem;
      transition: all 0.3s ease;
    }
    
    .food-card:hover .food-name {
      color: var(--primary-color);
    }
    
    .food-price {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--primary-color);
      margin: 1rem 0;
    }
    
    .btn-food-order {
      padding: 10px 25px;
      border-radius: 50px;
      background: var(--primary-color);
      color: white;
      font-weight: 600;
      border: none;
      position: relative;
      overflow: hidden;
      z-index: 1;
      transition: all 0.3s ease;
      box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
    }
    
    .btn-food-order:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 25px rgba(255, 107, 107, 0.4);
      background: var(--dark-color);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      .banner-text h2 {
        font-size: 2.5rem;
      }
      
      .about-heading {
        font-size: 2rem;
      }
      
      .title-big {
        font-size: 2.2rem;
      }
    }
    
    @media (max-width: 768px) {
      .banner-text h2 {
        font-size: 2rem;
      }
      
      .feature-card {
        margin-bottom: 1.5rem;
      }
      
      .about-heading {
        font-size: 1.8rem;
      }
      
      .title-big {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>

  <!-- Banner Section -->
  <section class="w3l-banner" id="banner">
    <div class="new-block py-5">
      <div class="container">
        <div class="row middle-section align-items-center">
          <div class="col-lg-7 banner-text" data-aos="fade-right" data-aos-duration="1200">
            <h5 class="animate__animated animate__fadeInDown">Eat tasty dish everyday</h5>
            <h2 class="animate__animated animate__fadeInUp animate__delay-1s">Share your love about food</h2>
            <a href="menu.php" class="btn btn-order animate__animated animate__fadeInUp animate__delay-2s">
              <span class="fa fa-shopping-cart mr-2"></span> Order Online
            </a>
          </div>
          <div class="col-lg-5 banner-image-container mt-lg-0 mt-5 pt-lg-0 pt-md-4" data-aos="fade-left" data-aos-duration="1200">
            <img src="assets/images/main_3-.png" class="img-fluid floating" alt="Delicious food">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="w3l-about py-5">
    <div class="container py-lg-5 py-md-4">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000">
          <h3 class="about-heading">We make the Best Food in your College</h3>
          <h5 class="mt-lg-3 mt-2">Best food in budget and you can get it fresh and hot.</h5>
          <a href="about.php" class="btn-style btn-primary btn mt-lg-5 mt-4 btn-order">Know more about us</a>
        </div>
        <div class="col-lg-6 mt-lg-0 mt-5">
          <div class="row">
            <div class="col-md-6 col-sm-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
              <div class="feature-card">
                <img src="assets/images/pizza.png" alt="Pizza" class="feature-icon">
                <h4 class="feature-title">Right food baked with natural ingredients</h4>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
              <div class="feature-card">
                <img src="assets/images/burger.png" alt="Burger" class="feature-icon">
                <h4 class="feature-title">The use of natural best quality products</h4>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
              <div class="feature-card">
                <img src="assets/images/drink.png" alt="Drink" class="feature-icon">
                <h4 class="feature-title">World's best Chef and Nutritionist!</h4>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
              <div class="feature-card">
                <img src="assets/images/fries.png" alt="Fries" class="feature-icon">
                <h4 class="feature-title">Fastest order prepared and easy pick-up</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Food Menu Section -->
  <section class="w3l-food" id="food">
    <div class="foods1 py-5">
      <div class="container py-lg-5 py-md-4">
        <div class="title-content text-center" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="sub-title animate__animated animate__fadeInUp">Special Item</h6>
          <h3 class="title-big animate__animated animate__fadeInUp animate__delay-1s">Dish Of The Day</h3>
        </div>
        <div class="foods1-content mt-lg-5 mt-4 mb-sm-0 mb-4">
          <div class="row">
            <?php 
              $query_res= mysqli_query($db,"SELECT * FROM dishes where in_today_menu='1' LIMIT 4"); 
              while($product=mysqli_fetch_array($query_res))
              {
            ?>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="<?php echo $counter * 200; ?>">
              <div class="food-card text-center">
                <?php echo '<img src="admin/Category_Image/dishes/'.$product['img'].'" alt="'.$product['title'].'" class="food-image">'; ?>
                <h4 class="food-name"><?php echo $product['title']; ?></h4>
                <p class="mb-3"><?php echo $product['slogan']; ?></p>
                <h5 class="food-price">₹ <?php echo $product['price']; ?></h5>
                <a href="dishes.php?c_id=<?php echo $product['c_id']; ?>&action=add1&id=<?php echo $product['d_id']; ?>" class="btn-food-order mt-3">
                  <i class="fas fa-shopping-basket mr-2"></i> Order Now
                </a>
              </div>
            </div>
            <?php
                $counter++;
              }					
            ?>
          </div>
          
          <div class="text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
            <a href="menu.php" class="btn-order btn-lg">
              <i class="fas fa-utensils mr-2"></i> View Full Menu
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Add your footer here -->

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    // Initialize AOS animation
    AOS.init({
      once: false,
      mirror: true,
      offset: 120,
      easing: 'ease-out-quad'
    });
    
    // Add scroll animations
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      
      // Fade in elements on scroll
      $('.fade-in').each(function() {
        var position = $(this).offset().top;
        
        if (position < scroll + $(window).height() - 100) {
          $(this).addClass('active');
        }
      });
    });
    
    // Add hover effects for buttons
    $('.btn-order, .btn-food-order').hover(
      function() {
        $(this).addClass('pulse');
      },
      function() {
        $(this).removeClass('pulse');
      }
    );
    
    // Add counter animation for special items display
    $('.count-number').each(function() {
      $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
      }, {
        duration: 3000,
        easing: 'swing',
        step: function(now) {
          $(this).text(Math.ceil(now));
        }
      });
    });
  </script>
   <!-- How it works block starts -->
   <section class="how-it-works">
            <div class="container">
                <div class="text-xs-center">
                    <h2 style="text-align: center;">Easy 3 Step Order</h2>
                    <!-- 3 block sections starts -->
                    <div class="row how-it-works-solution">
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col1">
                            <div class="how-it-works-wrap">
                                <div class="step step-1">
                                    <div class="icon" data-step="1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 483 483" width="512" height="512">
                                            <g fill="#FFF">
                                                <path d="M467.006 177.92c-.055-1.573-.469-3.321-1.233-4.755L407.006 62.877V10.5c0-5.799-4.701-10.5-10.5-10.5h-310c-5.799 0-10.5 4.701-10.5 10.5v52.375L17.228 173.164a10.476 10.476 0 0 0-1.22 4.938h-.014V472.5c0 5.799 4.701 10.5 10.5 10.5h430.012c5.799 0 10.5-4.701 10.5-10.5V177.92zM282.379 76l18.007 91.602H182.583L200.445 76h81.934zm19.391 112.602c-4.964 29.003-30.096 51.143-60.281 51.143-30.173 0-55.295-22.139-60.258-51.143H301.77zm143.331 0c-4.96 29.003-30.075 51.143-60.237 51.143-30.185 0-55.317-22.139-60.281-51.143h120.518zm-123.314-21L303.78 76h86.423l48.81 91.602H321.787zM97.006 55V21h289v34h-289zm-4.198 21h86.243l-17.863 91.602h-117.2L92.808 76zm65.582 112.602c-5.028 28.475-30.113 50.19-60.229 50.19s-55.201-21.715-60.23-50.19H158.39zM300 462H183V306h117v156zm21 0V295.5c0-5.799-4.701-10.5-10.5-10.5h-138c-5.799 0-10.5 4.701-10.5 10.5V462H36.994V232.743a82.558 82.558 0 0 0 3.101 3.255c15.485 15.344 36.106 23.794 58.065 23.794s42.58-8.45 58.065-23.794a81.625 81.625 0 0 0 13.525-17.672c14.067 25.281 40.944 42.418 71.737 42.418 30.752 0 57.597-17.081 71.688-42.294 14.091 25.213 40.936 42.294 71.688 42.294 24.262 0 46.092-10.645 61.143-27.528V462H321z" />
                                                <path d="M202.494 386h22c5.799 0 10.5-4.701 10.5-10.5s-4.701-10.5-10.5-10.5h-22c-5.799 0-10.5 4.701-10.5 10.5s4.701 10.5 10.5 10.5z" /> </g>
                                        </svg>
                                    </div>
                                    <h3>Choose Your Tasty Dish</h3>
                                    <p>We"ve provide best food in collage hours.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col2">
                            <div class="step step-2">
                                <div class="icon" data-step="2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 380.721 380.721">
                                        <g fill="#FFF">
                                            <path d="M58.727 281.236c.32-5.217.657-10.457 1.319-15.709 1.261-12.525 3.974-25.05 6.733-37.296a543.51 543.51 0 0 1 5.449-17.997c2.463-5.729 4.868-11.433 7.25-17.01 5.438-10.898 11.491-21.07 18.724-29.593 1.737-2.19 3.427-4.328 5.095-6.46 1.912-1.894 3.805-3.747 5.676-5.588 3.863-3.509 7.221-7.273 11.107-10.091 7.686-5.711 14.529-11.137 21.477-14.506 6.698-3.724 12.455-6.982 17.631-8.812 10.125-4.084 15.883-6.141 15.883-6.141s-4.915 3.893-13.502 10.207c-4.449 2.917-9.114 7.488-14.721 12.147-5.803 4.461-11.107 10.84-17.358 16.992-3.149 3.114-5.588 7.064-8.551 10.684-1.452 1.83-2.928 3.712-4.427 5.6a1225.858 1225.858 0 0 1-3.84 6.286c-5.537 8.208-9.673 17.858-13.995 27.664-1.748 5.1-3.566 10.283-5.391 15.534a371.593 371.593 0 0 1-4.16 16.476c-2.266 11.271-4.502 22.761-5.438 34.612-.68 4.287-1.022 8.633-1.383 12.979 94 .023 166.775.069 268.589.069.337-4.462.534-8.97.534-13.536 0-85.746-62.509-156.352-142.875-165.705 5.17-4.869 8.436-11.758 8.436-19.433-.023-14.692-11.921-26.612-26.631-26.612-14.715 0-26.652 11.92-26.652 26.642 0 7.668 3.265 14.558 8.464 19.426-80.396 9.353-142.869 79.96-142.869 165.706 0 4.543.168 9.027.5 13.467 9.935-.002 19.526-.002 28.926-.002zM0 291.135h380.721v33.59H0z" /> </g>
                                    </svg>
                                </div>
                                <h3>Place Order And Select Pick Up Time</h3>
                                <p>We"ve provide facility of online food ordering and choose time to order collect.</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 how-it-works-steps white-txt col3">
                            <div class="step step-3">
                                <div class="icon" data-step="3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewbox="0 0 612.001 612">
                                        <path d="M604.131 440.17h-19.12V333.237c0-12.512-3.776-24.787-10.78-35.173l-47.92-70.975a62.99 62.99 0 0 0-52.169-27.698h-74.28c-8.734 0-15.737 7.082-15.737 15.738v225.043h-121.65c11.567 9.992 19.514 23.92 21.796 39.658H412.53c4.563-31.238 31.475-55.396 63.972-55.396 32.498 0 59.33 24.158 63.895 55.396h63.735c4.328 0 7.869-3.541 7.869-7.869V448.04c-.001-4.327-3.541-7.87-7.87-7.87zM525.76 312.227h-98.044a7.842 7.842 0 0 1-7.868-7.869v-54.372c0-4.328 3.541-7.869 7.868-7.869h59.724c2.597 0 4.957 1.259 6.452 3.305l38.32 54.451c3.619 5.194-.079 12.354-6.452 12.354zM476.502 440.17c-27.068 0-48.943 21.953-48.943 49.021 0 26.99 21.875 48.943 48.943 48.943 26.989 0 48.943-21.953 48.943-48.943 0-27.066-21.954-49.021-48.943-49.021zm0 73.495c-13.535 0-24.472-11.016-24.472-24.471 0-13.535 10.937-24.473 24.472-24.473 13.533 0 24.472 10.938 24.472 24.473 0 13.455-10.938 24.471-24.472 24.471zM68.434 440.17c-4.328 0-7.869 3.543-7.869 7.869v23.922c0 4.328 3.541 7.869 7.869 7.869h87.971c2.282-15.738 10.229-29.666 21.718-39.658H68.434v-.002zm151.864 0c-26.989 0-48.943 21.953-48.943 49.021 0 26.99 21.954 48.943 48.943 48.943 27.068 0 48.943-21.953 48.943-48.943.001-27.066-21.874-49.021-48.943-49.021zm0 73.495c-13.534 0-24.471-11.016-24.471-24.471 0-13.535 10.937-24.473 24.471-24.473s24.472 10.938 24.472 24.473c0 13.455-10.938 24.471-24.472 24.471zm117.716-363.06h-91.198c4.485 13.298 6.846 27.54 6.846 42.255 0 74.28-60.431 134.711-134.711 134.711-13.535 0-26.675-2.045-39.029-5.744v86.949c0 4.328 3.541 7.869 7.869 7.869h265.96c4.329 0 7.869-3.541 7.869-7.869V174.211c-.001-13.062-10.545-23.606-23.606-23.606zM118.969 73.866C53.264 73.866 0 127.129 0 192.834s53.264 118.969 118.969 118.969 118.97-53.264 118.97-118.969-53.265-118.968-118.97-118.968zm0 210.864c-50.752 0-91.896-41.143-91.896-91.896s41.144-91.896 91.896-91.896c50.753 0 91.896 41.144 91.896 91.896 0 50.753-41.143 91.896-91.896 91.896zm35.097-72.488c-1.014 0-2.052-.131-3.082-.407L112.641 201.5a11.808 11.808 0 0 1-8.729-11.396v-59.015c0-6.516 5.287-11.803 11.803-11.803 6.516 0 11.803 5.287 11.803 11.803v49.971l29.614 7.983c6.294 1.698 10.02 8.177 8.322 14.469-1.421 5.264-6.185 8.73-11.388 8.73z" fill="#FFF" /> </svg>
                                </div>
                                <h3>Pick up Food</h3>
                                <p>Collect your food! And enjoy your meal! Pay online on pickup or Cash on delivery</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3 block sections ends -->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p class="pay-info">Pay by Online Or Cash on delivery</p>
                    </div>
                </div>
            </div>
        </section>            
        <div class="chilly"></div>

        <!-- How it works block ends -->
<!-- Enhanced Food Gallery Section with Animations -->
<section class="food-gallery py-5" id="gallery">
  <div class="container py-lg-5 py-md-4">
    <!-- Section Header with Animation -->
    <div class="gallery-header text-center mb-5">
      <h2 class="title-big mb-4 mt-2" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Culinary Masterpieces</h2>
      <p class="text-muted mx-auto" style="max-width: 600px;" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
        Explore our exquisite food collection, prepared with passion and presented with perfection.
      </p>
    </div>

    <!-- Filter Buttons -->
    <div class="gallery-filter text-center mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
      <button class="filter-btn active" data-filter="all">All Items</button>
      <button class="filter-btn" data-filter="breakfast">Breakfast</button>
      <button class="filter-btn" data-filter="main">Main Course</button>
      <button class="filter-btn" data-filter="dessert">Desserts</button>
      <button class="filter-btn" data-filter="drinks">Beverages</button>
    </div>

    <!-- Gallery Grid with Animations -->
    <div class="gallery-grid" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
      <div class="gallery-item breakfast" data-category="breakfast">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image11.jpg" alt="Breakfast Delights" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>Breakfast Delights</h4>
                <p>Start your day with our nutritious options</p>
                <a href="assets/images/image11.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="Breakfast Delights">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item main" data-category="main">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image2.jpg" alt="Artisan Pizza" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>Artisan Pizza</h4>
                <p>Hand-crafted with premium ingredients</p>
                <a href="assets/images/image2.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="Artisan Pizza">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item main" data-category="main">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image1.jpg" alt="Gourmet Burgers" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>Gourmet Burgers</h4>
                <p>Juicy and flavorful signature creations</p>
                <a href="assets/images/image1.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="Gourmet Burgers">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item main" data-category="main">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image4.jpg" alt="South Indian Cuisine" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>South Indian Cuisine</h4>
                <p>Authentic flavors from the south</p>
                <a href="assets/images/image4.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="South Indian Cuisine">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item main" data-category="main">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image3.jpg" alt="Chinese Delicacies" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>Chinese Delicacies</h4>
                <p>Bold flavors and traditional recipes</p>
                <a href="assets/images/image3.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="Chinese Delicacies">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-item main" data-category="main">
        <div class="gallery-box">
          <div class="gallery-img">
            <img src="assets/images/image5.jpg" alt="Punjabi Feast" class="img-fluid" loading="lazy">
            <div class="overlay">
              <div class="overlay-content">
                <h4>Punjabi Feast</h4>
                <p>Rich and aromatic northern delights</p>
                <a href="assets/images/image5.jpg" class="zoom-gallery" data-lightbox="food-gallery" data-title="Punjabi Feast">
                  <i class="fas fa-search-plus"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- View More Button with Animation -->
    <div class="text-center mt-5" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
      <a href="#" class="btn btn-primary btn-style">View Full Menu</a>
    </div>
  </div>
</section>

<!-- Required CSS for the enhanced gallery (add to your CSS file) -->
<style>
  /* Gallery Section Styling */
  .food-gallery {
    background-color: #fcfcfc;
    position: relative;
    overflow: hidden;
  }

  .food-gallery::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('assets/images/pattern-bg.png');
    opacity: 0.03;
    pointer-events: none;
  }

  /* Section Title Styling */
  .sub-title {
    color: #ff6b00;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 16px;
    margin-bottom: 10px;
    padding-bottom: 10px;
  }

  .sub-title::after {
    content: '';
    width: 50px;
    height: 2px;
    background: #ff6b00;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
  }

  .title-big {
    font-size: 42px;
    font-weight: 700;
    color: #232323;
  }

  /* Filter Buttons */
  .gallery-filter {
    margin-bottom: 30px;
  }

  .filter-btn {
    background: transparent;
    border: 2px solid #eee;
    padding: 8px 20px;
    margin: 0 5px 10px;
    border-radius: 30px;
    color: #555;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .filter-btn:hover, .filter-btn.active {
    background: #ff6b00;
    border-color: #ff6b00;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 107, 0, 0.2);
  }

  /* Gallery Grid */
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    grid-gap: 20px;
    margin-top: 30px;
  }

  /* Gallery Items */
  .gallery-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: #fff;
    height: 100%;
  }

  .gallery-box:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  }

  .gallery-img {
    position: relative;
    overflow: hidden;
    transition: all 0.4s ease;
  }

  .gallery-img img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  .gallery-box:hover .gallery-img img {
    transform: scale(1.1);
  }

  /* Overlay Styling */
  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
  }

  .gallery-box:hover .overlay {
    opacity: 1;
  }

  .overlay-content {
    text-align: center;
    padding: 20px;
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.4s 0.1s ease;
    color: white;
  }

  .gallery-box:hover .overlay-content {
    transform: translateY(0);
    opacity: 1;
  }

  .overlay-content h4 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
    color: white;
  }

  .overlay-content p {
    font-size: 14px;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.8);
  }

  .zoom-gallery {
    display: inline-block;
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50%;
    background: #ff6b00;
    color: white;
    text-align: center;
    transition: all 0.3s ease;
  }

  .zoom-gallery:hover {
    transform: scale(1.1);
    background: white;
    color: #ff6b00;
  }

  /* Button Styling */
  .btn-style {
    padding: 12px 35px;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    border-radius: 30px;
    background: #ff6b00;
    border-color: #ff6b00;
  }

  .btn-style:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(255, 107, 0, 0.2);
    background: #e55f00;
    border-color: #e55f00;
  }

  /* Responsive adjustments */
  @media (max-width: 991px) {
    .title-big {
      font-size: 36px;
    }
    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
  }

  @media (max-width: 768px) {
    .title-big {
      font-size: 32px;
    }
    .gallery-grid {
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
  }

  /* Animation for items appearing with delay */
  .gallery-item {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease;
  }

  .gallery-item.show {
    opacity: 1;
    transform: translateY(0);
  }

  /* Animation for filtered items */
  .gallery-item.hide {
    display: none;
  }
</style>

<!-- Required JavaScript for animations and functionality (add before closing body tag) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS animation library
    AOS.init();

    // Show gallery items with sequential animation
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach((item, index) => {
      setTimeout(() => {
        item.classList.add('show');
      }, 100 * index);
    });

    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        // Get filter value
        const filterValue = this.getAttribute('data-filter');
        
        // Filter items
        galleryItems.forEach(item => {
          if(filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
            item.classList.remove('hide');
            setTimeout(() => {
              item.classList.add('show');
            }, 100);
          } else {
            item.classList.add('hide');
            item.classList.remove('show');
          }
        });
      });
    });

    // Enhanced lightbox settings
    lightbox.option({
      'resizeDuration': 300,
      'wrapAround': true,
      'albumLabel': "Image %1 of %2",
      'fadeDuration': 300,
      'showImageNumberLabel': true
    });

    // Parallax effect for background
    window.addEventListener('scroll', function() {
      const scrollPosition = window.pageYOffset;
      const gallerySection = document.querySelector('.food-gallery');
      
      if (gallerySection) {
        const rect = gallerySection.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          gallerySection.style.backgroundPosition = `center ${scrollPosition * 0.04}px`;
        }
      }
    });

    // Hover effect for gallery items
    galleryItems.forEach(item => {
      item.addEventListener('mouseenter', function() {
        this.querySelector('.gallery-img').style.transform = 'scale(1.02)';
      });
      
      item.addEventListener('mouseleave', function() {
        this.querySelector('.gallery-img').style.transform = 'scale(1)';
      });
    });
  });
</script>
  <!-- footers 20 -->
  <?php include_once('footer.php'); ?>
  
  
  <!-- move top -->
  <button onclick="topFunction()" id="movetop" title="Go to top">
  	&#10548;
  </button>
  <script>
  	// When the user scrolls down 20px from the top of the document, show the button
  	window.onscroll = function () {
  		scrollFunction()
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
  </script>
  <!-- /move top -->
  </section>

  <!-- jQuery and Bootstrap JS -->
  <script src="assets/js/jquery-3.3.1.min.js"></script>

  <!-- libhtbox -->
  <script src="assets/js/lightbox-plus-jquery.min.js"></script>


  <script src="assets/js/jquery.magnific-popup.min.js"></script>

  <script src="assets/js/counter.js"></script>
  <script>
  	$(document).ready(function () {
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

  		$('.popup-with-move-anim').magnificPopup({
  			type: 'inline',

  			fixedContentPos: false,
  			fixedBgPos: true,

  			overflowY: 'auto',

  			closeBtnInside: true,
  			preloader: false,

  			midClick: true,
  			removalDelay: 300,
  			mainClass: 'my-mfp-slide-bottom'
  		});
  	});
  </script>

  <!-- testimonials owlcarousel -->
  <script src="assets/js/owl.carousel.js"></script>
  <script>
  	$(document).ready(function () {
  		$('.owl-two').owlCarousel({
  			loop: true,
  			margin: 30,
  			nav: false,
  			responsiveClass: true,
  			autoplay: false,
  			autoplayTimeout: 5000,
  			autoplaySpeed: 1000,
  			autoplayHoverPause: false,
  			responsive: {
  				0: {
  					items: 1,
  					nav: false
  				},
  				480: {
  					items: 1,
  					nav: false
  				},
  				667: {
  					items: 1,
  					nav: false
  				},
  				1000: {
  					items: 1,
  					nav: false
  				}
  			}
  		})
  	})
  </script>
  <!-- //script for Testimonials-->

  <!-- script for food-->
  <script>
  	$(document).ready(function () {
  		$('.owl-carousel').owlCarousel({
  			loop: true,
  			margin: 0,
  			responsiveClass: true,
  			responsive: {
  				0: {
  					items: 1,
  					nav: true
  				},
  				480: {
  					items: 2,
  					nav: true,
  					margin: 20
  				},
  				769: {
  					items: 3,
  					nav: true,
  					margin: 20
  				},
  				1280: {
  					items: 4,
  					nav: true,
  					loop: true,
  					margin: 25
  				}
  			}
  		})
  	})
  </script>
  <!-- //script for food-->

  <!-- disable body scroll which navbar is in active -->
  <script>
  	$(function () {
  		$('.navbar-toggler').click(function () {
  			$('body').toggleClass('noscroll');
  		})
  	});
  </script>
  <!-- disable body scroll which navbar is in active -->
  <!--/MENU-JS-->
  <script>
  	$(window).on("scroll", function () {
  		var scroll = $(window).scrollTop();

  		if (scroll >= 80) {
  			$("#site-header").addClass("nav-fixed");
  		} else {
  			$("#site-header").removeClass("nav-fixed");
  		}
  	});

  	//Main navigation Active Class Add Remove
  	$(".navbar-toggler").on("click", function () {
  		$("header").toggleClass("active");
  	});
  	$(document).on("ready", function () {
  		if ($(window).width() > 991) {
  			$("header").removeClass("active");
  		}
  		$(window).on("resize", function () {
  			if ($(window).width() > 991) {
  				$("header").removeClass("active");
  			}
  		});
  	});
  </script>
  <!--//MENU-JS-->
  <script src="assets/js/bootstrap.min.js"></script>

  </body>

  </html>