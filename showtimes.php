<?php
include 'config.php';
session_start();

// Fetch all movies with showtimes
$sql = "SELECT m.id AS movie_id, m.title, m.poster, m.genre, m.duration, 
               s.id AS showtime_id, s.cinema, s.show_date, s.show_time
        FROM movies m
        JOIN showtimes s ON m.id = s.movie_id
        ORDER BY s.show_date, s.show_time";
$result = $conn->query($sql);

// Group showtimes by movie
$movies = [];
while ($row = $result->fetch_assoc()) {
  $movies[$row['movie_id']]['title'] = $row['title'];
  $movies[$row['movie_id']]['poster'] = $row['poster'];
  $movies[$row['movie_id']]['genre'] = $row['genre'];
  $movies[$row['movie_id']]['duration'] = $row['duration'];
  $movies[$row['movie_id']]['showtimes'][] = [
    'id' => $row['showtime_id'],
    'cinema' => $row['cinema'],
    'show_date' => $row['show_date'],
    'show_time' => $row['show_time']
  ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Showtimes - MovieTime</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="css/theme-overrides.css" />

  <style>
    body {
      background: linear-gradient(180deg, #f8fafc 0%, #eef3ff 100%);
      font-family: 'Poppins', sans-serif;
      color: #0f172a;
      margin: 0;
      padding: 0;
    }

    .showtimes-section {
      width: min(1100px, 92vw);
      margin: 60px auto;
    }

    .showtimes-section h2 {
      text-align: center;
      color: #0b63ff;
      margin-bottom: 40px;
      font-size: 32px;
      font-weight: 700;
    }

    .movie-block {
      display: flex;
      gap: 26px;
      margin-bottom: 40px;
      padding: 20px;
      border: 1px solid rgba(15,23,42,0.1);
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(15,23,42,0.06);
      transition: all 0.25s ease;
    }

    .movie-block:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 28px rgba(15,23,42,0.1);
    }

    .movie-block img {
      width: 180px;
      height: 260px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .movie-info {
      flex: 1;
      color: #334155;
    }

    .movie-info h3 {
      color: #0b63ff;
      margin: 0 0 8px;
      font-size: 22px;
    }

    .movie-meta {
      color: #64748b;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .showtime-list {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .showtime-tag {
      
      color: #ffffff !important;
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
      transition: all 0.2s ease;
      box-shadow: 0 4px 10px rgba(11,99,255,0.2);
    }

    .showtime-tag:hover {
      transform: translateY(-2px);
      background: #0846c6;
      color: #ffffff !important;
      box-shadow: 0 6px 14px rgba(11,99,255,0.25);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .movie-block {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }
      .movie-block img {
        width: 60%;
        height: auto;
      }
      .showtime-list {
        justify-content: center;
      }
    }

    /* Navbar Fix */
    .navbar {
      background: #ffffff;
      box-shadow: 0 2px 8px rgba(15,23,42,0.05);
    }
    .navbar a {
      color: #0f172a;
    }
    .navbar a:hover {
      color: #0b63ff;
    }
    .navbar-right .location-dropdown {
      color: #0f172a !important;
      background: #ffffff;
      border-radius: 20px;
      padding: 6px 12px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.08);
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

    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="showtimes.php">Showtimes</a>
    </div>

    <div class="navbar-right">
      <?php if(isset($_SESSION["user_id"])): ?>
        <div class="location-dropdown">
          👤 <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
        </div>
        <a href="logout.php" class="login-btn">Logout</a>
      <?php else: ?>
        <a href="login.php" class="login-btn">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- Showtimes Section -->
  <section class="showtimes-section">
    <h2>🎟️ Movie Showtimes</h2>
    <?php if (!empty($movies)): ?>
      <?php foreach ($movies as $id => $m): ?>
        <div class="movie-block">
          <img src="<?php echo htmlspecialchars($m['poster']); ?>" alt="<?php echo htmlspecialchars($m['title']); ?>">
          <div class="movie-info">
            <h3><?php echo htmlspecialchars($m['title']); ?></h3>
            <div class="movie-meta"><?php echo htmlspecialchars($m['genre']); ?> • <?php echo htmlspecialchars($m['duration']); ?></div>
            <div class="showtime-list">
              <?php foreach ($m['showtimes'] as $s): ?>
                <a href="seat-selection.php?showtime_id=<?php echo $s['id']; ?>" class="showtime-tag">
                  <?php echo htmlspecialchars($s['cinema']); ?> — 
                  <?php echo htmlspecialchars(date("M d", strtotime($s['show_date']))); ?> 
                  • <?php echo date("h:i A", strtotime($s['show_time'])); ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; color:#64748b;">No showtimes available right now.</p>
    <?php endif; ?>
  </section>

</body>
</html>
