<?php
require 'functions.php';
admin_check();

// Fetch all bookings with user, movie & showtime details
$sql = "SELECT 
          b.id, b.seat_number, b.booking_time, b.total_price, b.payment_status,
          u.name AS user_name, u.email,
          s.show_date, s.show_time, s.cinema,
          m.title
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN showtimes s ON b.showtime_id = s.id
        JOIN movies m ON s.movie_id = m.id
        ORDER BY b.booking_time DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Bookings | TRX Cinema Admin</title>
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
  padding: 40px;
}

.container {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 30px;
  max-width: 1200px;
  margin: auto;
  box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

h2 {
  color: #0b63ff;
  text-align: center;
  margin-bottom: 25px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 15px;
}

th, td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #e2e8f0;
  vertical-align: top;
}

th {
  background: #f1f5f9;
  color: #0b63ff;
  font-weight: 600;
}

tr:hover {
  background: #f9fafb;
}

small {
  color: #64748b;
}

.status {
  font-weight: 600;
  text-transform: capitalize;
}
.status.success { color: #16a34a; }
.status.pending { color: #f59e0b; }
.status.rejected { color: #dc2626; }

.amount {
  font-weight: 600;
  color: #0b63ff;
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
  <a href="bookings.php" class="active">🎟 <span>Bookings</span></a>
  <a href="manage-payments.php">💸 <span>Payments</span></a>
  <a href="users.php">👥 <span>Users</span></a>
  <a href="images.php">🖼 <span>Images</span></a>
  <a href="manage-messages.php">📩 <span>Messages</span></a>
  <div class="bottom">
    Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
    <a href="logout.php" style="color:#0b63ff; text-decoration:none;">Logout</a>
  </div>
</div>

<!-- Main -->
<div class="main">
  <div class="container">
    <h2>🎟 All Bookings</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Movie</th>
          <th>Cinema</th>
          <th>Date</th>
          <th>Time</th>
          <th>Seat</th>
          <th>Amount (₹)</th>
          <th>Status</th>
          <th>Booked On</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $i = 1;
        while($b = $res->fetch_assoc()): 
          $status = strtolower(trim($b['payment_status']));
        ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($b['user_name']); ?><br><small><?php echo htmlspecialchars($b['email']); ?></small></td>
          <td><?php echo htmlspecialchars($b['title']); ?></td>
          <td><?php echo htmlspecialchars($b['cinema']); ?></td>
          <td><?php echo htmlspecialchars($b['show_date']); ?></td>
          <td><?php echo htmlspecialchars($b['show_time']); ?></td>
          <td><?php echo htmlspecialchars($b['seat_number']); ?></td>
          <td><span class="amount">₹<?php echo htmlspecialchars($b['total_price'] ?? '0'); ?></span></td>
          <td>
            <?php if ($status === 'success'): ?>
              <span class="status success">Confirmed</span>
            <?php elseif ($status === 'rejected'): ?>
              <span class="status rejected">Rejected</span>
            <?php else: ?>
              <span class="status pending">Pending</span>
            <?php endif; ?>
          </td>
          <td><?php echo date("d M Y, h:i A", strtotime($b['booking_time'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
