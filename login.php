<?php
include("connection/connect.php"); 
session_start();
?>
<?php

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']); 

    if(!empty($username) && !empty($password)) {
        // Query without password hashing
        $loginquery = "SELECT * FROM users WHERE roll_no='$username' AND password='$password'";
        $result = mysqli_query($db, $loginquery);
        
        if ($result && mysqli_num_rows($result) > 0) { // Ensure the query returns data
            $row = mysqli_fetch_assoc($result);
            $arr = explode(' ', trim($row['student_name']));

            $_SESSION["user_id"] = $row['u_id'];
            $_SESSION["username"] = $row['roll_no'];
            $_SESSION["studentName"] = $arr[0];

            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please check and try again.');</script>";
        }
    } else {
        echo "<script>alert('Username and Password are required!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> College Canteen Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Orbitron:400,700|Montserrat:300,400,500,600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff6b35;
            --primary-dark: #e25a2c;
            --primary-glow: rgba(255, 107, 53, 0.4);
            --secondary-color: #4ecdc4;
            --accent-color: #ff9f1c;
            --accent-glow: rgba(255, 159, 28, 0.5);
            --success-color: #00cc66;
            --error-color: #ff3b30;
            --text-color: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --bg-dark: #1a2639;
            --bg-darker: #101725;
            --bg-semi: rgba(26, 38, 57, 0.8);
            --card-bg: rgba(27, 40, 62, 0.9);
            --border-light: rgba(255, 255, 255, 0.07);
            --shadow-color: rgba(0, 0, 0, 0.5);
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            background: var(--bg-dark);
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative;
            overflow-x: hidden;
            background: radial-gradient(ellipse at bottom, var(--bg-dark) 0%, var(--bg-darker) 80%);
        }

        /* Canvas for 3D effects */
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .login-wrapper {
            display: flex;
            width: 900px;
            max-width: 95%;
            height: 600px;
            max-height: 95vh;
            box-shadow: 0 15px 35px var(--shadow-color);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            z-index: 10;
            animation: wrapperReveal 1.2s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes wrapperReveal {
            0% { opacity: 0; transform: translateY(30px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.8), rgba(255, 159, 28, 0.6)), url('/api/placeholder/600/800') center/cover;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
            color: white;
        }

        .left-content {
            position: relative;
            z-index: 2;
            animation: fadeUpIn 1s ease 0.5s both;
        }

        @keyframes fadeUpIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            font-size: 60px;
            margin-bottom: 20px;
            color: white;
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .brand-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .brand-tagline {
            font-size: 16px;
            margin-bottom: 30px;
            opacity: 0.9;
            max-width: 280px;
            line-height: 1.5;
        }

        .features {
            margin-top: 40px;
            text-align: left;
            width: 100%;
            max-width: 280px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .feature-item:nth-child(1) { animation-delay: 0.8s; }
        .feature-item:nth-child(2) { animation-delay: 1s; }
        .feature-item:nth-child(3) { animation-delay: 1.2s; }

        .feature-icon {
            margin-right: 15px;
            font-size: 20px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            width: 36px;
            height: 36px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 14px;
            line-height: 1.4;
        }

        /* Floating elements */
        .floating-shape {
            position: absolute;
            width: 80px;
            height: 80px;
            opacity: 0.1;
            background: white;
            z-index: 1;
        }

        .shape1 {
            top: 10%;
            left: 10%;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            animation: float 8s ease-in-out infinite alternate;
        }

        .shape2 {
            bottom: 10%;
            right: 10%;
            width: 120px;
            height: 120px;
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation: float 12s ease-in-out infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(20px, 20px) rotate(10deg); }
        }

        .login-right {
            flex: 1;
            background: var(--card-bg);
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .login-right::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .form-header {
            margin-bottom: 40px;
            animation: fadeIn 0.8s ease both;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .welcome-text {
            font-size: 28px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .welcome-subtext {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.5;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
            animation: slideUp 0.5s ease-out both;
        }

        .form-group:nth-child(1) { animation-delay: 0.3s; }
        .form-group:nth-child(2) { animation-delay: 0.5s; }
        .form-group:nth-child(3) { animation-delay: 0.7s; }

        @keyframes slideUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .input-container {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 16px 16px 16px 45px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-light);
            color: var(--text-color);
            border-radius: 10px;
            outline: none;
            font-size: 15px;
            font-weight: 400;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--primary-glow);
        }

        input:focus + .input-icon {
            color: var(--primary-color);
        }

        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: var(--text-secondary);
            font-size: 13px;
            text-decoration: none;
            transition: 0.3s;
        }

        .forgot-password a:hover {
            color: var(--primary-color);
        }

        #buttn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 16px;
            border: none;
            width: 100%;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            animation: slideUp 0.5s ease-out 0.9s both;
        }

        #buttn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.6s;
        }

        #buttn:hover {
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            transform: translateY(-2px);
        }

        #buttn:hover::before {
            left: 100%;
        }

        #buttn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(255, 107, 53, 0.3);
        }

        .alternative-login {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            animation: fadeIn 0.5s ease 1.1s both;
        }

        .alt-login-btn {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid var(--border-light);
        }

        .alt-login-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            color: white;
        }

        .cta {
            text-align: center;
            margin-top: 30px;
            color: var(--text-secondary);
            font-size: 14px;
            animation: fadeIn 0.5s ease 1.3s both;
        }

        .cta a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            position: relative;
        }

        .cta a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .cta a:hover::after {
            width: 100%;
        }

        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            animation: messageSlide 0.5s ease;
        }

        @keyframes messageSlide {
            0% { transform: translateY(-20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .message i {
            margin-right: 10px;
            font-size: 16px;
        }

        .error-message {
            background: rgba(255, 59, 48, 0.1);
            color: var(--error-color);
            border-left: 3px solid var(--error-color);
        }

        .success-message {
            background: rgba(0, 204, 102, 0.1);
            color: var(--success-color);
            border-left: 3px solid var(--success-color);
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
            }
            
            .login-left {
                display: none;
            }
            
            .login-right {
                padding: 30px;
                width: 100%;
            }
            
            .welcome-text {
                font-size: 24px;
            }
        }

        /* Dark mode preference */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-dark: #1a2639;
                --bg-darker: #101725;
            }
        }
    </style>
