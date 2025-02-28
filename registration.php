<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mayuri</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-color: #ff5f13;
            --dark-blue: #192440;
            --light-gray: #f5f5f5;
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --dark-bg: #121520;
            --dark-card: #1a1e2e;
            --dark-input: #232839;
            --dark-text: #e1e1e1;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #0c0e18;
            position: relative;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
            perspective: 1000px;
        }
        
        /* 3D Dark Background Effect */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(41, 50, 75, 0.2) 0%, transparent 80%),
                radial-gradient(circle at 80% 70%, rgba(28, 54, 83, 0.2) 0%, transparent 80%);
            z-index: -2;
        }
        
        /* Grid overlay for 3D effect */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(33, 39, 55, 0.3) 1px, transparent 1px),
                linear-gradient(90deg, rgba(33, 39, 55, 0.3) 1px, transparent 1px);
            background-size: 30px 30px;
            z-index: -1;
            transform-style: preserve-3d;
            transform: rotateX(80deg) translateZ(-100px) scale(3);
            opacity: 0.5;
            perspective-origin: center center;
        }
        
        /* Floating particles effect */
        .particle {
            position: fixed;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: rgba(255, 95, 19, 0.3);
            pointer-events: none;
            z-index: -1;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-wrap: wrap;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            background: rgba(26, 30, 46, 0.75); /* Reduced opacity and darker background */
            transform-style: preserve-3d;
            transform: translateZ(0);
            transition: transform 0.5s ease-out;
            z-index: 1;
        }
        
        .container:hover {
            transform: translateZ(10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }
        
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, #ff7e3b 100%);
            padding: 40px;
            color: var(--white);
            min-width: 300px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            transform-style: preserve-3d;
        }
        
        .left-panel::before, .left-panel::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }
        
        .left-panel::before {
            top: -150px;
            left: -100px;
            transform: translateZ(20px);
        }
        
        .left-panel::after {
            bottom: -150px;
            right: -100px;
            transform: translateZ(10px);
        }
        
        .branding {
            position: relative;
            z-index: 1;
            margin-bottom: 40px;
            transform-style: preserve-3d;
            transform: translateZ(30px);
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--white);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .tagline {
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        .features {
            list-style: none;
            position: relative;
            z-index: 1;
            text-align: left;
            width: 100%;
            transform-style: preserve-3d;
            transform: translateZ(15px);
        }
        
        .feature-item {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .feature-item:hover {
            transform: translateX(10px) translateZ(5px);
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .feature-text {
            flex-grow: 1;
        }
        
        .right-panel {
            flex: 1;
            background: var(--dark-card); /* Changed to dark background */
            padding: 40px;
            min-width: 320px;
            position: relative;
            z-index: 1;
            transform-style: preserve-3d;
            color: var(--dark-text); /* Light text for dark background */
        }
        
        .welcome-text {
            color: var(--dark-text); /* Updated text color for dark theme */
            margin-bottom: 30px;
            transform: translateZ(20px);
        }
        
        h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #a0a0a0; /* Lighter gray for subtitle in dark theme */
            font-size: 14px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            background-color: #f8d7da;
            color: #721c24;
            display: none;
            transform: translateZ(15px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert.show {
            display: block;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
            transform: translateZ(10px);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #444; /* Darker border for inputs */
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            background-color: var(--dark-input); /* Dark background for inputs */
            color: var(--dark-text); /* Light text for inputs */
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 95, 19, 0.2), 0 4px 8px rgba(0,0,0,0.1);
            outline: none;
            transform: translateZ(5px);
        }
        
        .form-control::placeholder {
            color: #888; /* Lighter placeholder text */
        }
        
        .form-icon {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #888; /* Updated icon color for dark theme */
            transition: color 0.3s ease;
        }
        
        .form-control:focus + .form-icon {
            color: var(--primary-color);
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .form-col {
            flex: 1;
            padding: 0 10px;
            min-width: 200px;
        }
        
        .btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 4px 10px rgba(255, 95, 19, 0.3);
            position: relative;
            overflow: hidden;
            transform: translateZ(20px);
        }
        
        .btn:hover {
            background: #e84c00;
            transform: translateY(-2px) translateZ(25px);
            box-shadow: 0 8px 15px rgba(232, 76, 0, 0.4);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .btn:hover::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .social-login {
            margin-top: 30px;
            text-align: center;
            transform: translateZ(10px);
        }
        
        .social-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 5px;
            background: #2a2e3f; /* Darker background for social buttons */
            color: #ddd; /* Lighter icon color for visibility */
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .social-btn:hover {
            transform: translateY(-3px) translateZ(5px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
        
        .google-btn {
            color: #DB4437;
        }
        
        .microsoft-btn {
            color: #00A4EF;
        }
        
        .apple-btn {
            color: #ffffff; /* Apple logo in white for dark theme */
        }
        
        .login-link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #a0a0a0; /* Updated text color for dark theme */
            transform: translateZ(5px);
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .login-link a:hover {
            text-decoration: underline;
            color: #e84c00;
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px) translateZ(0px); }
            50% { transform: translateY(-10px) translateZ(10px); }
            100% { transform: translateY(0px) translateZ(0px); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1) translateZ(0px); }
            50% { transform: scale(1.05) translateZ(5px); }
            100% { transform: scale(1) translateZ(0px); }
        }
        
        @keyframes particle-animation {
            0% {
                transform: translateY(0) translateZ(0);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateZ(50px);
                opacity: 0;
            }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .pulsing {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .left-panel {
                padding: 30px;
            }
            
            .right-panel {
                padding: 30px;
            }
            
            .grid-overlay {
                transform: rotateX(80deg) translateZ(-50px) scale(2);
            }
        }
    </style>
</head>
<body>
    <!-- 3D Grid Overlay -->
    <div class="grid-overlay"></div>
    
    <!-- Particles for 3D effect -->
    <div id="particles-container"></div>
    
    <div class="container animate__animated animate__fadeIn">
        <div class="left-panel">
            <div class="branding animate__animated animate__fadeInUp">
                <div class="logo-icon floating">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
                <h2 class="logo">Mayuri</h2>
                <p class="tagline">Your college canteen at your fingertips</p>
            </div>
            
            <ul class="features">
                <li class="feature-item animate__animated animate__fadeInLeft" style="animation-delay: 0.2s;">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Order food from anywhere on campus</h3>
                    </div>
                </li>
                <li class="feature-item animate__animated animate__fadeInLeft" style="animation-delay: 0.4s;">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Skip the lines with advance ordering</h3>
                    </div>
                </li>
                <li class="feature-item animate__animated animate__fadeInLeft" style="animation-delay: 0.6s;">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Special deals and loyalty rewards</h3>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="right-panel">
            <div class="welcome-text animate__animated animate__fadeInRight">
                <h1>Create an Account</h1>
                <p class="subtitle">Join the Campus Bites community today</p>
            </div>
            
            <?php if(!empty($message)): ?>
            <div class="alert animate__animated animate__shakeX show">
                <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
            </div>
            <?php endif; ?>
            
            <?php if(!empty($success)): ?>
            <div class="alert success animate__animated animate__fadeIn show">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <form action="" method="post" class="animate__animated animate__fadeInUp">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <input type="text" class="form-control" name="studentName" placeholder="Student Name">
                            <i class="fas fa-user form-icon"></i>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <input type="text" class="form-control" name="rollNo" placeholder="Roll No">
                            <i class="fas fa-id-card form-icon"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email Address">
                    <i class="fas fa-envelope form-icon"></i>
                </div>
                
                <div class="form-group">
                    <input type="tel" class="form-control" name="phone" placeholder="Phone Number">
                    <i class="fas fa-phone form-icon"></i>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <i class="fas fa-lock form-icon"></i>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password">
                            <i class="fas fa-lock form-icon"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="submit" class="btn pulsing">
                        <i class="fas fa-user-plus"></i> Register Now
                    </button>
                </div>
            </form>
            
            <div class="social-login animate__animated animate__fadeIn" style="animation-delay: 0.8s;">
                <p style="margin-bottom: 15px; color: #a0a0a0;">Or register with</p>
                <a href="#" class="social-btn google-btn">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-btn microsoft-btn">
                    <i class="fab fa-microsoft"></i>
                </a>
                <a href="#" class="social-btn apple-btn">
                    <i class="fab fa-apple"></i>
                </a>
            </div>
            
            <div class="login-link animate__animated animate__fadeIn" style="animation-delay: 1s;">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add animation to form fields when focused
            $('.form-control').focus(function() {
                $(this).parent().addClass('animate__animated animate__pulse');
            }).blur(function() {
                $(this).parent().removeClass('animate__animated animate__pulse');
            });
            
            // Animated entrance for form fields
            $('.form-group').each(function(index) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                });
                
                setTimeout(() => {
                    $(this).css({
                        'opacity': 1,
                        'transform': 'translateY(0)',
                        'transition': 'all 0.3s ease'
                    });
                }, 300 + (index * 100));
            });
            
            // Submit button hover effect
            $('.btn').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
            
            // Create particles for the 3D background
            function createParticles() {
                const particlesContainer = document.getElementById('particles-container');
                const particleCount = 50;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    
                    // Random position
                    const posX = Math.random() * window.innerWidth;
                    const posY = Math.random() * window.innerHeight;
                    
                    // Random size
                    const size = Math.random() * 3 + 1;
                    
                    // Random opacity
                    const opacity = Math.random() * 0.5 + 0.1;
                    
                    // Random animation duration
                    const duration = Math.random() * 15 + 10;
                    
                    // Apply styles
                    particle.style.left = posX + 'px';
                    particle.style.top = posY + 'px';
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';
                    particle.style.opacity = opacity;
                    particle.style.animation = `particle-animation ${duration}s linear infinite`;
                    particle.style.animationDelay = (Math.random() * 10) + 's';
                    
                    // Add to container
                    particlesContainer.appendChild(particle);
                }
            }
            
            createParticles();
            
            // Parallax effect on mousemove
            const container = document.querySelector('.container');
            document.addEventListener('mousemove', function(e) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;
                
                // Subtle container movement
                container.style.transform = `translateZ(0px) rotateX(${y * 2 - 1}deg) rotateY(${x * 2 - 1}deg)`;
                
                // Grid movement
                document.querySelector('.grid-overlay').style.transform = 
                    `rotateX(80deg) translateZ(-100px) scale(3) translateX(${x * 20 - 10}px) translateY(${y * 20 - 10}px)`;
            });
        });
    </script>
</body>
</html>