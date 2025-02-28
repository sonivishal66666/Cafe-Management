<!-- Dark Themed Professional Footer -->
<section class="footer-section">
  <div class="footer-wave">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
      <path fill="#2d3748" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,197.3C384,171,480,149,576,165.3C672,181,768,235,864,250.7C960,267,1056,245,1152,224C1248,203,1344,181,1392,170.7L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
  </div>
  
  <div class="footer-container">
    <div class="footer-content">
      <div class="footer-grid">
        <!-- Logo and About Column -->
        <div class="footer-column footer-brand">
          <div class="footer-logo">
            <img src="https://cdn.textstudio.com/output/sample/normal/9/1/0/8/mayuri-logo-860-28019.png" alt="Mayuri Logo" class="logo-img">
          </div>
          <p class="footer-description">Providing exceptional services since 2010. Our commitment is to deliver the highest quality experience to all our clients.</p>
        </div>
        
        <!-- Address Column -->
        <div class="footer-column">
          <h4 class="footer-heading">Our Location</h4>
          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <p>VIT University, Bhopal</p>
          </div>
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <p>contact@mayuri.com</p>
          </div>
        </div>
        
        <!-- Contact Column -->
        <div class="footer-column">
          <h4 class="footer-heading">Contact Us</h4>
          <div class="info-item">
            <i class="fas fa-phone-alt"></i>
            <a href="tel:0123456789" class="contact-link">
              <p>0123456789</p>
            </a>
          </div>
          <div class="newsletter">
            <p>Subscribe to our newsletter</p>
            <div class="newsletter-form">
              <input type="email" placeholder="Your email" class="newsletter-input">
              <button class="newsletter-btn">
                <i class="fas fa-paper-plane"></i>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Hours Column -->
        <div class="footer-column">
          <h4 class="footer-heading">Business Hours</h4>
          <div class="hours-container">
            <div class="hours-item">
              <span class="day">Monday - Friday:</span>
              <span class="time">09:00 am - 09:00 pm</span>
            </div>
            <div class="hours-item">
              <span class="day">Saturday:</span>
              <span class="time">09:00 am - 05:00 pm</span>
            </div>
            <div class="hours-item">
              <span class="day">Sunday:</span>
              <span class="time">Closed</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Bottom Bar -->
      <div class="footer-bottom">
        <div class="copyright">
          <p>&copy; 2025 Mayuri. All rights reserved</p>
        </div>
        
        <div class="footer-links">
          <a href="#privacy">Privacy Policy</a>
          <a href="#terms">Terms of Service</a>
          <a href="#faq">FAQ</a>
        </div>
        
        <div class="social-icons">
          <a href="#facebook" class="social-icon" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#instagram" class="social-icon" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#twitter" class="social-icon" aria-label="Twitter">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#linkedin" class="social-icon" aria-label="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Back to top button -->
  <div class="back-to-top">
    <button id="back-to-top-btn" aria-label="Back to top">
      <i class="fas fa-chevron-up"></i>
    </button>
  </div>
</section>

