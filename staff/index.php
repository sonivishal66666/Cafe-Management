<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
		$loginquery ="SELECT * FROM staff WHERE username='$username' && password='".md5($password)."'";
		$result=mysqli_query($db, $loginquery);
		$row=mysqli_fetch_array($result);
	
	    if(is_array($row))
		{
            $_SESSION["st_id"] = $row['st_id'];
            $success = "Login Successful!";
			header("refresh:3;url=dashboard.php");
	    } 
		else
		{
			$message = "Invalid Username or Password!";
		}
	 }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Login Form</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  
  <style>
    :root {
      --primary-color: #0088cc;
      --secondary-color: #005580;
      --success-color: #28a745;
      --error-color: #dc3545;
      --dark-bg: #0a0a1a;
      --card-bg: rgba(15, 15, 20, 0.8);
      --input-bg: rgba(25, 25, 35, 0.8);
    }
    
    * {
      box-sizing: border-box;
      transition: all 0.3s ease;
    }
    
    body {
      font-family: 'Roboto', sans-serif;
      background: var(--dark-bg);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }
    
    /* 3D Dark Animated Background */
    #background-canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    
    .container {
      text-align: center;
      position: absolute;
      top: 50px;
      width: 100%;
      z-index: 1;
    }
    
    .info {
      margin-bottom: 20px;
    }
    
    .info h1 {
      color: white;
      font-size: 2.5em;
      font-weight: 300;
      text-transform: uppercase;
      display: inline-block;
      margin-right: 10px;
      animation: fadeInDown 1s;
    }
    
    .info span {
      color: rgba(255, 255, 255, 0.8);
      font-size: 1.2em;
      animation: fadeInUp 1s;
    }
    
    .form {
      position: relative;
      background: var(--card-bg);
      max-width: 400px;
      width: 100%;
      margin: 0 auto;
      padding: 45px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.05);
      animation: fadeIn 1s, floatAnimation 3s ease-in-out infinite;
      overflow: hidden;
    }
    
    .form::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.03), transparent);
      transform: rotate(30deg);
      animation: shineEffect 8s linear infinite;
    }
    
    @keyframes shineEffect {
      0% { transform: translateX(-100%) rotate(30deg); }
      100% { transform: translateX(100%) rotate(30deg); }
    }
    
    @keyframes floatAnimation {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    
    .thumbnail {
      width: 100px;
      height: 100px;
      margin: 0 auto 30px;
      padding: 20px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      animation: pulse 2s infinite, zoomIn 1s;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    
    .thumbnail::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      border: 3px solid transparent;
      border-top-color: var(--primary-color);
      animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .thumbnail img {
      width: 100%;
      height: auto;
      filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.5));
    }
    
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(0, 136, 204, 0.4); }
      70% { box-shadow: 0 0 0 10px rgba(0, 136, 204, 0); }
      100% { box-shadow: 0 0 0 0 rgba(0, 136, 204, 0); }
    }
    
    .login-form {
      position: relative;
      z-index: 2;
    }
    
    .login-form input {
      font-family: 'Roboto', sans-serif;
      outline: 0;
      background: var(--input-bg);
      width: 100%;
      border: 0;
      border-radius: 5px;
      margin: 0 0 15px;
      padding: 15px;
      box-sizing: border-box;
      font-size: 14px;
      color: white;
      animation: fadeInUp 0.5s;
      box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .login-form input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }
    
    .login-form input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(0, 136, 204, 0.2);
    }
    
    .login-form input[type="submit"] {
      font-family: 'Montserrat', sans-serif;
      text-transform: uppercase;
      outline: 0;
      background: var(--primary-color);
      width: 100%;
      border: 0;
      padding: 15px;
      color: #FFFFFF;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      border-radius: 5px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      animation: fadeInUp 0.7s;
      transition: all 0.3s ease;
      letter-spacing: 1px;
    }
    
    .login-form input[type="submit"]:hover, .login-form input[type="submit"]:active, .login-form input[type="submit"]:focus {
      background: var(--secondary-color);
      transform: translateY(-2px);
      box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
    }
    
    .login-form input[type="submit"]:active {
      transform: translateY(1px);
    }
    
    .message {
      margin: 15px 0 0;
      color: rgba(255, 255, 255, 0.7);
      font-size: 12px;
    }
    
    .message a {
      color: var(--primary-color);
      text-decoration: none;
    }
    
    .message a:hover {
      text-decoration: underline;
    }
    
    .error-message {
      color: var(--error-color);
      animation: shake 0.5s;
      margin-bottom: 15px;
      font-weight: 500;
      padding: 10px;
      border-radius: 5px;
      background: rgba(220, 53, 69, 0.1);
    }
    
    .success-message {
      color: var(--success-color);
      animation: bounceIn 0.5s;
      margin-bottom: 15px;
      font-weight: 500;
      padding: 10px;
      border-radius: 5px;
      background: rgba(40, 167, 69, 0.1);
    }
    
    @keyframes shake {
      0%, 100% {transform: translateX(0);}
      10%, 30%, 50%, 70%, 90% {transform: translateX(-5px);}
      20%, 40%, 60%, 80% {transform: translateX(5px);}
    }
    
    @keyframes bounceIn {
      0%, 20%, 40%, 60%, 80%, 100% {transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);}
      0% {opacity: 0; transform: scale3d(.3, .3, .3);}
      20% {transform: scale3d(1.1, 1.1, 1.1);}
      40% {transform: scale3d(.9, .9, .9);}
      60% {opacity: 1; transform: scale3d(1.03, 1.03, 1.03);}
      80% {transform: scale3d(.97, .97, .97);}
      100% {opacity: 1; transform: scale3d(1, 1, 1);}
    }
    
    /* Login Success Overlay */
    .login-success-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.85);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 0;
      visibility: hidden;
      transition: all 0.5s ease;
    }
    
    .login-success-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    .success-icon {
      width: 80px;
      height: 80px;
      background: #28a745;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
      position: relative;
      animation: zoomIn 0.5s, pulse 2s infinite;
    }
    
    .success-icon::before {
      content: "";
      width: 30px;
      height: 15px;
      border-bottom: 4px solid white;
      border-left: 4px solid white;
      transform: rotate(-45deg);
      position: absolute;
      top: 28px;
    }
    
    .success-message-text {
      font-size: 24px;
      color: white;
      margin-bottom: 10px;
      font-weight: 700;
      animation: fadeInUp 1s;
    }
    
    .redirecting-text {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.7);
      animation: fadeInUp 1.2s;
    }
    
    .loader {
      width: 40px;
      height: 40px;
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      margin-top: 20px;
      animation: spin 1s linear infinite;
    }
    
    /* Additional Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translate3d(0, 20px, 0);
      }
      to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
      }
    }
    
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
      }
      to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
      }
    }
    
    @keyframes zoomIn {
      from {
        opacity: 0;
        transform: scale3d(0.3, 0.3, 0.3);
      }
      50% {
        opacity: 1;
      }
    }
    
    /* Responsive Adjustments */
    @media (max-width: 480px) {
      .form {
        padding: 30px 20px;
      }
      
      .info h1 {
        font-size: 2em;
      }
      
      .thumbnail {
        width: 80px;
        height: 80px;
      }
    }
  </style>
