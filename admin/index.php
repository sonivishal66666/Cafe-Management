<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

// Login form processing
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(!empty($_POST["submit"])) {
        $loginquery = "SELECT * FROM admin WHERE username='$username' && password='".md5($password)."'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);
    
        if(is_array($row)) {
            $_SESSION["adm_id"] = $row['adm_id'];
            // Using JavaScript for animation and then redirect
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelector('.login-success').style.display = 'flex';
                });
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 1500);
            </script>";
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}

// Registration form processing
if(isset($_POST['submit1'])) {
    if(empty($_POST['cr_user']) ||
        empty($_POST['cr_email'])|| 
        empty($_POST['cr_pass']) ||  
        empty($_POST['cr_cpass']) ||
        empty($_POST['code'])) {
        $message = "ALL fields must be filled";
    } else {
        $check_username = mysqli_query($db, "SELECT username FROM admin WHERE username = '".$_POST['cr_user']."'");
        $check_email = mysqli_query($db, "SELECT email FROM admin WHERE email = '".$_POST['cr_email']."'");
        $check_code = mysqli_query($db, "SELECT adm_id FROM admin WHERE code = '".$_POST['code']."'");
    
        if($_POST['cr_pass'] != $_POST['cr_cpass']) {
            $message = "Password not match";
        } elseif(!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email address please type a valid email!";
        } elseif(mysqli_num_rows($check_username) > 0) {
            $message = 'Username Already exists!';
        } elseif(mysqli_num_rows($check_email) > 0) {
            $message = 'Email Already exists!';
        } elseif(mysqli_num_rows($check_code) > 0) {
            $message = "Unique Code Already Redeemed!";
        } else {
            $result = mysqli_query($db, "SELECT id FROM admin_codes WHERE codes = '".$_POST['code']."'");  
                      
            if(mysqli_num_rows($result) == 0) {
                $message = "Invalid code!";
            } else {
                $mql = "INSERT INTO admin (username, password, email, code) VALUES ('".$_POST['cr_user']."', '".md5($_POST['cr_pass'])."', '".$_POST['cr_email']."', '".$_POST['code']."')";
                mysqli_query($db, $mql);
                $success = "Admin Added successfully!";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | Secure Login</title>
    
    <!-- Fonts and Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    
    <style>
        :root {
            --primary-color: #3a7bd5;
            --secondary-color: #00d2ff;
            --dark-color: #1a1a2e;
            --light-color: #f5f5f5;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        body {
            background-color: var(--dark-color);
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1000px;
            position: relative;
        }
        
        /* 3D Background Animation */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .bg-cube {
            position: absolute;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 80px;
            height: 80px;
            transform-style: preserve-3d;
            animation: cubeFly 15s linear infinite;
            opacity: 0.3;
        }
        
        @keyframes cubeFly {
            0% {
                transform: translateZ(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateZ(1000px) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Container Styles */
        .container {
            width: 90%;
            max-width: 420px;
            padding: 20px;
            z-index: 1;
        }
        
        .card {
            background: rgba(23, 25, 35, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        .card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 20px 20px 0 0;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: headerSweep 4s linear infinite;
        }
        
        @keyframes headerSweep {
            0% {
                left: -150%;
            }
            100% {
                left: 150%;
            }
        }
        
        .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: logoFloat 3s ease-in-out infinite;
            z-index: 2;
            position: relative;
        }
        
        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .logo i {
            font-size: 50px;
            color: var(--dark-color);
        }
        
        .title {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            font-weight: 400;
        }
        
        .card-body {
            padding: 30px;
        }
        
        /* Form Styles */
        .form-control {
            position: relative;
            margin-bottom: 25px;
        }
        
        .form-control input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: all 0.3s;
        }
        
        .form-control input:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(58, 123, 213, 0.3);
        }
        
        .form-control i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
            transition: all 0.3s;
        }
        
        .form-control input:focus + i {
            color: var(--primary-color);
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s;
        }
        
        .btn:hover::after {
            left: 100%;
        }
        
        .message {
            margin-top: 25px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
        }
        
        .message a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .message a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .login-form, .register-form {
            transition: all 0.5s;
        }
        
        .register-form {
            display: none;
        }
        
        .alert {
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            animation: fadeIn 0.5s;
        }
        
        .alert-error {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Login Success Animation */
        .login-success {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn 0.5s;
        }
        
        .success-content {
            text-align: center;
            color: white;
        }
        
        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: var(--success-color);
            stroke-miterlimit: 10;
            margin: 0 auto 20px;
            box-shadow: 0 0 0 var(--success-color);
            animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
        }
        
        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: var(--success-color);
            fill: none;
            animation: stroke .6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        
        .checkmark-check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke .3s cubic-bezier(0.65, 0, 0.45, 1) .8s forwards;
        }
        
        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
        
        @keyframes scale {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }
        
        @keyframes fill {
            100% {
                box-shadow: 0 0 0 30px rgba(46, 204, 113, 0.2);
            }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 480px) {
            .container {
                width: 95%;
                padding: 10px;
            }
            
            .card-header {
                padding: 15px;
            }
            
            .logo {
                width: 80px;
                height: 80px;
                padding: 15px;
            }
            
            .logo i {
                font-size: 40px;
            }
            
            .title {
                font-size: 20px;
            }
            
            .subtitle {
                font-size: 14px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .form-control input {
                padding: 12px 12px 12px 40px;
                font-size: 14px;
            }
            
            .btn {
                padding: 12px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- 3D Background Animation -->
    <div class="bg-animation" id="bgAnimation"></div>

    <!-- Login Success Animation -->
    <div class="login-success">
        <div class="success-content">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
            <h2>Login Successful!</h2>
            <p>Redirecting to dashboard...</p>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="logo">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h1 class="title">Admin Portal</h1>
                <p class="subtitle">Secure Login System</p>
            </div>
            <div class="card-body">
                <?php if(!empty($message)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                </div>
                <?php endif; ?>
                
                <?php if(!empty($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
                <?php endif; ?>
                
                <form class="login-form" action="" method="post" autocomplete="off">
                    <div class="form-control">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <button type="submit" name="submit" value="login" class="btn">Login</button>
                    <p class="message">Not registered? <a href="#" class="form-toggle">Create an account</a></p>
                </form>
                
                <form class="register-form" action="" method="post" autocomplete="off">
                    <div class="form-control">
                        <input type="text" name="cr_user" placeholder="Username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="form-control">
                        <input type="email" name="cr_email" placeholder="Email address" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="cr_pass" placeholder="Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="cr_cpass" placeholder="Confirm password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="form-control">
                        <input type="password" name="code" placeholder="Unique-Code" required>
                        <i class="fas fa-key"></i>
                    </div>
                    <button type="submit" name="submit1" value="Create" class="btn">Create Account</button>
                    <p class="message">Already registered? <a href="#" class="form-toggle">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Generate 3D background cubes
        document.addEventListener('DOMContentLoaded', function() {
            const bgAnimation = document.getElementById('bgAnimation');
            const cubeCount = 20;
            
            for (let i = 0; i < cubeCount; i++) {
                const cube = document.createElement('div');
                cube.classList.add('bg-cube');
                
                // Random positioning and timing
                cube.style.left = `${Math.random() * 100}%`;
                cube.style.top = `${Math.random() * 100}%`;
                cube.style.animationDelay = `${Math.random() * 15}s`;
                cube.style.animationDuration = `${15 + Math.random() * 15}s`;
                
                bgAnimation.appendChild(cube);
            }
            
            // Toggle between login and register forms
            const formToggleLinks = document.querySelectorAll('.form-toggle');
            const loginForm = document.querySelector('.login-form');
            const registerForm = document.querySelector('.register-form');
            
            formToggleLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
                    registerForm.style.display = registerForm.style.display === 'block' ? 'none' : 'block';
                    
                    if (registerForm.style.display === 'block') {
                        registerForm.style.animation = 'fadeIn 0.5s forwards';
                    } else {
                        loginForm.style.animation = 'fadeIn 0.5s forwards';
                    }
                });
            });
            
            // Show the right form on page load based on PHP conditions
            if (loginForm && registerForm) {
                <?php if(isset($_POST['submit1'])): ?>
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                <?php else: ?>
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
                <?php endif; ?>
            }
            
            // Input animation
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.style.transform = 'scale(1.03)';
                    this.parentNode.style.transition = 'all 0.3s';
                });
                
                input.addEventListener('blur', function() {
                    this.parentNode.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>