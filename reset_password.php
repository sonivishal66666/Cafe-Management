<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #0f0f1a;
            color: #fff;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        #canvas-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        
        .container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: rgba(22, 22, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            transform: translateY(30px);
            opacity: 0;
            z-index: 10;
            border: 1px solid rgba(100, 100, 255, 0.2);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo i {
            font-size: 3em;
            color: #6366f1;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 15px 15px 50px;
            background: rgba(30, 30, 60, 0.6);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            outline: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(40, 40, 80, 0.8);
            box-shadow: 0 5px 20px rgba(99, 102, 241, 0.3);
        }
        
        .form-group i {
            position: absolute;
            left: 15px;
            top: 17px;
            color: #6366f1;
            font-size: 20px;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 17px;
            color: #a1a1aa;
            font-size: 18px;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #6366f1;
        }
        
        .password-strength {
            height: 5px;
            width: 100%;
            background: #3a3a5a;
            margin-top: 10px;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background-color 0.3s;
            border-radius: 5px;
        }
        
        .password-feedback {
            font-size: 12px;
            margin-top: 8px;
            color: #a1a1aa;
            transition: color 0.3s;
        }
        
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(99, 102, 241, 0.4);
        }
        
        .submit-btn::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }
        
        .submit-btn:active::after {
            width: 300px;
            height: 300px;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #a1a1aa;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: #6366f1;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background: rgba(22, 22, 42, 0.9);
            backdrop-filter: blur(10px);
            border-left: 4px solid #6366f1;
            border-radius: 5px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            transform: translateX(200%);
            transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 1000;
            max-width: 350px;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification-content {
            display: flex;
            align-items: center;
        }
        
        .notification-icon {
            margin-right: 15px;
            font-size: 20px;
            color: #6366f1;
        }
        
        .notification-text {
            flex: 1;
        }
        
        .notification h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .notification p {
            margin: 0;
            font-size: 14px;
            color: #a1a1aa;
        }
        
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px 20px;
            }
        }
        
        /* Loading animation */
        .loader {
            display: none;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            position: absolute;
            top: calc(50% - 12px);
            left: calc(50% - 12px);
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .success-checkmark {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        
        .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #6366f1;
        }
        
        .check-icon::before {
            top: 3px;
            left: -2px;
            width: 30px;
            transform-origin: 100% 50%;
            border-radius: 100px 0 0 100px;
        }
        
        .check-icon::after {
            top: 0;
            left: 30px;
            width: 60px;
            transform-origin: 0 50%;
            border-radius: 0 100px 100px 0;
            animation: rotate-circle 4.25s ease-in;
        }
        
        .check-icon::before, .check-icon::after {
            content: '';
            height: 100px;
            position: absolute;
            background: #0f0f1a;
            transform: rotate(-45deg);
        }
        
        .icon-line {
            height: 5px;
            background-color: #6366f1;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }
        
        .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s;
        }
        
        .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s;
        }
        
        .icon-circle {
            top: -4px;
            left: -4px;
            z-index: 10;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            position: absolute;
            box-sizing: content-box;
            border: 4px solid rgba(99, 102, 241, 0.5);
        }
        
        .icon-fix {
            top: 8px;
            width: 5px;
            left: 26px;
            z-index: 1;
            height: 85px;
            position: absolute;
            transform: rotate(-45deg);
            background-color: #0f0f1a;
        }
        
        @keyframes rotate-circle {
            0% {
                transform: rotate(-45deg);
            }
            5% {
                transform: rotate(-45deg);
            }
            12% {
                transform: rotate(-405deg);
            }
            100% {
                transform: rotate(-405deg);
            }
        }
        
        @keyframes icon-line-tip {
            0% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            54% {
                width: 0;
                left: 1px;
                top: 19px;
            }
            70% {
                width: 50px;
                left: -8px;
                top: 37px;
            }
            84% {
                width: 17px;
                left: 21px;
                top: 48px;
            }
            100% {
                width: 25px;
                left: 14px;
                top: 46px;
            }
        }
        
        @keyframes icon-line-long {
            0% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            65% {
                width: 0;
                right: 46px;
                top: 54px;
            }
            84% {
                width: 55px;
                right: 0px;
                top: 35px;
            }
            100% {
                width: 47px;
                right: 8px;
                top: 38px;
            }
        }
    </style>
