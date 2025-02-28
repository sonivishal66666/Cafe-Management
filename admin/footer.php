<!-- Enhanced Footer Section -->
<footer class="footer">
  <div class="footer-content">
    <div class="footer-section about">
      <h2 class="footer-title">About Us</h2>
      <p>We provide high-quality canteen services designed to meet your needs and exceed your expectations.</p>
      <div class="social-icons">
        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
    <div class="footer-section links">
      <h2 class="footer-title">Quick Links</h2>
      <ul>
        <li><a href="#">Dashboard</a></li>
        <li><a href="#">Manage Orders</a></li>
        <li><a href="#">Manage Menu</a></li>
        <li><a href="#">Food Categories</a></li>
        <li><a href="#">Student Profiles</a></li>
      </ul>
    </div>
    <div class="footer-section contact">
      <h2 class="footer-title">Contact Us</h2>
      <div class="contact-info">
        <p><i class="fas fa-map-marker-alt"></i>  VIT University , Bhopal </p>
        <p><i class="fas fa-phone"></i> +1 (123) 456-7890</p>
        <p><i class="fas fa-envelope"></i> canteen@vitb.edu</p>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <span id="year">2025</span> Canteen Management System. All rights reserved.</p>
    <p class="footer-designer"></p>
  </div>
</footer>

<!-- You need Font Awesome for the icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CSS for the enhanced footer -->
<style>
  /* Footer Styles */
  .footer {
    background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
    color: #fff;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    overflow: hidden;
    width: 100%;
    margin-top: 50px; /* Space between content and footer */
    bottom: 0; /* Stick to bottom */
    left: 0;
    right: 0;
    z-index: 100; /* Ensure it's above other content */
    box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
  }
  
  .footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #2ecc71, #f39c12, #e74c3c);
    background-size: 300% 100%;
    animation: borderAnimation 5s linear infinite;
  }
  
  .footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px 30px;
  }
  
  .footer-section {
    flex: 1;
    min-width: 250px;
    margin-bottom: 20px;
    padding: 0 15px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s forwards;
  }
  
  .footer-section.about {
    animation-delay: 0.1s;
  }
  
  .footer-section.links {
    animation-delay: 0.3s;
  }
  
  .footer-section.contact {
    animation-delay: 0.5s;
  }
  
  .footer-title {
    color: #fff;
    margin-bottom: 20px;
    font-size: 1.3rem;
    font-weight: 600;
    position: relative;
    padding-bottom: 10px;
  }
  
  .footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 2px;
    background: #3498db;
    transition: width 0.3s ease;
  }
  
  .footer-section:hover .footer-title::after {
    width: 100px;
  }
  
  .social-icons {
    margin-top: 20px;
    display: flex;
    gap: 15px;
  }
  
  .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: #fff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
  }
  
  .social-icon:hover {
    background: #3498db;
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
  }
  
  .footer-section ul {
    list-style: none;
    padding: 0;
  }
  
  .footer-section ul li {
    margin-bottom: 10px;
  }
  
  .footer-section ul li a {
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    position: relative;
  }
  
  .footer-section ul li a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 1px;
    bottom: -2px;
    left: 0;
    background-color: #3498db;
    transition: width 0.3s ease;
  }
  
  .footer-section ul li a:hover {
    color: #fff;
    transform: translateX(5px);
  }
  
  .footer-section ul li a:hover::after {
    width: 100%;
  }
  
  .contact-info p {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    color: #ccc;
  }
  
  .contact-info p i {
    margin-right: 10px;
    color: #3498db;
    font-size: 1rem;
  }
  
  .footer-bottom {
    background: rgba(0, 0, 0, 0.2);
    padding: 15px 0;
    text-align: center;
    font-size: 0.85rem;
    color: #999;
  }
  
  .footer-designer {
    margin-top: 5px;
  }
  
  .footer-designer i {
    color: #e74c3c;
    animation: pulse 1.5s infinite;
  }
  
  /* Animations */
  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes pulse {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.2);
    }
    100% {
      transform: scale(1);
    }
  }
  
  @keyframes borderAnimation {
    0% {
      background-position: 0% 50%;
    }
    50% {
      background-position: 100% 50%;
    }
    100% {
      background-position: 0% 50%;
    }
  }
  
  /* Integration with your dashboard layout */
  body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  
  .content-wrapper {
    flex: 1;
    padding-bottom: 30px; /* Space for footer */
  }
  
  /* Responsive Footer */
  @media (max-width: 768px) {
    .footer-content {
      flex-direction: column;
      padding: 30px 20px 20px;
    }
    
    .footer-section {
      width: 100%;
      margin-bottom: 20px;
    }
    
    .footer {
      margin-top: 30px;
    }
  }
</style>

<!-- JavaScript to update copyright year automatically -->
<script>
  document.getElementById('year').textContent = new Date().getFullYear();
</script>