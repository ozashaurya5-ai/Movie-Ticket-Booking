<?php
// admin/images.php
require 'functions.php';
admin_check();

$dir = __DIR__ . '/../images/';
if (!is_dir($dir)) mkdir($dir, 0755, true);

$files = array_diff(scandir($dir), array('.', '..'));

// Delete image
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
  $f = basename($_GET['delete']);
  if (file_exists($dir . $f)) {
    unlink($dir . $f);
    admin_log('Delete Image', $f);
    header("Location: images.php");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Image Manager | TRX Cinema Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f8fafc;
      color: #1e293b;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: #ffffff;
      border-right: 1px solid #e2e8f0;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      position: fixed;
      top: 0;
      bottom: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    }

    .sidebar h2 {
      text-align: center;
      color: #0b63ff;
      font-weight: 800;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: #334155;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .sidebar a:hover, .sidebar a.active {
      background: #0b63ff;
      color: #fff;
      border-radius: 8px;
    }

    .sidebar .bottom {
      margin-top: auto;
      padding: 12px 20px;
      font-size: 0.9em;
      color: #64748b;
    }

    /* Main Content */
    .main {
      flex: 1;
      margin-left: 240px;
      padding: 30px;
    }

    h1 {
      color: #0b63ff;
      margin-bottom: 10px;
    }

    p {
      color: #64748b;
      margin-bottom: 30px;
    }

    .card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 20px;
    }

    .item {
      text-align: center;
      background: #f9fafb;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 10px;
      transition: 0.2s;
    }

    .item:hover {
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      transform: translateY(-3px);
    }

    .item img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    a.delete-btn {
      display: inline-block;
      margin-top: 8px;
      background: #ef4444;
      color: #fff;
      padding: 6px 10px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      transition: background 0.2s;
    }

    a.delete-btn:hover {
      background: #dc2626;
    }

    @media(max-width: 768px) {
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
  <a href="index.php">🏠 <span>Dashboard</span></a>
  <a href="movies.php">🎬 <span>Movies</span></a>
  <a href="showtimes.php">🕒 <span>Showtimes</span></a>
  <a href="bookings.php">🎟 <span>Bookings</span></a>
  <a href="manage-payments.php">💸 <span>Payments</span></a>
  <a href="users.php">👥 <span>Users</span></a>
  <a href="images.php" class="active">🖼 <span>Images</span></a>
  <a href="manage-messages.php">📩 <span>Messages</span></a>
  <div class="bottom">
    Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
    <a href="logout.php" style="color:#0b63ff; text-decoration:none;">Logout</a>
  </div>
</div>

<!-- Main Content -->
<div class="main">
  <h1>🖼 Image Manager</h1>
  <p>All uploaded images are displayed below. You can delete unnecessary ones safely.</p>

  <div class="card">
    <div class="grid">
      <?php if (empty($files)): ?>
        <p style="grid-column:1/-1; text-align:center; color:#64748b;">No images found.</p>
      <?php else: ?>
        <?php foreach($files as $file): ?>
          <div class="item">
            <img src="../images/<?php echo htmlspecialchars($file); ?>" alt="Image">
            <a href="images.php?delete=<?php echo urlencode($file); ?>" class="delete-btn" onclick="return confirm('Delete this image?')">Delete</a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