<!-- CSS for the dark themed footer -->
<style>
  /* Dark Footer Styles */
  .footer-section {
    position: relative;
    background: #121212;
    color: #f5f5f5;
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
    padding: 80px 0 30px;
  }
  
  .footer-wave {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
  }
  
  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
  }
  
  .footer-content {
    display: flex;
    flex-direction: column;
    gap: 40px;
  }
  
  .footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
  }
  
  .footer-column {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  
  .footer-brand {
    grid-column: span 1;
  }
  
  .footer-logo {
    margin-bottom: 15px;
    transition: transform 0.3s ease;
    position: relative;
  }
  
  .footer-logo:hover {
    transform: translateY(-5px);
  }
  
  .footer-logo::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 0;
    height: 2px;
    background: #6c5ce7;
    transition: width 0.5s ease;
  }
  
  .footer-logo:hover::after {
    width: 100%;
  }
  
  .logo-img {
    max-width: 60%;
    height: auto;
  }
  
  .footer-description {
    font-size: 14px;
    line-height: 1.6;
    opacity: 0.7;
    color: #a0aec0;
  }
  
  .footer-heading {
    position: relative;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
    padding-bottom: 10px;
    color: #6c5ce7;
  }
  
  .footer-heading::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 50px;
    background: rgba(108, 92, 231, 0.5);
    transition: width 0.3s ease;
  }
  
  .footer-column:hover .footer-heading::after {
    width: 80px;
  }
  
  .info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
    animation: fadeInUp 0.5s forwards;
    opacity: 0;
    transform: translateY(20px);
  }
  
  .info-item:nth-child(1) { animation-delay: 0.1s; }
  .info-item:nth-child(2) { animation-delay: 0.2s; }
  .info-item:nth-child(3) { animation-delay: 0.3s; }
  
  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .info-item i {
    font-size: 18px;
    color: #6c5ce7;
  }
  
  .info-item p {
    margin: 0;
    font-size: 14px;
    color: #cbd5e0;
  }
  
  .contact-link {
    color: #cbd5e0;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  .contact-link:hover {
    color: #6c5ce7;
  }
  
  .newsletter {
    margin-top: 10px;
  }
  
  .newsletter p {
    margin-bottom: 10px;
    font-size: 14px;
    color: #cbd5e0;
  }
  
  .newsletter-form {
    display: flex;
    height: 45px;
  }
  
  .newsletter-input {
    flex: 1;
    padding: 10px 15px;
    border: none;
    background: #2d3748;
    color: #f5f5f5;
    border-radius: 4px 0 0 4px;
    font-size: 14px;
    outline: none;
  }
  
  .newsletter-input::placeholder {
    color: #a0aec0;
  }
  
  .newsletter-btn {
    width: 45px;
    border: none;
    background: #6c5ce7;
    color: #fff;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  
  .newsletter-btn:hover {
    background: #5546e0;
    box-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
  }
  
  .hours-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  
  .hours-item {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    padding-bottom: 5px;
    border-bottom: 1px dashed rgba(160, 174, 192, 0.2);
    transition: all 0.3s ease;
  }
  
  .hours-item:hover {
    transform: translateX(5px);
    border-bottom-color: rgba(108, 92, 231, 0.5);
  }
  
  .day {
    font-weight: 500;
    color: #e2e8f0;
  }
  
  .time {
    color: #a0aec0;
  }
  
  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 30px;
    border-top: 1px solid rgba(160, 174, 192, 0.1);
    flex-wrap: wrap;
    gap: 20px;
  }
  
  .copyright p {
    margin: 0;
    font-size: 14px;
    color: #a0aec0;
  }
  
  .footer-links {
    display: flex;
    gap: 20px;
  }
  
  .footer-links a {
    color: #cbd5e0;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    position: relative;
  }
  
  .footer-links a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 1px;
    bottom: -2px;
    left: 0;
    background-color: #6c5ce7;
    transition: width 0.3s ease;
  }
  
  .footer-links a:hover {
    color: #6c5ce7;
  }
  
  .footer-links a:hover::after {
    width: 100%;
  }
  
  .social-icons {
    display: flex;
    gap: 15px;
  }
  
  .social-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    background: #2d3748;
    border-radius: 50%;
    color: #cbd5e0;
    text-decoration: none;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
  }
  
  .social-icon::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #6c5ce7;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    z-index: 0;
  }
  
  .social-icon:hover::before {
    transform: translateY(0);
  }
  
  .social-icon i {
    position: relative;
    z-index: 1;
  }
  
  .social-icon:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
  }
  
  .back-to-top {
    position: absolute;
    bottom: 30px;
    right: 30px;
  }
  
  #back-to-top-btn {
    width: 40px;
    height: 40px;
    background: #2d3748;
    border: none;
    border-radius: 50%;
    color: #cbd5e0;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
  }
  
  #back-to-top-btn.visible {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
  
  #back-to-top-btn:hover {
    background: #6c5ce7;
    color: #fff;
    box-shadow: 0 0 15px rgba(108, 92, 231, 0.5);
  }
  
  /* Glow effect animations */
  @keyframes glow {
    0% { box-shadow: 0 0 5px rgba(108, 92, 231, 0.5); }
    50% { box-shadow: 0 0 20px rgba(108, 92, 231, 0.8); }
    100% { box-shadow: 0 0 5px rgba(108, 92, 231, 0.5); }
  }
  
  /* Responsive styles */
  @media (max-width: 768px) {
    .footer-grid {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .footer-bottom {
      flex-direction: column;
      text-align: center;
    }
    
    .footer-links {
      order: 2;
    }
    
    .social-icons {
      order: 1;
      margin-bottom: 15px;
    }
    
    .footer-heading::after {
      left: 50%;
      transform: translateX(-50%);
    }
    
    .info-item {
      justify-content: center;
    }
  }
</style>

<!-- JavaScript for animations and functionality -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Back to top button
    const backToTopBtn = document.getElementById('back-to-top-btn');
    
    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('visible');
      } else {
        backToTopBtn.classList.remove('visible');
      }
    });
    
    backToTopBtn.addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
    
    // Animate items on scroll
    const animateOnScroll = function() {
      const items = document.querySelectorAll('.footer-column, .hours-item, .info-item');
      
      items.forEach(item => {
        const itemPosition = item.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.2;
        
        if (itemPosition < screenPosition) {
          item.style.opacity = '1';
          item.style.transform = 'translateY(0)';
        }
      });
    };
    
    // Social icons hover effect
    const socialIcons = document.querySelectorAll('.social-icon');
    socialIcons.forEach((icon, index) => {
      icon.addEventListener('mouseenter', function() {
        this.style.animation = 'glow 1.5s infinite';
      });
      
      icon.addEventListener('mouseleave', function() {
        this.style.animation = 'none';
      });
    });
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on page load
    
    // Typing effect for newsletter text
    const newsletterText = document.querySelector('.newsletter p');
    const originalText = newsletterText.textContent;
    newsletterText.textContent = '';
    
    let i = 0;
    const typeWriter = () => {
      if (i < originalText.length) {
        newsletterText.textContent += originalText.charAt(i);
        i++;
        setTimeout(typeWriter, 50);
      }
    };
    
    // Start typing animation when element is in viewport
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          setTimeout(typeWriter, 500);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    
    observer.observe(newsletterText);
  });
</script>

<!-- Font Awesome CDN (required for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Google Fonts - Poppins -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">