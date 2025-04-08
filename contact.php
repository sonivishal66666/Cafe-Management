<?php
	include("connection/connect.php");

	error_reporting(0);
	session_start();

	// Improved form handling with validation and sanitization
	if(isset($_POST['submit'])) {
		// Sanitize input data to prevent SQL injection
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$message = mysqli_real_escape_string($db, $_POST['message']);
		
		// Input validation
		$errors = array();
		
		if(empty($name)) {
			$errors[] = "Name is required";
		}
		
		if(empty($email)) {
			$errors[] = "Email is required";
		} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Invalid email format";
		}
		
		if(empty($message)) {
			$errors[] = "Message is required";
		}
		
		// If no errors, proceed with form submission
		if(empty($errors)) {
			$sql = "INSERT INTO contact_us(name, email, message) VALUES ('$name', '$email', '$message')"; 
			$result = mysqli_query($db, $sql);
			
			if($result) {
				$success_message = "Your message has been sent successfully!";
			} else {
				$error_message = "Something went wrong. Please try again later.";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Your Company</title>
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS files -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom styles for this page -->
    <style>
        :root {
            --primary-color: #4A89DC;
            --secondary-color: #3D4852;
            --accent-color: #5D9CEC;
            --light-gray: #F8FAFC;
            --dark-gray: #3D4852;
            --text-color: #2D3748;
            --success-color: #38C172;
            --error-color: #E3342F;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: #fff;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
        }
        
        .section-title h6 {
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .section-title h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--dark-gray);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            bottom: -15px;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .contact-info-card {
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: white;
            margin-bottom: 30px;
            text-align: center;
            height: 100%;
        }
        
        .contact-info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .contact-info-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: inline-block;
        }
        
        .contact-info-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark-gray);
        }
        
        .contact-info-card p {
            color: #718096;
            margin-bottom: 5px;
        }
        
        .contact-info-card a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .contact-info-card a:hover {
            color: var(--primary-color);
        }
        
        .contact-form-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 50px;
        }
        
        .form-control {
            height: 52px;
            border: 1px solid #E2E8F0;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 400;
            color: var(--text-color);
            background-color: #F8FAFC;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 137, 220, 0.25);
        }
        
        textarea.form-control {
            height: 150px;
            resize: none;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--dark-gray);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(93, 156, 236, 0.4);
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 5px;
        }
        
        .map-container {
            height: 100%;
            min-height: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }
        
        #movetop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: var(--primary-color);
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 50%;
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            display: none;
        }
        
        #movetop:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .breadcrumb-wrapper {
            background-color: #F8FAFC;
            padding: 20px 0;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
        }
        
        .breadcrumb-item a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-item a:hover {
            color: var(--primary-color);
        }
        
        .breadcrumb-item.active {
            color: var(--primary-color);
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: '\f105';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: #CBD5E0;
            padding: 0 10px;
        }
        
        /* Animation classes */
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
        }
        
        .fade-in-left {
            animation: fadeInLeft 0.8s ease forwards;
            opacity: 0;
        }
        
        .fade-in-right {
            animation: fadeInRight 0.8s ease forwards;
            opacity: 0;
        }
        
        .delay-1 {
            animation-delay: 0.2s;
        }
        
        .delay-2 {
            animation-delay: 0.4s;
        }
        
        .delay-3 {
            animation-delay: 0.6s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Floating animation for icons */
        .floating {
            animation: floating 3s ease infinite;
            transform: translateY(0px);
        }
        
        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }
        
        /* Pulse animation for submit button */
        .pulse:hover {
            animation: pulse 1.5s ease infinite;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(74, 137, 220, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(74, 137, 220, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(74, 137, 220, 0);
            }
        }
    </style>
</head>

<body>
    <?php include_once('header.php'); ?>

    <!-- Breadcrumb Section -->
    <section class="breadcrumb-wrapper">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Contact</li>
            </ul>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5">
        <div class="container py-lg-5">
            <div class="text-center section-title fade-in-up">
                <h6>Contact Us</h6>
                <h3>Get in Touch With Us</h3>
                <p class="text-muted mx-auto" style="max-width: 600px;">We'd love to hear from you! Please feel free to contact us using the information below or fill out the contact form.</p>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-4 fade-in-left delay-1">
                    <div class="contact-info-card">
                        <i class="fas fa-map-marker-alt floating"></i>
                        <h4>Our Location</h4>
                        <p> VIT University </p>
                        <p>Bhopal</p>
                    </div>
                </div>
                
                <div class="col-md-4 fade-in-up delay-2">
                    <div class="contact-info-card">
                        <i class="fas fa-phone-alt floating"></i>
                        <h4>Call Us</h4>
                        <p><a href="tel:+123456789">+1 (123) 456-789</a></p>
                        <p><a href="tel:+987654321">+1 (987) 654-321</a></p>
                    </div>
                </div>
                
                <div class="col-md-4 fade-in-right delay-3">
                    <div class="contact-info-card">
                        <i class="fas fa-clock floating"></i>
                        <h4>Opening Hours</h4>
                        <p>Monday - Friday</p>
                        <p>9:00 AM - 10:00 PM</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-6 fade-in-left">
                    <div class="contact-form-wrapper">
                        <h4 class="mb-4">Send Us a Message</h4>
                        
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success animate__animated animate__fadeIn">
                                <i class="fas fa-check-circle mr-2"></i> <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger animate__animated animate__fadeIn">
                                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($errors)): ?>
                            <div class="alert alert-danger animate__animated animate__fadeIn">
                                <ul class="mb-0">
                                    <?php foreach($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form action="" method="post" class="contact-form" id="contactForm">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name*</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address*</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="form-label">Message*</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-primary pulse">
                                <i class="fas fa-paper-plane mr-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-6 mt-4 mt-lg-0 fade-in-right">
                    <div class="map-container">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1474523.6341175625!2d74.219195!3d23.473324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397cf08f7d5ecf65%3A0x72a1e2a77bc939d0!2sMadhya%20Pradesh%2C%20India!5e0!3m2!1sen!2sin!4v1708876234567!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
						</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section (Optional) -->
    <section class="faq-section py-5 bg-light">
        <div class="container py-lg-5">
            <div class="text-center section-title fade-in-up">
                <h6>FAQs</h6>
                <h3>Frequently Asked Questions</h3>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto fade-in-up">
                    <div class="accordion" id="faqAccordion">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header bg-white" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-dark font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fas fa-plus-circle mr-2 text-primary"></i> How can I place an order?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                                <div class="card-body">
                                    You can place an order through our website by browsing our menu, selecting your items, and proceeding to checkout. Alternatively, you can call our customer service number for assistance.
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header bg-white" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-dark font-weight-bold collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fas fa-plus-circle mr-2 text-primary"></i> What are your delivery areas?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                <div class="card-body">
                                    We currently deliver to most areas within the city limits. You can check if your location is within our delivery area by entering your address during checkout.
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header bg-white" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-dark font-weight-bold collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <i class="fas fa-plus-circle mr-2 text-primary"></i> How do I track my order?
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Once your order is confirmed, you'll receive a tracking link via email or SMS. You can use this link to track the status of your order in real-time.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once('footer.php'); ?>
    
    <!-- Back to Top Button -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- jQuery and Bootstrap JS -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <!-- Animation on scroll -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    
    <!-- Form validation -->
    <script>
        $(document).ready(function() {
            // Initialize WOW.js for scroll animations
            new WOW().init();
            
            // Form validation
            $("#contactForm").on("submit", function(e) {
                let isValid = true;
                const name = $("#name").val().trim();
                const email = $("#email").val().trim();
                const message = $("#message").val().trim();
                
                // Remove existing error messages
                $(".error-message").remove();
                
                // Validate name
                if (name === "") {
                    $("#name").after('<div class="error-message">Please enter your name</div>');
                    isValid = false;
                }
                
                // Validate email
                if (email === "") {
                    $("#email").after('<div class="error-message">Please enter your email</div>');
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    $("#email").after('<div class="error-message">Please enter a valid email</div>');
                    isValid = false;
                }
                
                // Validate message
                if (message === "") {
                    $("#message").after('<div class="error-message">Please enter your message</div>');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Add loading animation when form is submitted
                    $(this).find("button[type='submit']").html('<i class="fas fa-spinner fa-spin mr-2"></i> Sending...');
                }
            });
            
            // Email validation function
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            // Input animation
            $(".form-control").focus(function() {
                $(this).parent().addClass("focused");
            });
            
            $(".form-control").blur(function() {
                if ($(this).val() === "") {
                    $(this).parent().removeClass("focused");
                }
            });
            
            // Back to top button functionality
            $(window).scroll(function() {
                if ($(this).scrollTop() > 100) {
                    $('#movetop').fadeIn();
                } else {
                    $('#movetop').fadeOut();
                }
            });
            
            // FAQ accordion icon toggle
            $('.collapse').on('show.bs.collapse', function() {
                $(this).prev('.card-header').find('.fas').removeClass('fa-plus-circle').addClass('fa-minus-circle');
            }).on('hide.bs.collapse', function() {
                $(this).prev('.card-header').find('.fas').removeClass('fa-minus-circle').addClass('fa-plus-circle');
            });
            
            // Initialize animation for elements already in viewport
            animateElementsInViewport();
            
            // Check for elements entering viewport during scroll
            $(window).scroll(function() {
                animateElementsInViewport();
            });
            
            function animateElementsInViewport() {
                $('.fade-in-up, .fade-in-left, .fade-in-right').each(function() {
                    const elementTop = $(this).offset().top;
                    const elementHeight = $(this).height();
                    const windowHeight = $(window).height();
                    const scrollY = $(window).scrollTop();
                    
                    if (scrollY + windowHeight > elementTop + elementHeight / 4) {
                        $(this).css('opacity', '1');
                    }
                });
            }
        });
        
        // Back to top function
        function topFunction() {
            $('html, body').animate({scrollTop: 0}, 500);
        }
    </script>
</body>
</html>