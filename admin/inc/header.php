<?php
session_start();
include_once "db.php";

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel | TRX Cinema</title>

  <!-- ✅ Bootstrap + Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Poppins', sans-serif;
      margin: 0;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      background: #1e1e2d;
      color: #fff;
      padding-top: 25px;
      overflow-y: auto;
    }

    .sidebar h2 {
      text-align: center;
      font-size: 22px;
      margin-bottom: 35px;
      color: #ffc107;
    }

    .sidebar a {
      display: block;
      padding: 12px 20px;
      color: #ddd;
      text-decoration: none;
      font-size: 15px;
      transition: all 0.2s ease;
    }

    .sidebar a:hover, 
    .sidebar a.active {
      background: #ffc107;
      color: #000;
      border-radius: 6px;
      font-weight: 600;
    }

    /* Content area */
    .content {
      margin-left: 250px;
      padding: 30px;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      border-radius: 8px;
      background: #ffffff !important;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }

    .navbar-brand {
      font-weight: 600;
      color: #0b63ff !important;
    }

    footer {
      text-align: center;
      padding: 15px;
      color: #6b7280;
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 200px;
      }
      .content {
        margin-left: 210px;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>🎬 TRX Admin</h2>
    <a href="index.php" class="active"><i class="fa fa-home me-2"></i> Dashboard</a>
    <a href="movies.php"><i class="fa fa-film me-2"></i> Movies</a>
    <a href="showtimes.php"><i class="fa fa-clock me-2"></i> Showtimes</a>
    <a href="offers.php"><i class="fa fa-tags me-2"></i> Offers</a>
    <a href="bookings.php"><i class="fa fa-ticket me-2"></i> Bookings</a>
    <a href="users.php"><i class="fa fa-users me-2"></i> Users</a>
    <a href="settings.php"><i class="fa fa-gear me-2"></i> Settings</a>
    <a href="logout.php"><i class="fa fa-sign-out-alt me-2"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
      <div class="container-fluid">
        <span class="navbar-brand">Admin Dashboard</span>
        <div class="d-flex align-items-center">
          <i class="fa fa-user-circle me-2 text-primary"></i>
          <span class="text-muted fw-semibold">
            <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>
          </span>
        </div>
      </div>
    </nav>

    <!-- Page content starts here -->