</head>

<body>
  <!-- 3D Animated Background Canvas -->
  <canvas id="background-canvas"></canvas>
  
  <div class="container">
    <div class="info">
      <h1>Staff Portal</h1>
  </div>
  
  <div class="form">
    <div class="thumbnail"><img src="images/manager.png"/></div>
    
    <?php if($message): ?>
    <div class="error-message animate__animated animate__shakeX">
      <i class="fa fa-exclamation-circle"></i> <?php echo $message; ?>
    </div>
    <?php endif; ?>
    
    <?php if($success): ?>
    <div class="success-message animate__animated animate__bounceIn">
      <i class="fa fa-check-circle"></i> <?php echo $success; ?>
    </div>
    <?php endif; ?>
    
    <form class="login-form" action="index.php" method="post">
      <input type="text" placeholder="Username" name="username" required/>
      <input type="password" placeholder="Password" name="password" required/>
      <input type="submit" name="submit" value="LOGIN" />
      <p class="message">Not registered? <a href="#" id="create-account-link">Create an account</a></p>
    </form>
  </div>
  
  <!-- Login Success Overlay -->
  <div class="login-success-overlay" id="successOverlay">
    <div class="success-icon"></div>
    <div class="success-message-text">Login Successful!</div>
    <div class="redirecting-text">Redirecting to dashboard...</div>
    <div class="loader"></div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js'></script>
  <script>
    $(document).ready(function() {
      // Toggle the signup/login form
      $('.message a').click(function() {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
        return false;
      });
      
      // Add floating effect to inputs when focused
      $('input').focus(function() {
        $(this).animate({
          boxShadow: '0 0 8px rgba(0, 136, 204, 0.6)'
        }, 300);
      }).blur(function() {
        $(this).animate({
          boxShadow: 'none'
        }, 300);
      });
      
      // Show login success overlay if success message exists
      <?php if($success): ?>
      setTimeout(function() {
        $('#successOverlay').addClass('active');
      }, 500);
      <?php endif; ?>
      
      // Create account link
      $('#create-account-link').click(function(e) {
        e.preventDefault();
        alert('Please contact an administrator to create a new staff account.');
      });
      
      // Add subtle animation to the form
      function animateForm() {
        $('.form').animate({
          marginTop: '-=10px'
        }, 2000, function() {
          $('.form').animate({
            marginTop: '+=10px'
          }, 2000, function() {
            animateForm();
          });
        });
      }
      
      // Animate error message
      $('.error-message').click(function() {
        $(this).removeClass('animate__shakeX').addClass('animate__bounceOut');
        setTimeout(function() {
          $('.error-message').hide();
        }, 500);
      });
      
      // Start the form animation
      animateForm();
      
      // Add enter key listener
      $('input').keypress(function(e) {
        if (e.which == 13) {
          $('.login-form').submit();
          return false;
        }
      });
    });
    
    // Simplified 3D Background Animation with Three.js
    (function() {
      const canvas = document.getElementById('background-canvas');
      const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true
      });
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setPixelRatio(window.devicePixelRatio > 1 ? 2 : 1);
      
      const scene = new THREE.Scene();
      scene.background = new THREE.Color('#0a0a1a'); // Dark blue background similar to screenshot
      
      // Camera setup
      const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
      camera.position.set(0, 0, 100);
      
      // Create stars - fewer and more subtle than before
      const starGeometry = new THREE.BufferGeometry();
      const starMaterial = new THREE.PointsMaterial({
        color: 0xffffff,
        size: 0.5, // Smaller stars
        opacity: 0.7,
        transparent: true
      });
      
      const starCount = 200; // Fewer stars for subtlety
      const starPositions = new Float32Array(starCount * 3);
      
      for (let i = 0; i < starCount * 3; i += 3) {
        starPositions[i] = (Math.random() - 0.5) * 200;     // x
        starPositions[i + 1] = (Math.random() - 0.5) * 200; // y
        starPositions[i + 2] = (Math.random() - 0.5) * 200; // z
      }
      
      starGeometry.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
      const stars = new THREE.Points(starGeometry, starMaterial);
      scene.add(stars);
      
      // Animation loop - very subtle movement
      function animate() {
        requestAnimationFrame(animate);
        
        // Very slow star rotation for subtle movement
        stars.rotation.y += 0.0001;
        stars.rotation.x += 0.00005;
        
        renderer.render(scene, camera);
      }
      
      // Handle window resize
      window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      });
      
      animate();
    })();
  </script>
</body>
</html>