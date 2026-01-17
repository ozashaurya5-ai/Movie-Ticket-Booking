<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['showtime_id'])) {
    echo "<h2 style='color:red;text-align:center;'>No showtime selected!</h2>";
    exit;
}

$showtime_id = $_GET['showtime_id'];

// Fetch movie & showtime details
$sql = "SELECT m.title, s.show_date, s.show_time 
        FROM showtimes s 
        JOIN movies m ON s.movie_id = m.id 
        WHERE s.id = '$showtime_id'";
$result = mysqli_query($conn, $sql);
$show = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Seats | TRX Cinema</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: var(--bg);
      color: var(--text);
      font-family: "Poppins", sans-serif;
      margin: 0;
      padding: 0;
    }

    .seat-container {
      width: 90%;
      max-width: 900px;
      margin: 100px auto;
      text-align: center;
      background: var(--bg-soft);
      padding: 40px;
      border-radius: 18px;
      box-shadow: var(--shadow);
      border: 1px solid var(--stroke);
    }

    h2 {
      color: var(--brand);
      font-size: 26px;
      margin-bottom: 20px;
    }

    .screen {
      background: var(--brand);
      height: 10px;
      width: 80%;
      margin: 25px auto;
      border-radius: 6px;
      box-shadow: 0 0 12px rgba(255, 213, 74, 0.4);
    }

    p[style*="color:#aaa"] {
      color: var(--muted) !important;
    }

    .seat {
      display: inline-block;
      width: 34px;
      height: 34px;
      background: #444;
      margin: 4px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.2s;
      line-height: 34px;
      font-size: 13px;
      color: #fff;
      box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.5);
    }

    .seat:hover {
      transform: scale(1.1);
      background: var(--brand-2);
      color: #000;
    }

    .seat.selected {
      background: var(--brand);
      color: #000;
      font-weight: bold;
      box-shadow: 0 0 8px rgba(255, 213, 74, 0.5);
    }

    .seat.occupied {
      background: #777;
      color: #ccc;
      cursor: not-allowed;
    }

    .row-label {
      display: inline-block;
      width: 30px;
      font-weight: 600;
      color: var(--brand);
      margin-right: 4px;
    }

    .summary {
      margin-top: 30px;
      background: rgba(255, 255, 255, 0.05);
      padding: 16px;
      border-radius: 10px;
      display: inline-block;
      min-width: 240px;
      border: 1px solid var(--stroke);
      box-shadow: var(--shadow);
    }

    .summary p {
      margin: 8px 0;
      color: var(--text);
      font-size: 15px;
    }

    .summary span {
      color: var(--brand);
      font-weight: 700;
    }

    button {
      margin-top: 26px;
      padding: 12px 22px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #fff !important;
      font-weight: 700;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 6px 14px rgba(255, 213, 74, 0.3);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 18px rgba(255, 213, 74, 0.4);
    }

    @media (max-width: 600px) {
      .seat-container {
        padding: 24px;
      }
      .seat {
        width: 28px;
        height: 28px;
        line-height: 28px;
        font-size: 11px;
      }
    }
  </style>
</head>
<body>
  <?php include('navbar.php'); ?>

  <div class="seat-container">
    <h2><?= htmlspecialchars($show['title']) ?> — <?= htmlspecialchars($show['show_date']) ?> at <?= htmlspecialchars($show['show_time']) ?></h2>

    <div class="screen"></div>
    <p>(Screen This Way)</p>

    <div id="seatsArea">
      <?php
      // Fetch already booked seats
      $bookedSeatsQuery = mysqli_query($conn, "SELECT seat_number FROM bookings WHERE showtime_id='$showtime_id'");
      $bookedSeats = [];
      while ($row = mysqli_fetch_assoc($bookedSeatsQuery)) {
          $bookedSeats = array_merge($bookedSeats, explode(',', $row['seat_number']));
      }

      // Generate seats A–J, 1–10
      $rows = range('A', 'J');
      foreach ($rows as $rowLetter) {
          echo "<div class='row'>";
          echo "<span class='row-label'>$rowLetter</span>";
          for ($i = 1; $i <= 10; $i++) {
              $seatNo = $rowLetter . $i;
              $class = in_array($seatNo, $bookedSeats) ? "seat occupied" : "seat";
              echo "<div class='$class' data-seat='$seatNo'>$i</div>";
          }
          echo "</div>";
      }
      ?>
    </div>

    <div class="summary">
      <p>Selected Seats: <span id="selectedSeats">None</span></p>
      <p>Total Price: ₹<span id="totalPrice">0</span></p>
    </div>

    <form id="bookingForm" action="payment.php" method="POST">
      <input type="hidden" name="showtime_id" value="<?= htmlspecialchars($showtime_id) ?>">
      <input type="hidden" name="selected_seats" id="selected_seats">
      <input type="hidden" name="total_price" id="total_price">
      <button type="submit">Proceed to Payment</button>
    </form>
  </div>

  <script>
  const seatPrice = 200;
  const seats = document.querySelectorAll('.seat:not(.occupied)');
  const selectedSeatsInput = document.getElementById('selected_seats');
  const totalPriceInput = document.getElementById('total_price');
  const selectedSeatsText = document.getElementById('selectedSeats');
  const totalPriceText = document.getElementById('totalPrice');
  let selectedSeats = [];

  seats.forEach(seat => {
    seat.addEventListener('click', () => {
      const seatNo = seat.getAttribute('data-seat');
      if (seat.classList.contains('occupied')) return;
      seat.classList.toggle('selected');
      if (seat.classList.contains('selected')) selectedSeats.push(seatNo);
      else selectedSeats = selectedSeats.filter(s => s !== seatNo);
      const total = selectedSeats.length * seatPrice;
      selectedSeatsInput.value = selectedSeats.join(',');
      totalPriceInput.value = total;
      selectedSeatsText.innerText = selectedSeats.length ? selectedSeats.join(', ') : 'None';
      totalPriceText.innerText = total;
    });
  });

  document.getElementById('bookingForm').addEventListener('submit', (e) => {
    if (selectedSeats.length === 0) {
      e.preventDefault();
      alert('Please select at least one seat.');
    }
  });
  </script>
</body>
</html>
