<?php
session_start();
require '../config.php';
require 'functions.php';
admin_check();

// 🔹 Handle Confirm / Reject actions
if (isset($_POST['accept'])) {
    $booking_id = intval($_POST['booking_id']);
    mysqli_query($conn, "UPDATE bookings SET payment_status='success' WHERE id='$booking_id'");
    header("Location: manage-payments.php?status=confirmed");
    exit;
}

if (isset($_POST['reject'])) {
    $booking_id = intval($_POST['booking_id']);
    mysqli_query($conn, "UPDATE bookings SET payment_status='rejected' WHERE id='$booking_id'");
    header("Location: manage-payments.php?status=rejected");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Payments | TRX Cinema Admin</title>
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

/* Main */
.main {
  flex: 1;
  margin-left: 240px;
  padding: 30px;
}

h1 {
  color: #0b63ff;
  margin-bottom: 20px;
}

.alert {
  padding: 12px 14px;
  border-radius: 8px;
  font-weight: 600;
  width: fit-content;
  margin-bottom: 20px;
}

.alert.success {
  background: #dcfce7;
  color: #166534;
  border: 1px solid #86efac;
}

.alert.error {
  background: #fee2e2;
  color: #b91c1c;
  border: 1px solid #fecaca;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

th, td {
  padding: 12px 10px;
  text-align: center;
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

img.payment-proof {
  width: 70px;
  height: 70px;
  border-radius: 8px;
  object-fit: cover;
  border: 2px solid #0b63ff;
  transition: transform 0.2s;
}

img.payment-proof:hover {
  transform: scale(1.1);
}

.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
}

.accept {
  background: #16a34a;
  color: #fff;
}

.reject {
  background: #dc2626;
  color: #fff;
}

.accept:hover {
  background: #15803d;
}

.reject:hover {
  background: #b91c1c;
}

.status {
  font-weight: 700;
  text-transform: capitalize;
  font-size: 14px;
}

.status.pending { color: #ca8a04; }
.status.success { color: #16a34a; }
.status.rejected { color: #dc2626; }

@media (max-width: 768px) {
  .sidebar {
    width: 70px;
  }
  .sidebar h2 { display: none; }
  .sidebar a span { display: none; }
  .main { margin-left: 70px; padding: 15px; }
  table { font-size: 13px; }
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
  <a href="manage-payments.php" class="active">💸 <span>Payments</span></a>
  <a href="users.php">👥 <span>Users</span></a>
  <a href="images.php">🖼 <span>Images</span></a>
  <a href="manage-messages.php">📩 <span>Messages</span></a>
  <div class="bottom">
    Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
    <a href="logout.php" style="color:#0b63ff; text-decoration:none;">Logout</a>
  </div>
</div>

<!-- Main Content -->
<div class="main">
  <h1>💸 Manage Payments</h1>

  <?php if (isset($_GET['status']) && $_GET['status'] == 'confirmed'): ?>
    <div class="alert success">✅ Payment Confirmed Successfully!</div>
  <?php elseif (isset($_GET['status']) && $_GET['status'] == 'rejected'): ?>
    <div class="alert error">❌ Payment Rejected!</div>
  <?php endif; ?>

  <table>
    <tr>
      <th>#</th>
      <th>User</th>
      <th>Movie</th>
      <th>Showtime</th>
      <th>Seats</th>
      <th>Amount (₹)</th>
      <th>Screenshot</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php
    $query = "
      SELECT b.id, b.payment_status, b.seat_number, b.total_price, b.payment_screenshot,
             u.name AS username, m.title, s.show_date, s.show_time
      FROM bookings b
      JOIN users u ON b.user_id = u.id
      JOIN showtimes s ON b.showtime_id = s.id
      JOIN movies m ON s.movie_id = m.id
      ORDER BY b.booking_time DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $proofPath = '../uploads/' . $row['payment_screenshot'];
            echo "<tr>
              <td>{$i}</td>
              <td>{$row['username']}</td>
              <td>{$row['title']}</td>
              <td>{$row['show_date']} {$row['show_time']}</td>
              <td>{$row['seat_number']}</td>
              <td>₹{$row['total_price']}</td>";

            if (!empty($row['payment_screenshot']) && file_exists($proofPath)) {
                echo "<td><a href='$proofPath' target='_blank'><img src='$proofPath' class='payment-proof'></a></td>";
            } else {
                echo "<td><span style='color:#94a3b8;'>No File</span></td>";
            }

            $status = strtolower(trim($row['payment_status']));
            echo "<td><span class='status {$status}'>{$row['payment_status']}</span></td>";

            echo "<td>";
            if ($status == 'pending' || $status == '') {
                echo "
                <form method='POST' style='display:inline-block;'>
                  <input type='hidden' name='booking_id' value='{$row['id']}'>
                  <button type='submit' class='btn accept' name='accept'>Confirm</button>
                </form>
                <form method='POST' style='display:inline-block; margin-left:6px;'>
                  <input type='hidden' name='booking_id' value='{$row['id']}'>
                  <button type='submit' class='btn reject' name='reject'>Reject</button>
                </form>";
            } else {
                echo "<span style='color:#94a3b8;'>—</span>";
            }
            echo "</td></tr>";
            $i++;
        }
    } else {
        echo "<tr><td colspan='9' style='color:#64748b; padding:20px;'>No payment records found.</td></tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
