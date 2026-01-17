<?php
include('config.php');
if (session_status() === PHP_SESSION_NONE) session_start();

$success = $error = "";

// Save Message to Database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "✅ Your message has been sent successfully!";
        } else {
            $error = "⚠️ Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "⚠️ Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us | TRX Cinema</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
  background: #f7f9fc;
  color: var(--text);
  font-family: 'Poppins', sans-serif;
  margin: 0;
  padding: 0;
}

.contact-container {
  max-width: 1100px;
  margin: 60px auto;
  padding: 40px;
  background: #fff;
  border: 1px solid var(--stroke);
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 40px;
}

.contact-info h2,
.contact-form h2 {
  color: var(--brand);
  margin-bottom: 14px;
  font-size: 22px;
}

.contact-info p {
  color: var(--muted);
  line-height: 1.7;
  font-size: 15px;
  margin: 6px 0;
}
.contact-info i {
  color: var(--brand);
  margin-right: 8px;
}

.contact-form form {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.contact-form input,
.contact-form textarea {
  background: #f9fafc;
  border: 1px solid var(--stroke);
  color: var(--text);
  padding: 12px 14px;
  border-radius: 10px;
  font-size: 15px;
  transition: 0.2s ease;
}
.contact-form input:focus,
.contact-form textarea:focus {
  border-color: var(--brand);
  background: #fff;
  outline: none;
}
.contact-form textarea {
  min-height: 120px;
  resize: none;
}
.contact-form button {
  background: linear-gradient(135deg, var(--brand), var(--brand-2));
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  transition: 0.2s ease;
  box-shadow: 0 6px 14px rgba(255, 179, 0, 0.25);
}
.contact-form button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(255, 179, 0, 0.35);
}

.message {
  text-align: center;
  margin-bottom: 12px;
  font-weight: 600;
}
.message.success { color: #0f9d58; }
.message.error { color: #d93025; }

iframe {
  width: 100%;
  height: 260px;
  border: 1px solid var(--stroke);
  border-radius: 12px;
  margin-top: 18px;
}

@media (max-width: 768px) {
  .contact-container {
    padding: 20px;
  }
}
</style>
</head>
<body>
<?php if (file_exists('navbar.php')) include('navbar.php'); ?>

<div class="contact-container">
  <div class="contact-info">
    <h2>📍 Get in Touch</h2>
    <p><i class="fa fa-map-marker-alt"></i> Mehsana, Gujarat, India</p>
    <p><i class="fa fa-phone"></i> +91 99999 88888</p>
    <p><i class="fa fa-envelope"></i> support@trxcinema.in</p>
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58502.45206586783!2d72.34177913339167!3d23.589866567472804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c422caf789ef5%3A0x170bbc90b8be8bdc!2sMehsana%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1760290019583!5m2!1sen!2sin"
      allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>

  <div class="contact-form">
    <h2>💬 Send Us a Message</h2>
    <?php if ($success): ?><div class="message success"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="message error"><?= $error ?></div><?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
