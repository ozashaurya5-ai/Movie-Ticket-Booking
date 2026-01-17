<?php
include('config.php');
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']);

$query = "
    SELECT b.*, s.show_date, s.show_time, m.title
    FROM bookings b
    LEFT JOIN showtimes s ON b.showtime_id = s.id
    LEFT JOIN movies m ON s.movie_id = m.id
    WHERE b.user_id = '$user_id'
    ORDER BY b.booking_time DESC
";
$result = mysqli_query($conn, $query);
if ($result === false) {
    echo "<p style='color:red;text-align:center;'>Database error: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>My Bookings | TRX Cinema</title>
<link rel="stylesheet" href="style.css">
<style>
body {
  background: var(--bg);
  color: var(--text);
  font-family: 'Poppins', sans-serif;
}

.container {
  width: min(1000px, 92vw);
  margin: 60px auto;
  background: var(--bg-soft);
  border: 1px solid var(--stroke);
  border-radius: 16px;
  box-shadow: var(--shadow);
  padding: 30px;
}

h2 {
  text-align: center;
  color: var(--brand);
  font-size: 28px;
  margin-bottom: 20px;
}

/* Table */
.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 15px;
  border-radius: 12px;
  overflow: hidden;
}
.table thead {
  background: var(--brand);
  color: #111;
}
.table th, .table td {
  padding: 14px 10px;
  text-align: center;
  border-bottom: 1px solid var(--stroke);
}
.table tr:nth-child(even) {
  background: rgba(0, 0, 0, 0.02);
}
.table th {
  font-weight: 700;
}
.table td {
  color: var(--text);
}

/* Status Badges */
.status {
  font-weight: 700;
  text-transform: capitalize;
  padding: 4px 10px;
  border-radius: 8px;
  display: inline-block;
}
.status.pending {
  background: rgba(255, 193, 7, 0.15);
  color: #b8860b;
}
.status.confirmed,
.status.success {
  background: rgba(76, 175, 80, 0.15);
  color: #2e7d32;
}
.status.rejected {
  background: rgba(244, 67, 54, 0.15);
  color: #c62828;
}

/* Buttons */
.action-btn {
  display: inline-block;
  background: linear-gradient(135deg, var(--brand), var(--brand-2));
  color: #111;
  padding: 8px 14px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 700;
  transition: transform 0.15s ease, box-shadow 0.2s ease;
  box-shadow: 0 4px 12px rgba(255, 179, 0, 0.25);
}
.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(255, 179, 0, 0.35);
}

.empty {
  text-align: center;
  color: var(--muted);
  font-size: 16px;
  padding: 30px;
}

/* Responsive */
@media (max-width: 768px) {
  .table th, .table td {
    font-size: 13px;
    padding: 10px 6px;
  }
  .action-btn {
    padding: 6px 10px;
    font-size: 13px;
  }
}
</style>
</head>
<body>
<?php if (file_exists('navbar.php')) include('navbar.php'); ?>

<div class="container">
  <h2>🎟️ My Bookings</h2>

  <?php if (mysqli_num_rows($result) > 0): ?>
  <table class="table" role="table" aria-label="My bookings">
    <thead>
      <tr>
        <th>Movie</th>
        <th>Show Date</th>
        <th>Show Time</th>
        <th>Seats</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Booked On</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <?php
          $status = strtolower(trim($row['payment_status'] ?? ''));
          if ($status === 'success' || $status === 'confirmed') {
              $status_label = '<span class="status confirmed">✅ Confirmed</span>';
          } elseif ($status === 'pending' || $status === '') {
              $status_label = '<span class="status pending">⌛ Pending</span>';
          } elseif ($status === 'rejected') {
              $status_label = '<span class="status rejected">❌ Rejected</span>';
          } else {
              $status_label = '<span class="status">N/A</span>';
          }
        ?>
        <tr>
          <td><?= htmlspecialchars($row['title'] ?? '—') ?></td>
          <td><?= htmlspecialchars($row['show_date'] ?? '—') ?></td>
          <td><?= htmlspecialchars($row['show_time'] ?? '—') ?></td>
          <td><?= htmlspecialchars($row['seat_number'] ?? '—') ?></td>
          <td>₹<?= htmlspecialchars($row['total_price'] ?? '0') ?></td>
          <td><?= $status_label ?></td>
          <td><?= !empty($row['booking_time']) ? date('d M Y, h:i A', strtotime($row['booking_time'])) : '—' ?></td>
          <td>
            <?php if ($status === 'success' || $status === 'confirmed'): ?>
              <a href="ticket.php?id=<?= $row['id'] ?>" class="action-btn">🎟 View</a>
              <a href="ticket-download.php?id=<?= $row['id'] ?>" class="action-btn">⬇️ PDF</a>
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <div class="empty">You have no bookings yet.</div>
  <?php endif; ?>
</div>
</body>
</html>
