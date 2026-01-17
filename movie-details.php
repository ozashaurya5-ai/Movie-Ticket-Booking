<?php
include 'config.php';
session_start();

if (!isset($_GET['id'])) {
  die("Movie not found.");
}
$movie_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

if (!$movie) {
  die("Movie not found in database.");
}

$showtimes = $conn->query("SELECT * FROM showtimes WHERE movie_id = $movie_id ORDER BY show_date, show_time");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($movie['title']); ?> - MovieTime</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'Poppins', sans-serif;
    }

    .movie-detail {
      width: min(1100px, 92vw);
      margin: 60px auto;
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      align-items: flex-start;
      background: var(--bg-soft);
      border: 1px solid var(--stroke);
      border-radius: 16px;
      padding: 30px;
      box-shadow: var(--shadow);
    }

    .movie-detail img {
      width: 340px;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.15);
      border: 1px solid var(--stroke);
    }

    .movie-info {
      flex: 1;
    }

    .movie-info h2 {
      color: var(--brand);
      font-size: 38px;
      margin-bottom: 10px;
    }

    .info-line {
      color: var(--text);
      font-size: 15px;
      margin-bottom: 6px;
    }

    .movie-info p {
      line-height: 1.7;
      color: var(--muted);
      font-size: 15px;
      margin-top: 14px;
    }

    iframe {
      width: 100%;
      height: 360px;
      border-radius: 14px;
      margin-top: 20px;
      border: none;
      box-shadow: 0 8px 22px rgba(0, 0, 0, 0.1);
    }

    .showtimes {
      margin-top: 36px;
    }

    .showtimes h3 {
      color: var(--brand);
      margin-bottom: 12px;
      font-size: 20px;
    }

    .showtime-card {
      background: var(--bg-soft);
      border: 1px solid var(--stroke);
      border-radius: 14px;
      padding: 18px 20px;
      margin-bottom: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: box-shadow 0.2s ease, transform 0.15s ease;
    }

    .showtime-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    }

    .showtime-info {
      font-size: 15px;
      color: var(--muted);
      line-height: 1.6;
    }

    .book-btn.small {
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #111;
      border-radius: 10px;
      padding: 8px 14px;
      text-decoration: none;
      font-weight: 700;
      transition: transform 0.15s ease, box-shadow 0.2s ease;
      box-shadow: 0 4px 12px rgba(255, 179, 0, 0.25);
    }

    .book-btn.small:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(255, 179, 0, 0.35);
    }

    @media (max-width: 768px) {
      .movie-detail {
        flex-direction: column;
        text-align: center;
        padding: 20px;
      }
      .movie-detail img {
        width: 100%;
        max-width: 320px;
        margin: 0 auto;
      }
      iframe {
        height: 280px;
      }
    }
  </style>
</head>
<body>

<?php include('navbar.php'); ?>

<section class="movie-detail">
  <img src="<?php echo htmlspecialchars($movie['poster']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">

  <div class="movie-info">
    <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
    <div class="info-line"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></div>
    <div class="info-line"><strong>Duration:</strong> <?php echo htmlspecialchars($movie['duration']); ?></div>
    <div class="info-line"><strong>Rating:</strong> ⭐ <?php echo htmlspecialchars($movie['rating']); ?></div>
    <div class="info-line"><strong>Release Date:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></div>

    <p><?php echo htmlspecialchars($movie['description']); ?></p>

    <?php if(!empty($movie['trailer_url'])): ?>
      <iframe src="<?php echo htmlspecialchars($movie['trailer_url']); ?>" title="Trailer" allowfullscreen></iframe>
    <?php endif; ?>

    <div class="showtimes">
      <h3>Available Showtimes</h3>
      <?php if ($showtimes->num_rows > 0): ?>
        <?php while($s = $showtimes->fetch_assoc()): ?>
          <div class="showtime-card">
            <div class="showtime-info">
              <div><strong>Cinema:</strong> <?php echo htmlspecialchars($s['cinema']); ?></div>
              <div><strong>Date:</strong> <?php echo htmlspecialchars($s['show_date']); ?></div>
              <div><strong>Time:</strong> <?php echo htmlspecialchars($s['show_time']); ?></div>
            </div>
            <a href="seat-selection.php?showtime_id=<?php echo $s['id']; ?>" class="book-btn small">Select Seat</a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="color: var(--muted); margin-top:10px;">No showtimes available yet.</p>
      <?php endif; ?>
    </div>
  </div>
</section>
</body>
</html>
