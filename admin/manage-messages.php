<?php
// admin/manage-messages.php
require 'functions.php';
admin_check(); // Ensure only logged-in admin can access

// Fetch contact messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");

// Delete message if requested
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM contact_messages WHERE id = $id");
  header("Location: manage-messages.php?deleted=1");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Messages | TRX Cinema Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f9fafb;
      color: #1e293b;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar (same as dashboard) */
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

    .sidebar a:hover,
    .sidebar a.active {
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
      margin-bottom: 20px;
    }

    .success-msg {
      background: #dcfce7;
      color: #166534;
      border: 1px solid #86efac;
      padding: 10px 12px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px 12px;
      text-align: left;
      border-bottom: 1px solid #f1f5f9;
    }

    th {
      background: #f8fafc;
      color: #0b63ff;
      font-weight: 600;
    }

    tr:hover td {
      background: #f1f5f9;
    }

    .btn {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      transition: 0.2s;
    }

    .btn-view {
      background: #0b63ff;
      color: #fff;
    }

    .btn-delete {
      background: #ef4444;
      color: #fff;
    }

    .btn-view:hover { background: #084edb; }
    .btn-delete:hover { background: #dc2626; }

    .no-data {
      text-align: center;
      padding: 40px;
      color: #64748b;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar h2 { display: none; }
      .sidebar a span { display: none; }
      .main { margin-left: 70px; padding: 15px; }
      table { font-size: 14px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>TRX Admin</h2>
    <a href="index.php">🏠 <span>Dashboard</span></a>
    <a href="movies.php">🎬 <span>Manage Movies</span></a>
    <a href="showtimes.php">🕒 <span>Showtimes</span></a>
    <a href="bookings.php">🎟 <span>Bookings</span></a>
    <a href="manage-payments.php">💸 <span>Payments</span></a>
    <a href="users.php">👥 <span>Users</span></a>
    <a href="images.php">🖼 <span>Images</span></a>
    <a href="manage-messages.php" class="active">📩 <span>Messages</span></a>
    <div class="bottom">
      Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
      <a href="logout.php" style="color:#0b63ff; text-decoration:none;">Logout</a>
    </div>
  </div>

  <!-- Main Section -->
  <div class="main">
    <h1>📩 Manage Messages</h1>

    <?php if (isset($_GET['deleted'])): ?>
      <div class="success-msg">✅ Message deleted successfully.</div>
    <?php endif; ?>

    <?php if ($messages->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($m = $messages->fetch_assoc()): ?>
            <tr>
              <td><?php echo $m['id']; ?></td>
              <td><?php echo htmlspecialchars($m['name']); ?></td>
              <td><?php echo htmlspecialchars($m['email']); ?></td>
              <td><?php echo htmlspecialchars(substr($m['message'], 0, 80)); ?>...</td>
              <td>
                <a href="view-message.php?id=<?php echo $m['id']; ?>" class="btn btn-view">View</a>
                <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="no-data">No messages found.</div>
    <?php endif; ?>
  </div>
</body>
</html>
