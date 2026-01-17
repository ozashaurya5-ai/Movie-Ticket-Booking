<?php
include 'config.php';
session_start();

// Require login
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

// Fetch user's recent bookings
$sql = "SELECT b.*, s.cinema, s.show_date, s.show_time, m.title, m.poster 
        FROM bookings b
        JOIN showtimes s ON b.showtime_id = s.id
        JOIN movies m ON s.movie_id = m.id
        WHERE b.user_id = ?
        ORDER BY b.id DESC LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Confirmation - MovieTime</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: var(--bg);
      color: var(--text);
      font-family: "Inter", sans-serif;
      margin: 0;
      padding: 0;
    }

    .confirm-section {
      width: min(900px, 92vw);
      margin: 60px auto;
      text-align: center;
    }

    .success-banner {
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #fff;
      padding: 14px 20px;
      border-radius: 12px;
      font-weight: 800;
      font-size: 18px;
      width: fit-content;
      margin: 0 auto 28px;
      box-shadow: 0 6px 18px rgba(255, 179, 0, 0.25);
    }

    .confirm-section h2 {
      color: var(--brand-2);
      margin-bottom: 10px;
    }

    .confirm-section p {
      color: var(--muted);
      margin-bottom: 20px;
      font-size: 15px;
    }

    .confirm-card {
      background: var(--bg-soft);
      border: 1px solid var(--stroke);
      border-radius: 18px;
      box-shadow: var(--shadow);
      padding: 30px;
      margin-top: 30px;
      text-align: center;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .confirm-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .confirm-card img {
      width: 150px;
      height: auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
      margin-bottom: 14px;
    }

    .confirm-card h2 {
      color: var(--brand-2);
      margin: 8px 0;
    }

    .details {
      color: var(--text);
      font-size: 15px;
      margin-bottom: 6px;
    }

    .details strong {
      color: var(--muted);
    }

    .seat-badge {
      display: inline-block;
      margin: 4px;
      padding: 8px 12px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #fff;
      font-weight: 700;
      border-radius: 10px;
      font-size: 14px;
      box-shadow: 0 4px 10px rgba(255, 179, 0, 0.25);
    }

    .book-btn {
      margin-top: 30px;
      display: inline-block;
      text-decoration: none;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #fff !important;
      padding: 12px 22px;
      border-radius: 10px;
      font-weight: 700;
      box-shadow: 0 6px 14px rgba(255, 179, 0, 0.25);
      transition: 0.25s ease;
    }

    .book-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(255, 179, 0, 0.4);
    }

    @media (max-width: 600px) {
      .confirm-card img {
        width: 120px;
      }
      .confirm-section {
        margin: 40px auto;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="index.php" class="brand">
      <span class="brand-mark">🎬</span>
      <span class="brand-text">Movie<span>Time</span></span>
    </a>
    <div class="navbar-right">
      <div class="location-dropdown">
        👤 <?php echo htmlspecialchars($user_name); ?>
      </div>
      <a href="logout.php" class="login-btn">Logout</a>
    </div>
  </nav>

  <div class="confirm-section">
    <div class="success-banner">🎉 Booking Confirmed!</div>
    <h2>Thank you, <?php echo htmlspecialchars($user_name); ?>!</h2>
    <p>Your recent booking details are listed below:</p>

    <?php if(count($bookings) > 0): ?>
      <?php foreach($bookings as $b): ?>
        <div class="confirm-card">
          <img src="<?php echo htmlspecialchars($b['poster']); ?>" alt="<?php echo htmlspecialchars($b['title']); ?>">
          <h2><?php echo htmlspecialchars($b['title']); ?></h2>
          <div class="details"><strong>Cinema:</strong> <?php echo htmlspecialchars($b['cinema']); ?></div>
          <div class="details"><strong>Date:</strong> <?php echo htmlspecialchars($b['show_date']); ?></div>
          <div class="details"><strong>Time:</strong> <?php echo htmlspecialchars($b['show_time']); ?></div>
          <div class="details"><strong>Seat(s):</strong></div>
          <?php
            $seatsRes = $conn->query("SELECT seat_number FROM bookings WHERE user_id=$user_id AND showtime_id={$b['showtime_id']}");
            while($seat = $seatsRes->fetch_assoc()) {
              echo "<span class='seat-badge'>{$seat['seat_number']}</span>";
            }
          ?>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No recent bookings found.</p>
    <?php endif; ?>

    <a href="index.php" class="book-btn">🎟️ Book Another Ticket</a>
  </div>

</body>
</html>
