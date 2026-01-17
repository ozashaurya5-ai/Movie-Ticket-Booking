<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$booking_id = intval($_GET['id'] ?? 0);

$query = "
  SELECT b.*, s.show_date, s.show_time, m.title, m.poster
  FROM bookings b
  JOIN showtimes s ON b.showtime_id = s.id
  JOIN movies m ON s.movie_id = m.id
  WHERE b.id='$booking_id' AND b.user_id='$user_id' AND LOWER(b.payment_status)='success'
";
$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
  echo "<h2 style='color:red;text-align:center;'>Invalid or unconfirmed ticket.</h2>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Ticket | TRX Cinema</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/theme-overrides.css">

<style>
body {
  background: linear-gradient(180deg, #f8fafc 0%, #eef3ff 100%);
  font-family: 'Poppins', sans-serif;
  color: #0f172a;
  margin: 0;
  padding: 40px 0;
}

.ticket-container {
  width: 420px;
  margin: 0 auto;
  background: #ffffff;
  border: 1px solid rgba(15,23,42,0.1);
  border-radius: 16px;
  padding: 28px 24px;
  box-shadow: 0 8px 24px rgba(15,23,42,0.08);
  text-align: center;
  transition: 0.3s ease;
}
.ticket-container:hover {
  box-shadow: 0 12px 28px rgba(15,23,42,0.12);
}

.ticket-container img.poster {
  width: 130px;
  height: auto;
  border-radius: 10px;
  margin-bottom: 18px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.ticket-title {
  font-size: 22px;
  font-weight: 700;
  color: #0b63ff;
  margin-bottom: 10px;
}

.ticket-info {
  margin: 6px 0;
  font-size: 15px;
  color: #334155;
}

hr {
  border: none;
  border-top: 1px dashed rgba(15,23,42,0.2);
  margin: 20px 0;
}

.qr img {
  width: 120px;
  height: 120px;
  border-radius: 6px;
  margin: 10px auto;
  display: block;
  box-shadow: 0 2px 10px rgba(11,99,255,0.15);
}

/* Fix for invisible text on blue button */
.download-btn {
  
  color: #ffffff !important;
  padding: 10px 18px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  transition: all 0.2s ease;
}
.download-btn:hover {
  background: #0846c6 !important;
  color: #ffffff !important;
  transform: translateY(-2px);
}
</style>
</head>

<body>

<div class="ticket-container">
  <?php if (!empty($booking['poster'])): ?>
    <img src="<?php echo htmlspecialchars($booking['poster']); ?>" class="poster" alt="Poster">
  <?php endif; ?>

  <div class="ticket-title"><?php echo htmlspecialchars($booking['title']); ?></div>
  <div class="ticket-info">🎬 Seat: <strong><?php echo htmlspecialchars($booking['seat_number']); ?></strong></div>
  <div class="ticket-info">📅 Date: <strong><?php echo htmlspecialchars($booking['show_date']); ?></strong></div>
  <div class="ticket-info">🕒 Time: <strong><?php echo htmlspecialchars($booking['show_time']); ?></strong></div>
  <div class="ticket-info">💰 Paid: <strong>₹<?php echo htmlspecialchars($booking['total_price']); ?></strong></div>

  <hr>

  <div class="qr">
    <?php
    $qrData = "Movie: {$booking['title']} | Seat: {$booking['seat_number']} | Date: {$booking['show_date']} | Time: {$booking['show_time']}";
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);
    ?>
    <!-- <img src="<?php echo $qrUrl; ?>" alt="QR Code"> -->
  </div>

  <a href="#" onclick="window.print();" class="download-btn">🖨️ Download / Print Ticket</a>
</div>

</body>
</html>
