<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
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
        
        .notification-icon i {
            animation: bounce 1s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
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
        
        /* Email sent confirmation */
        .email-sent {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        
        .email-sent i {
            font-size: 50px;
            color: #10b981;
            margin-bottom: 15px;
            display: block;
            animation: scaleUp 0.5s ease-out;
        }
        
        @keyframes scaleUp {
            0% { transform: scale(0); }
            70% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .email-sent h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #fff;
        }
        
        .email-sent p {
            color: #a1a1aa;
            font-size: 14px;
            line-height: 1.5;
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
    </style>
</head>
<body>
    <div id="canvas-container"></div>
    
    <?php
    include("connection/connect.php"); // Include database connection
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'vendor/autoload.php'; // Load PHPMailer (if installed via Composer)
    
    $emailSent = false;
    $emailNotFound = false;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($db, $_POST['email']);
    
        // Check if user exists
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($result);
    
        if ($user) {
            $reset_token = bin2hex(random_bytes(32)); // Generate a secure reset token
    
            // Store reset token in the database
            $update_query = "UPDATE users SET reset_token='$reset_token' WHERE email='$email'";
            mysqli_query($db, $update_query);
    
            // Send Reset Email via SMTP
            $mail = new PHPMailer(true);
    
            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Change to your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'dcsoni6350@gmail.com'; // Your email
                $mail->Password = 'jpzt oaqy iiar ydow'; // Your email password or App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    
                // Email Content
                $mail->setFrom('dcsoni6350@gmail.com', 'Mayuri');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "Password Reset Request";
                $mail->Body = "Dear User,<br><br>
                    You have requested to reset your password. Click the link below:<br><br>
                    <a href='http://localhost:3000/Canteen_Management/reset_password.php?email=$email&token=$reset_token'>Reset Password</a><br><br>
                    This link is valid until you reset your password.<br><br>
                    Regards,<br>Team Mayuri";
    
                $mail->send();
                $emailSent = true;
            } catch (Exception $e) {
                // Email error will be handled by JavaScript notification
                $emailError = $mail->ErrorInfo;
            }
        } else {
            $emailNotFound = true;
        }
    }
    ?>
    
    <div class="container">
        <div class="logo">
            <i class="fas fa-unlock-alt"></i>
        </div>
        
        <h1>Reset Your Password</h1>
        
        <form id="resetForm" method="POST" style="<?php echo $emailSent ? 'display: none;' : ''; ?>">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" class="form-control" name="email" required placeholder="Enter your email">
            </div>
            
            <button type="submit" class="submit-btn">
                <span class="btn-text">Send Reset Link</span>
                <span class="loader"></span>
            </button>
        </form>
        
        <div class="email-sent" id="emailSent" style="<?php echo $emailSent ? 'display: block;' : 'display: none;'; ?>">
            <i class="fas fa-check-circle"></i>
            <h3>Check Your Email</h3>
            <p>We've sent a password reset link to your email address. Please check your inbox and spam folder.</p>
        </div>
        
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
    
    <script>
        // Initialize Three.js background
        const container = document.getElementById('canvas-container');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);
        container.appendChild(renderer.domElement);
        
        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 1000;
        
        const posArray = new Float32Array(particlesCount * 3);
        const scaleArray = new Float32Array(particlesCount);
        
        for (let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 10;
        }
        
        for (let i = 0; i < particlesCount; i++) {
            scaleArray[i] = Math.random();
        }
        
        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
        particlesGeometry.setAttribute('scale', new THREE.BufferAttribute(scaleArray, 1));
        
        // Create material
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.015,
            color: 0x6366f1,
            transparent: true,
            opacity: 0.8,
            sizeAttenuation: true
        });
        
        // Create mesh
        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        
        camera.position.z = 5;
        
        // Animation
        function animate() {
            requestAnimationFrame(animate);
            
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
        
        // Mouse move effect for particles
        document.addEventListener('mousemove', (event) => {
            const mouseX = (event.clientX / window.innerWidth) * 2 - 1;
            const mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
            
            gsap.to(particlesMesh.rotation, {
                x: mouseY * 0.1,
                y: mouseX * 0.1,
                duration: 1
            });
        });
        
        // Form submission with animation
        const resetForm = document.getElementById('resetForm');
        
        // Only set up the form handler if the form is visible (email not already sent)
        if (resetForm && resetForm.style.display !== 'none') {
            const submitBtn = resetForm.querySelector('.submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const loader = submitBtn.querySelector('.loader');
            
            resetForm.addEventListener('submit', function(e) {
                // Don't prevent default - we want the form to actually submit
                
                // Show loading animation
                btnText.style.opacity = '0';
                loader.style.display = 'block';
            });
        }
        
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
        
        // Show notifications based on PHP variables
        <?php if ($emailNotFound): ?>
            showNotification('No account found with this email address.');
        <?php endif; ?>
        
        <?php if (isset($emailError)): ?>
            showNotification('Error sending email: <?php echo $emailError; ?>');
        <?php endif; ?>
        
        <?php if ($emailSent): ?>
            showNotification('Password reset link has been sent to your email');
        <?php endif; ?>
    </script>
</body>
</html>