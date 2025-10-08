<?php
$movie = $_GET['movie'] ?? 'Unknown Movie';
$date = $_GET['date'] ?? '';
$cinema = $_GET['cinema'] ?? '';
$time = $_GET['time'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Seats | <?= htmlspecialchars($movie) ?></title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: linear-gradient(135deg, #0b0e13, #121722);
      color: var(--text);
      font-family: "Inter", sans-serif;
    }

    .seat-container {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
      text-align: center;
    }

    .seat-header {
      margin-bottom: 40px;
    }

    .screen {
      width: 80%;
      height: 14px;
      background: var(--brand);
      border-radius: 6px;
      margin: 30px auto;
      box-shadow: 0 0 25px rgba(255,213,74,0.4);
    }

    .seat-grid {
      display: grid;
      grid-template-columns: 40px repeat(10, 1fr);
      gap: 10px;
      justify-content: center;
    }

    .row-label {
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted);
      font-weight: 600;
    }

    .seat {
      width: 36px;
      height: 36px;
      border-radius: 6px;
      background: rgba(255,255,255,0.08);
      border: 1px solid var(--stroke);
      cursor: pointer;
      transition: 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      color: var(--muted);
    }

    .seat:hover {
      background: rgba(255,255,255,0.15);
    }

    .seat.selected {
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      border-color: var(--brand);
      color: #111;
      font-weight: 700;
    }

    .seat.occupied {
      background: #444;
      cursor: not-allowed;
      opacity: 0.5;
      color: #777;
    }

    .legend {
      display: flex;
      gap: 20px;
      justify-content: center;
      color: var(--muted);
      margin: 20px 0;
    }

    .legend div {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .legend .box {
      width: 20px;
      height: 20px;
      border-radius: 4px;
    }

    .summary {
      margin-top: 30px;
      font-size: 18px;
      color: var(--muted);
    }

    .confirm-btn {
      margin-top: 20px;
      padding: 14px 26px;
      font-size: 16px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #111;
      font-weight: 800;
      cursor: pointer;
      border: none;
      box-shadow: 0 8px 22px rgba(255, 213, 74, 0.25);
      transition: transform 0.2s ease;
    }

    .confirm-btn:hover {
      transform: translateY(-1px);
    }

    .back-home {
      margin-top: 18px;
      display: inline-block;
      color: var(--muted);
      text-decoration: none;
    }

    .back-home:hover {
      color: var(--brand);
    }

    @media (max-width: 720px) {
      .seat {
        width: 28px;
        height: 28px;
        font-size: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="seat-container">
    <div class="seat-header">
      <h2>🎬 <?= htmlspecialchars($movie) ?></h2>
      <p><?= htmlspecialchars($cinema) ?> | <?= htmlspecialchars($date) ?> | <?= htmlspecialchars($time) ?></p>
    </div>

    <div class="screen"></div>

    <div class="legend">
      <div><div class="box" style="background: rgba(255,255,255,0.08);"></div>Available</div>
      <div><div class="box" style="background: linear-gradient(135deg, var(--brand), var(--brand-2));"></div>Selected</div>
      <div><div class="box" style="background: #444;"></div>Occupied</div>
    </div>

    <div class="seat-grid" id="seatGrid"></div>

    <div class="summary" id="summary">
      🎟 Selected Seats: <strong id="count">0</strong> | 💰 Total: ₹<strong id="price">0</strong>
    </div>

    <button class="confirm-btn" onclick="finalConfirm()">Confirm Seats</button>
    <a href="index.php" class="back-home">← Back to Home</a>
  </div>

  <script>
    const seatGrid = document.getElementById("seatGrid");
    const priceEl = document.getElementById("price");
    const countEl = document.getElementById("count");
    const seatPrice = 220; // price per seat
    const rows = ["A","B","C","D","E","F","G","H"];
    const cols = 10;

    // Create grid with labels
    rows.forEach((r) => {
      for (let c = 0; c <= cols; c++) {
        if (c === 0) {
          const label = document.createElement("div");
          label.className = "row-label";
          label.textContent = r;
          seatGrid.appendChild(label);
        } else {
          const seat = document.createElement("div");
          seat.className = "seat";
          seat.textContent = c;
          // Random occupied seats for demo
          if (Math.random() < 0.1) seat.classList.add("occupied");
          seat.addEventListener("click", () => {
            if (!seat.classList.contains("occupied")) {
              seat.classList.toggle("selected");
              updateSummary();
            }
          });
          seatGrid.appendChild(seat);
        }
      }
    });

    function updateSummary() {
      const selectedSeats = document.querySelectorAll(".seat.selected");
      const count = selectedSeats.length;
      const total = count * seatPrice;
      countEl.textContent = count;
      priceEl.textContent = total;
    }

    function finalConfirm() {
      const selectedSeats = [...document.querySelectorAll(".seat.selected")].map(seat => seat.parentNode ? seat.parentNode.textContent.trim() : "");
      const count = document.querySelectorAll(".seat.selected").length;
      if (count === 0) {
        alert("Please select at least one seat!");
        return;
      }
      alert(`✅ Booking Confirmed!\n\n🎬 Movie: <?= addslashes($movie) ?>\n🕓 Time: <?= addslashes($time) ?>\n\nSeats: ${count}\nTotal: ₹${count * seatPrice}`);
      window.location.href = "index.php";
    }
  </script>
</body>
</html>
