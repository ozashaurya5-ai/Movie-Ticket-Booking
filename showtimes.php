<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Showtimings | TRX Cinema</title>
  <link rel="stylesheet" href="style.css">

  <script>
  // 🎬 Search Functionality for Cinema or Movie Names
  document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".cinema-search input");
    const movieCards = document.querySelectorAll(".showtime-movie");

    searchInput.addEventListener("keyup", () => {
      const query = searchInput.value.toLowerCase().trim();

      movieCards.forEach((card) => {
        const title = card.querySelector("h2").textContent.toLowerCase();
        if (title.includes(query)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const dateButtons = document.querySelectorAll(".date-selector button");

    dateButtons.forEach(button => {
        button.addEventListener("click", () => {
            dateButtons.forEach(b => b.classList.remove("active"));
            button.classList.add("active");
        });
    });
});
</script>


  <style>
    /* Premium Styling */
    body {
      background: radial-gradient(1000px at 50% 0%, rgba(255,213,74,0.05), transparent 70%), var(--bg);
    }
    .showtime-header {
      text-align: center;
      margin: 60px 0 20px;
    }
    .showtime-header h2 {
      font-size: 36px;
      font-weight: 800;
      color: var(--brand);
    }
    .date-selector {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 26px;
    }
    .date-selector button {
      padding: 12px 18px;
      border-radius: 12px;
      border: 1px solid var(--stroke);
      background: var(--bg-soft);
      color: var(--text);
      font-weight: 700;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .date-selector button.active {
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #111;
      box-shadow: 0 4px 18px rgba(255,213,74,0.3);
    }

    .cinema-search {
      margin: 30px auto 10px;
      text-align: center;
    }
    .cinema-search input {
      padding: 12px 16px;
      width: min(360px, 90%);
      border-radius: 12px;
      border: 1px solid var(--stroke);
      background: rgba(255,255,255,0.07);
      color: var(--text);
      outline: none;
    }

    .legend {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      margin: 25px 0 50px;
    }
    .legend span {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: var(--muted);
    }
    .dot {
      width: 14px;
      height: 14px;
      border-radius: 50%;
    }
    .available { background: #4caf50; }
    .fast { background: #ffb300; }
    .sold { background: #f44336; }
    .lapsed { background: #9e9e9e; }

    .showtime-movie {
      width: min(1100px, 94vw);
      margin: 0 auto 40px;
      background: rgba(255,255,255,0.04);
      backdrop-filter: blur(14px);
      border-radius: 18px;
      padding: 26px;
      border: 1px solid var(--stroke);
      box-shadow: var(--shadow);
      transition: transform 0.3s ease;
    }
    .showtime-movie:hover {
      transform: translateY(-4px);
    }
    .showtime-header-box {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    .showtime-header-box img {
      width: 100px;
      height: 150px;
      object-fit: cover;
      border-radius: 12px;
      border: 1px solid var(--stroke);
    }
    .showtime-details {
      flex: 1;
    }
    .showtime-details h2 {
      margin: 0;
      font-size: 22px;
      color: var(--text);
    }
    .showtime-details p {
      margin: 6px 0;
      color: var(--muted);
      font-size: 14px;
    }
    .showtime-times {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 16px;
    }
    .showtime-times button {
      padding: 10px 14px;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: 0.2s ease;
    }
    .showtime-times button.available {
      background: #4caf50;
      color: #fff;
    }
    .showtime-times button.fast {
      background: #ffb300;
      color: #111;
    }
    .showtime-times button.sold {
      background: #f44336;
      color: #fff;
      cursor: not-allowed;
    }
    .showtime-times button.lapsed {
      background: #9e9e9e;
      color: #fff;
      cursor: not-allowed;
    }
    .showtime-times button:hover:not(.sold):not(.lapsed) {
      opacity: 0.85;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="index.php" class="brand">
      <span class="brand-text"><span>TRX</span> Cinema</span>
    </a>
    <div class="nav-links">
      <a href="index.php#now-showing">Now Showing</a>
      <a href="index.php#coming-soon">Coming Soon</a>
      <a href="index.php#experiences">Experiences</a>
      <a href="index.php#trailers">Trailers</a>
      <a href="index.php#offers">Offers</a>
      <a href="showtimes.html" class="active">Showtimings</a>
    </div>
  </nav>

  <!-- Header -->
  <div class="showtime-header">
    <h2>Showtimings</h2>
    <div class="date-selector">
      <button class="active">Oct 07<br><small>Today</small></button>
      <button>Oct 08<br><small>Tomorrow</small></button>
      <button>Oct 09<br><small>Thu</small></button>
      <button>Oct 10<br><small>Fri</small></button>
      <button>Oct 11<br><small>Sat</small></button>
    </div>

    <div class="cinema-search">
      <input type="text" placeholder="🔍 Search for cinema...">
    </div>

    <div class="legend">
      <span><div class="dot available"></div>Available</span>
      <span><div class="dot fast"></div>Filling Fast</span>
      <span><div class="dot sold"></div>Sold Out</span>
      <span><div class="dot lapsed"></div>Lapsed</span>
      <span>🎬 Subtitle</span>
      <span>♿ Accessibility</span>
    </div>
  </div>

  <!-- Movies -->
  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/kantara.jpg" alt="Kantara">
      <div class="showtime-details">
        <h2>KANTARA: A Legend Chapter 1 (UA 16+)</h2>
        <p>2h 49m • Hindi, Kannada • Action • Thriller</p>
        <div class="showtime-times">
          <button class="lapsed">09:25 AM</button>
          <button class="available">11:45 AM</button>
          <button class="fast">02:20 PM</button>
          <button class="available">04:55 PM</button>
          <button class="sold">09:30 PM</button>
        </div>
      </div>
    </div>
  </div>

  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/jawan.jpg" alt="Jawan">
      <div class="showtime-details">
        <h2>JAWAN</h2>
        <p>2h 45m • Hindi • Action • Drama</p>
        <div class="showtime-times">
          <button class="available">10:15 AM</button>
          <button class="available">01:00 PM</button>
          <button class="fast">04:00 PM</button>
          <button class="fast">07:15 PM</button>
          <button class="sold">10:30 PM</button>
        </div>
      </div>
    </div>
  </div>

  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/avatar2.jpg" alt="Avatar 2">
      <div class="showtime-details">
        <h2>Avatar: The Way of Water (3D)</h2>
        <p>3h 10m • English, Hindi • Sci-Fi • Adventure</p>
        <div class="showtime-times">
          <button class="available">09:45 AM</button>
          <button class="fast">01:30 PM</button>
          <button class="available">04:50 PM</button>
          <button class="sold">08:20 PM</button>
          <button class="available">10:00 PM</button>
        </div>
      </div>
    </div>
  </div>

  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/leo.jpg" alt="Leo">
      <div class="showtime-details">
        <h2>Leo</h2>
        <p>2h 35m • Tamil, Hindi • Action • Crime</p>
        <div class="showtime-times">
          <button class="available">10:10 AM</button>
          <button class="fast">12:30 PM</button>
          <button class="available">03:15 PM</button>
          <button class="available">06:30 PM</button>
          <button class="sold">09:45 PM</button>
        </div>
      </div>
    </div>
  </div>

  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/spiderman.jpg" alt="Spiderman">
      <div class="showtime-details">
        <h2>Spider-Man: Across the Spider-Verse</h2>
        <p>2h 10m • English, Hindi • Animation • Adventure</p>
        <div class="showtime-times">
          <button class="available">10:00 AM</button>
          <button class="available">01:00 PM</button>
          <button class="fast">04:30 PM</button>
          <button class="fast">07:30 PM</button>
          <button class="sold">10:15 PM</button>
        </div>
      </div>
    </div>
  </div>

  <div class="showtime-movie">
    <div class="showtime-header-box">
      <img src="images/singham3.jpg" alt="Singham 3">
      <div class="showtime-details">
        <h2>Singham 3</h2>
        <p>2h 20m • Hindi • Action • Drama</p>
        <div class="showtime-times">
          <button class="available">09:30 AM</button>
          <button class="fast">12:15 PM</button>
          <button class="available">03:30 PM</button>
          <button class="fast">06:45 PM</button>
          <button class="sold">09:55 PM</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-inner center">
      <p class="tiny">© 2025 TRX Cinema. All Rights Reserved.</p>
    </div>
  </footer>

</body>
</html>