</head>
<body>

<!-- Canvas for 3D background effect -->
<div id="canvas-container"></div>

<div class="login-wrapper">
    <!-- Left side - branding -->
    <div class="login-left">
        <div class="floating-shape shape1"></div>
        <div class="floating-shape shape2"></div>
        
        <div class="left-content">
            <div class="brand-logo">
                <i class="fas fa-utensils"></i>
            </div>
            <h1 class="brand-title">Mayuri</h1>
            <p class="brand-tagline">Your college canteen at your fingertips</p>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="feature-text">Order food from anywhere on campus</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-text">Skip the lines with advance ordering</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="feature-text">Special deals and loyalty rewards</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right side - login form -->
    <div class="login-right">
        <div class="form-header">
            <h2 class="welcome-text">Welcome back</h2>
            <p class="welcome-subtext">Please enter your credentials to access your account</p>
        </div>
        
        <?php if(!empty($message)) echo "<div class='message error-message'><i class='fas fa-exclamation-circle'></i> $message</div>"; ?>
        <?php if(!empty($success)) echo "<div class='message success-message'><i class='fas fa-check-circle'></i> $success</div>"; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-container">
                    <input type="text" id="username" name="username" placeholder="Enter your Reg No" required autocomplete="off">
                    <i class="fas fa-user input-icon"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-container">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-lock input-icon"></i>
                </div>
            </div>
            
            <div class="forgot-password">
            <a href="forgot_password.php">Forgot Password?</a>
            </div>
            
            <input type="submit" id="buttn" name="submit" value="SIGN IN">
            
            <div class="alternative-login">
                <div class="alt-login-btn">
                    <i class="fab fa-google"></i>
                </div>
                <div class="alt-login-btn">
                    <i class="fab fa-microsoft"></i>
                </div>
                <div class="alt-login-btn">
                    <i class="fab fa-apple"></i>
                </div>
            </div>
        </form>
        
        <div class="cta">
            Don't have an account?<a href="registration.php">Register now</a>
        </div>
    </div>
</div>

<!-- Three.js for 3D background effect -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
    // Initialize Three.js scene
    document.addEventListener('DOMContentLoaded', function() {
        // Canvas setup
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Camera position
        camera.position.z = 30;
        
        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 1500;
        
        const posArray = new Float32Array(particlesCount * 3);
        
        for(let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 100;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        // Materials
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.1,
            color: 0xff6b35,
            transparent: true,
            opacity: 0.8
        });
        
        // Mesh
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        // Mouse movement effect
        let mouseX = 0;
        let mouseY = 0;
        
        function onDocumentMouseMove(event) {
            mouseX = (event.clientX - window.innerWidth / 2) / 100;
            mouseY = (event.clientY - window.innerHeight / 2) / 100;
        }
        
        document.addEventListener('mousemove', onDocumentMouseMove);
        
        // Handle window resize
        window.addEventListener('resize', function() {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        // Animation loop
        function animate() {
            requestAnimationFrame(animate);
            
            particlesMesh.rotation.x += 0.0005;
            particlesMesh.rotation.y += 0.0005;
            
            // Follow mouse
            particlesMesh.rotation.x += mouseY * 0.0005;
            particlesMesh.rotation.y += mouseX * 0.0005;
            
            renderer.render(scene, camera);
        }
        
        animate();
    });
    
    // Form interactions
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
        
        inputs.forEach(input => {
            // Add focus animation
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            // Remove focus animation
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
</script>

</body>
</html>