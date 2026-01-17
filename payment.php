<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $showtime_id = $_POST['showtime_id'];
  $selected_seats = $_POST['selected_seats'];
  $total_price = $_POST['total_price'];
  $payment_screenshot = '';

  if (!empty($_FILES['payment_screenshot']['name'])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
    $fileName = time() . "_" . basename($_FILES['payment_screenshot']['name']);
    $targetFilePath = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $targetFilePath)) {
      $payment_screenshot = $fileName;
    }
  }

  if (isset($_POST['confirm_payment'])) {
    $sql = "INSERT INTO bookings (user_id, showtime_id, seat_number, total_price, payment_method, payment_screenshot, payment_status, booking_time)
            VALUES ('$user_id', '$showtime_id', '$selected_seats', '$total_price', 'QR Payment', '$payment_screenshot', 'Pending', NOW())";
    if (mysqli_query($conn, $sql)) {
      header("Location: my-bookings.php?success=1");
      exit;
    } else {
      echo "<p style='color:red;text-align:center;'>Database Error: " . mysqli_error($conn) . "</p>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment | MovieTime</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: var(--bg);
      color: var(--text);
      font-family: "Inter", sans-serif;
      margin: 0;
      padding: 0;
    }

    .payment-container {
      width: min(600px, 92vw);
      margin: 80px auto;
      background: var(--bg-soft);
      border: 1px solid var(--stroke);
      border-radius: 18px;
      box-shadow: var(--shadow);
      padding: 30px;
      text-align: center;
    }

    h2 {
      color: var(--brand-2);
      margin-bottom: 18px;
    }

    .qr {
      width: 220px;
      height: 220px;
      margin: 20px auto;
      border-radius: 12px;
      border: 2px solid var(--brand);
      box-shadow: 0 6px 18px rgba(255, 179, 0, 0.25);
      display: block;
    }

    .payment-container p {
      color: var(--muted);
      font-size: 15px;
      margin-bottom: 10px;
    }

    strong {
      color: var(--brand-2);
    }

    input[type="file"] {
      width: 100%;
      margin-top: 14px;
      padding: 10px 12px;
      border-radius: 10px;
      border: 1px solid var(--stroke);
      background: var(--bg);
      color: var(--text);
      cursor: pointer;
      font-size: 14px;
    }

    button {
      margin-top: 18px;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #fff;
      font-weight: 700;
      font-size: 15px;
      cursor: pointer;
      box-shadow: 0 6px 18px rgba(255, 179, 0, 0.25);
      transition: 0.25s ease;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(255, 179, 0, 0.4);
    }

    .info {
      color: var(--muted);
      font-size: 14px;
      margin-top: 14px;
    }
  </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="payment-container">
  <h2>Complete Your Payment</h2>

  <p>Total Amount: <strong>₹<?= htmlspecialchars($_POST['total_price'] ?? 0) ?></strong></p>
  <p>Selected Seats: <strong><?= htmlspecialchars($_POST['selected_seats'] ?? '') ?></strong></p>

  <p>Scan the QR code below to make your payment.</p>
  <img src="images/qr-code.png" alt="QR Code" class="qr">

  <p class="info">After completing the payment, please upload a screenshot below.</p>

  <form action="payment.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="showtime_id" value="<?= htmlspecialchars($_POST['showtime_id'] ?? '') ?>">
      <input type="hidden" name="selected_seats" value="<?= htmlspecialchars($_POST['selected_seats'] ?? '') ?>">
      <input type="hidden" name="total_price" value="<?= htmlspecialchars($_POST['total_price'] ?? 0) ?>">

      <input type="file" name="payment_screenshot" accept="image/*" required>
      <button type="submit" name="confirm_payment">Confirm Payment</button>
  </form>

  <p class="info">Once uploaded, your payment will be verified by the admin.</p>
</div>

</body>
</html>
