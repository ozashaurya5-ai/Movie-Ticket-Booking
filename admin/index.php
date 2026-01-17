<?php
// admin/index.php
require 'functions.php';
admin_check();

// Quick counts
$total_movies = $conn->query("SELECT COUNT(*) AS c FROM movies")->fetch_assoc()['c'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0;
$total_bookings = $conn->query("SELECT COUNT(*) AS c FROM bookings WHERE LOWER(payment_status)='success'")->fetch_assoc()['c'] ?? 0;
$total_earnings = $conn->query("SELECT SUM(total_price) AS t FROM bookings WHERE LOWER(payment_status)='success'")->fetch_assoc()['t'] ?? 0;
if (!$total_earnings) $total_earnings = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | TRX Cinema</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    :root {
      --primary: #0b63ff;
      --primary-light: #eaf2ff;
      --text: #1e293b;
      --muted: #64748b;
      --card-bg: #ffffff;
      --sidebar-bg: #f8fafc;
      --border: #e5e7eb;
      --shadow: 0 4px 14px rgba(0,0,0,0.06);
    }

    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f5f6fa;
      color: var(--text);
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      border-right: 1px solid var(--border);
      box-shadow: var(--shadow);
      position: fixed;
      top: 0;
      bottom: 0;
      padding: 20px 0;
    }

    .sidebar h2 {
      text-align: center;
      color: var(--primary);
      font-weight: 800;
      margin-bottom: 30px;
      font-size: 20px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: var(--text);
      text-decoration: none;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: 0.2s;
    }

    .sidebar a:hover {
      background: var(--primary-light);
      color: var(--primary);
    }

    .sidebar a.active {
      background: var(--primary-light);
      border-left-color: var(--primary);
      color: var(--primary);
      font-weight: 600;
    }

    .sidebar .bottom {
      margin-top: auto;
      padding: 12px 20px;
      font-size: 0.9em;
      color: var(--muted);
      border-top: 1px solid var(--border);
    }

    .logout-btn {
      display: inline-block;
      margin-top: 8px;
      background: var(--primary);
      color: #fff;
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: 0.2s;
    }

    .logout-btn:hover {
      background: #084edb;
    }

    /* Main Content */
    .main {
      flex: 1;
      margin-left: 240px;
      padding: 40px 30px;
    }

    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .topbar h1 {
      font-size: 26px;
      color: var(--primary);
      margin: 0;
    }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      padding: 24px;
      border-radius: 14px;
      box-shadow: var(--shadow);
      transition: transform 0.2s;
    }

    .card:hover {
      transform: translateY(-3px);
    }

    .card h3 {
      margin: 0;
      font-size: 28px;
      color: var(--primary);
    }

    .card p {
      margin-top: 6px;
      color: var(--muted);
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar h2 { display: none; }
      .sidebar a span { display: none; }
      .main { margin-left: 70px; padding: 20px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>TRX Admin</h2>
    <a href="index.php" class="active">🏠 <span>Dashboard</span></a>
    <a href="movies.php">🎬 <span>Manage Movies</span></a>
    <a href="showtimes.php">🕒 <span>Showtimes</span></a>
    <a href="bookings.php">🎟 <span>Bookings</span></a>
    <a href="manage-payments.php">💸 <span>Manage Payments</span></a>
    <a href="users.php">👥 <span>Users</span></a>
    <a href="images.php">🖼 <span>Images</span></a>
    <a href="manage-messages.php">📩 <span>Messages</span></a>

    <div class="bottom">
      Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="topbar">
      <h1>Dashboard Overview</h1>
    </div>

    <div class="cards">
      <div class="card">
        <h3><?php echo $total_movies; ?></h3>
        <p>Total Movies</p>
      </div>
      <div class="card">
        <h3><?php echo $total_users; ?></h3>
        <p>Registered Users</p>
      </div>
      <div class="card">
        <h3><?php echo $total_bookings; ?></h3>
        <p>Total Bookings</p>
      </div>
      <div class="card">
        <h3>₹<?php echo number_format($total_earnings, 2); ?></h3>
        <p>Total Earnings</p>
      </div>
    </div>

    <div style="margin-top:40px;">
      <h2 style="color:var(--primary)">Welcome to TRX Cinema Admin Panel</h2>
      <p style="color:var(--muted);max-width:600px;">
        Use the sidebar to manage movies, schedules, bookings, and messages.<br>
        This dashboard gives you complete control over your cinema operations.
      </p>
    </div>
  </div>

</body>
</html>
