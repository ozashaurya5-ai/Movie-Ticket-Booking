<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<nav class="navbar">
  <a href="index.php" class="brand">
    <span class="brand-mark">🎬</span>
    <span class="brand-text">Movie<span>Time</span></span>
  </a>

  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="showtimes.php">Showtimes</a>
    <a href="index.php#nowshowing">Now Showing</a>
    <a href="index.php#experiences">Experiences</a>
    <a href="index.php#trailers">Trailers</a>
    <a href="my-bookings.php">My Bookings</a>
  </div>

  <div class="navbar-right">
    <?php if(isset($_SESSION["user_id"])): ?>
      <div class="location-dropdown">
        👤 <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
      </div>
      <a href="logout.php" class="login-btn">Logout</a>
    <?php else: ?>
      <a href="login.php" class="login-btn">Login</a>
    <?php endif; ?>
  </div>
</nav>

<style>
.navbar {
  position: sticky;
  top: 0;
  z-index: 50;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 28px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--stroke);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

/* Brand */
.brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.brand-mark {
  font-size: 22px;
}
.brand-text {
  font-weight: 800;
  color: var(--text);
  font-size: 20px;
}
.brand-text span {
  color: var(--brand);
}

/* Links */
.nav-links {
  display: flex;
  align-items: center;
  gap: 18px;
}
.nav-links a {
  text-decoration: none;
  color: var(--muted);
  font-weight: 600;
  padding: 8px 12px;
  border-radius: 8px;
  transition: 0.2s ease;
}
.nav-links a:hover {
  color: var(--brand-2);
  background: rgba(255, 179, 0, 0.08);
}

/* Right side */
.navbar-right {
  display: flex;
  align-items: center;
  gap: 12px;
}
.location-dropdown {
  background: var(--bg-soft);
  border: 1px solid var(--stroke);
  border-radius: 12px;
  padding: 8px 14px;
  font-weight: 600;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Button */
.login-btn {
  background: linear-gradient(135deg, var(--brand), var(--brand-2));
  color: #fff;
  border: none;
  border-radius: 999px;
  padding: 10px 18px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 6px 14px rgba(255, 179, 0, 0.25);
  text-decoration: none;
  transition: transform 0.15s ease, box-shadow 0.2s ease;
}
.login-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 8px 20px rgba(255, 179, 0, 0.35);
}

@media (max-width: 768px) {
  .nav-links {
    display: none;
  }
  .navbar {
    padding: 12px 18px;
  }
}
</style>
