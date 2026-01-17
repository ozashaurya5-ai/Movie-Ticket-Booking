<footer class="footer">
  <div class="footer-container">
    <div class="footer-left">
      <h2 class="footer-logo">🎞 TRX <span>Cinema</span></h2>
      <p>Experience movies like never before — premium screens, surround sound, and seamless booking.</p>
    </div>

    <div class="footer-links">
      <h3>Quick Links</h3>
      <a href="index.php">Home</a>
      <a href="index.php#nowshowing">Now Showing</a>
      <a href="index.php#experiences">Experiences</a>
      <a href="index.php#trailers">Trailers</a>
      <a href="contact.php">Contact Us</a>
    </div>

    <div class="footer-contact">
      <h3>Contact</h3>
      <p>📍 Mehsana, India</p>
      <p>📞 +91 99999 88888</p>
      <p>✉️ support@trxcinema.in</p>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© <?php echo date('Y'); ?> TRX Cinema. All rights reserved.</p>
    <div class="social-icons">
      <a href="#"><i class="fa-brands fa-facebook"></i></a>
      <a href="#"><i class="fa-brands fa-instagram"></i></a>
      <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
      <a href="#"><i class="fa-brands fa-youtube"></i></a>
    </div>
  </div>
</footer>

<!-- Footer Styles -->
<style>
.footer {
  background: linear-gradient(180deg, #ffffff 0%, #f8f9fb 100%);
  color: var(--text);
  padding: 60px 0 24px;
  font-family: 'Poppins', sans-serif;
  border-top: 2px solid var(--brand);
  margin-top: 60px;
  box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.05);
}

.footer-container {
  width: 90%;
  max-width: 1200px;
  margin: auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}

/* Left Section */
.footer-logo {
  font-size: 28px;
  font-weight: 800;
  color: var(--brand);
}
.footer-logo span {
  color: var(--text);
}
.footer-left p {
  font-size: 15px;
  color: var(--muted);
  margin-top: 10px;
  line-height: 1.7;
}

/* Links */
.footer-links h3,
.footer-contact h3 {
  color: var(--brand);
  margin-bottom: 10px;
  font-size: 18px;
}
.footer-links a {
  display: block;
  color: var(--muted);
  text-decoration: none;
  margin: 4px 0;
  transition: 0.3s ease;
}
.footer-links a:hover {
  color: var(--brand-2);
  transform: translateX(4px);
}

/* Contact */
.footer-contact p {
  color: var(--muted);
  margin: 6px 0;
}

/* Bottom Bar */
.footer-bottom {
  border-top: 1px solid var(--stroke);
  margin-top: 40px;
  padding-top: 18px;
  text-align: center;
  color: var(--muted);
  font-size: 14px;
}

.social-icons {
  margin-top: 10px;
}
.social-icons a {
  display: inline-block;
  margin: 0 6px;
  color: var(--brand);
  font-size: 18px;
  transition: 0.3s ease;
}
.social-icons a:hover {
  color: var(--brand-2);
  transform: scale(1.2);
}

@media (max-width: 768px) {
  .footer-container {
    text-align: center;
  }
}
</style>

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
