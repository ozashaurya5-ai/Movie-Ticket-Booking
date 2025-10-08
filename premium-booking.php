<?php
// Get movie name from URL (e.g., premium-booking.php?movie=Deadpool 3)
$movie = isset($_GET['movie']) ? htmlspecialchars($_GET['movie']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Premium Booking | CineStar</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: linear-gradient(135deg, #0b0e13, #121722);
      color: var(--text);
      font-family: "Inter", sans-serif;
    }
    .premium-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 40px 20px;
      text-align: center;
    }
    .premium-card {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid var(--stroke);
      border-radius: 20px;
      padding: 40px;
      box-shadow: var(--shadow);
      max-width: 600px;
      width: 100%;
    }
    .premium-card h2 {
      font-size: 32px;
      margin-bottom: 16px;
      color: var(--brand);
    }
    .premium-card p {
      color: var(--muted);
      margin-bottom: 28px;
    }
    .premium-form {
      display: grid;
      gap: 18px;
    }
    .premium-form select,
    .premium-form input {
      padding: 12px 16px;
      border-radius: 12px;
      border: 1px solid var(--stroke);
      background: var(--bg-soft);
      color: var(--text);
      outline: none;
      font-size: 15px;
      width: 100%;
    }
    .book-btn.big {
      padding: 14px 24px;
      font-size: 16px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #111;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 8px 22px rgba(255, 213, 74, 0.25);
      border: none;
      transition: transform 0.2s ease;
    }
    .book-btn.big:hover {
      transform: translateY(-1px);
    }
    .back-home {
      margin-top: 22px;
      display: inline-block;
      text-decoration: none;
      color: var(--muted);
    }
    .back-home:hover {
      color: var(--brand);
    }
  </style>
</head>
<body>
  <div class="premium-container">
    <div class="premium-card">
      <h2>🎟 Premium Movie Booking</h2>
      <p>Choose your showtime and confirm your seat in just one click.</p>

      <form class="premium-form" onsubmit="confirmBooking(event)">
        <select id="movie" required>
          <?php if ($movie): ?>
            <option selected><?= $movie ?></option>
          <?php else: ?>
            <option>Select Movie</option>
            <option>Deadpool 3</option>
            <option>Dune: Part Two</option>
            <option>Inside Out 2</option>
          <?php endif; ?>
        </select>

        <input type="date" id="date" required />

        <select id="cinema" required>
          <option>Select Cinema</option>
          <option>CineStar Plaza</option>
          <option>IMAX Downtown</option>
          <option>City Center Mall</option>
        </select>

        <select id="time" required>
          <option>Select Time</option>
          <option>10:00 AM</option>
          <option>1:30 PM</option>
          <option>4:45 PM</option>
          <option>8:15 PM</option>
        </select>

        <button class="book-btn big" type="submit">Confirm Booking</button>
      </form>

      <a href="index.php" class="back-home">← Back to Home</a>
    </div>
  </div>

  <script>
    function confirmBooking(e) {
      e.preventDefault();
      const movie = document.getElementById("movie").value;
      const date = document.getElementById("date").value;
      const cinema = document.getElementById("cinema").value;
      const time = document.getElementById("time").value;

      if (movie.includes("Select") || cinema.includes("Select") || time.includes("Select") || !date) {
        alert("Please fill all fields before confirming!");
        return;
      }

      const url = `seat-selection.php?movie=${encodeURIComponent(movie)}&date=${encodeURIComponent(date)}&cinema=${encodeURIComponent(cinema)}&time=${encodeURIComponent(time)}`;
        window.location.href = url;
    }
  </script>
</body>
</html>