</head>
<body>
    <div id="canvas-container"></div>
    
    <div class="container">
        <div class="logo">
            <i class="fas fa-key"></i>
        </div>
        
        <h1>Set New Password</h1>
        
        <form id="resetForm" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <input type="hidden" name="reset_token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Enter new password">
                <span class="password-toggle" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            
            <div class="password-strength">
                <div class="password-strength-bar" id="strengthBar"></div>
            </div>
            <div class="password-feedback" id="passwordFeedback">Password strength</div>
            
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-control" id="confirm_password" required placeholder="Confirm new password">
                <span class="password-toggle" id="toggleConfirmPassword">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            
            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-text">Reset Password</span>
                <span class="loader"></span>
            </button>
        </form>
        
        <a href="login.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>
    
    <div class="notification" id="notification">
        <div class="notification-content">
            <div class="notification-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="notification-text">
                <h3>Notification</h3>
                <p id="notification-message"></p>
            </div>
        </div>
    </div>
    
    <div class="success-checkmark" id="successCheck">
        <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
    </div>
    
    <script>
        // Initialize Three.js background
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Create 3D element - floating cubes
        const cubesGroup = new THREE.Group();
        scene.add(cubesGroup);
        
        for (let i = 0; i < 50; i++) {
            const geometry = new THREE.BoxGeometry(0.2, 0.2, 0.2);
            const material = new THREE.MeshBasicMaterial({ 
                color: 0x6366f1,
                transparent: true,
                opacity: Math.random() * 0.5 + 0.1
            });
            
            const cube = new THREE.Mesh(geometry, material);
            
            cube.position.x = (Math.random() - 0.5) * 10;
            cube.position.y = (Math.random() - 0.5) * 10;
            cube.position.z = (Math.random() - 0.5) * 10;
            
            cube.rotation.x = Math.random() * Math.PI;
            cube.rotation.y = Math.random() * Math.PI;
            
            // Store random rotation speed
            cube.userData = {
                rotationSpeed: {
                    x: (Math.random() - 0.5) * 0.01,
                    y: (Math.random() - 0.5) * 0.01
                }
            };
            
            cubesGroup.add(cube);
        }
        
        // Add particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 1000;
        
        const posArray = new Float32Array(particlesCount * 3);
        
        for (let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 10;
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.01,
            color: 0x8b5cf6,
            transparent: true,
            opacity: 0.5
        });
        
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        camera.position.z = 5;
        
        // Animation
        function animate() {
            requestAnimationFrame(animate);
            
            // Rotate cubes
            cubesGroup.children.forEach(cube => {
                cube.rotation.x += cube.userData.rotationSpeed.x;
                cube.rotation.y += cube.userData.rotationSpeed.y;
            });
            
            // Slowly rotate entire group
            cubesGroup.rotation.y += 0.001;
            
            // Rotate particles
            particlesMesh.rotation.x += 0.0005;
            particlesMesh.rotation.y += 0.0005;
            
            renderer.render(scene, camera);
        }
        
        animate();
        
        // Handle window resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        // Animate container on load
        window.addEventListener('load', () => {
            gsap.to('.container', {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out'
            });
        });
        
        // Mouse move effect
        document.addEventListener('mousemove', (event) => {
            const mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            const mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
            
            gsap.to(cubesGroup.rotation, {
                x: mouseY * 0.1,
                y: mouseX * 0.1,
                duration: 1
            });
        });
        
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
        
        // Password strength meter
        const strengthBar = document.getElementById('strengthBar');
        const passwordFeedback = document.getElementById('passwordFeedback');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let feedback = "";
            
            if (password.length > 0) {
                // Length check
                if (password.length >= 8) {
                    strength += 25;
                }
                
                // Contains lowercase
                if (/[a-z]/.test(password)) {
                    strength += 25;
                }
                
                // Contains uppercase
                if (/[A-Z]/.test(password)) {
                    strength += 25;
                }
                
                // Contains number or special char
                if (/[0-9!@#$%^&*]/.test(password)) {
                    strength += 25;
                }
                
                // Set strength bar color and width
                strengthBar.style.width = strength + '%';
                
                if (strength <= 25) {
                    strengthBar.style.backgroundColor = '#f87171';
                    feedback = "Weak password";
                } else if (strength <= 50) {
                    strengthBar.style.backgroundColor = '#fb923c';
                    feedback = "Fair password";
                } else if (strength <= 75) {
                    strengthBar.style.backgroundColor = '#facc15';
                    feedback = "Good password";
                } else {
                    strengthBar.style.backgroundColor = '#4ade80';
                    feedback = "Strong password";
                }
            } else {
                strengthBar.style.width = '0%';
                feedback = "Password strength";
            }
            
            passwordFeedback.textContent = feedback;
            passwordFeedback.style.color = strengthBar.style.backgroundColor;
        });
        
        // Form validation
        const resetForm = document.getElementById('resetForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const loader = submitBtn.querySelector('.loader');
        const successCheck = document.getElementById('successCheck');
        
        resetForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showNotification("Passwords do not match!");
                return;
            }
            
            // Show loading animation
            btnText.style.opacity = '0';
            loader.style.display = 'block';
            
            // This is just for visual effect - PHP will handle actual submission
        });
        
        // Show notification function
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            
            notificationMessage.textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
        
        // Success animation
        function showSuccessAnimation() {
            successCheck.style.display = 'block';
            
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        }
        
        <?php
        include("connection/connect.php"); // Include database connection
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $reset_token = mysqli_real_escape_string($db, $_POST['reset_token']);
            $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
        
            // Check if reset token is valid
            $query = "SELECT * FROM users WHERE email='$email' AND reset_token='$reset_token' LIMIT 1";
            $result = mysqli_query($db, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                // Update password without hashing
                $update_query = "UPDATE users SET password='$new_password', reset_token=NULL WHERE email='$email'";
                if (mysqli_query($db, $update_query)) {
                    // Using JavaScript to show success and redirect
                    echo "showSuccessAnimation();";
                    echo "setTimeout(function() { window.location.href = 'login.php'; }, 2000);";
                } else {
                    echo "showNotification('Error resetting password. Try again.');";
                }
            } else {
                echo "showNotification('Invalid or expired reset link.');";
            }
        }
        ?>
    </script>
</body>
</html>