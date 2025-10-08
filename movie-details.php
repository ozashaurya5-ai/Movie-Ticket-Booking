<!-- movie-details.php -->
<?php
$movie = isset($_GET['movie']) ? htmlspecialchars($_GET['movie']) : 'Unknown Movie';

// Demo movie data (can later come from a database)
$movies = [
  "War 2" => [
    "poster" => "https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/28727_bBwcaxjU.jpeg",
    "desc" => "Wade Wilson returns in Marvel’s wildest, funniest adventure yet.",
    "trailer" => "https://www.youtube.com/embed/mjBym9uKth4?si=-GuCga3PooyUmQtL"
  ],
  "Dune: Part Two" => [
    "poster" => "https://i.imgur.com/KDh7bNH.jpg",
    "desc" => "Paul Atreides unites with the Fremen to avenge his family and save Arrakis.",
    "trailer" => "https://www.youtube.com/embed/U2Qp5pL3ovA"
  ],
  "Inside Out 2" => [
    "poster" => "https://i.imgur.com/YZSPj5G.jpg",
    "desc" => "Join Riley and her emotions as they navigate a whole new set of feelings.",
    "trailer" => "https://www.youtube.com/embed/LEjhY15eCx0"
  ]
];

$data = $movies[$movie] ?? [
  "poster" => "https://via.placeholder.com/400x600?text=No+Image",
  "desc" => "Movie details not found.",
  "trailer" => ""
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $movie ?> | CineStar</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .details-hero {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      background: linear-gradient(135deg, #0b0e13, #121722);
      color: var(--text);
      padding: 60px 20px;
    }
    .details-card {
      max-width: 800px;
      width: 100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--stroke);
      border-radius: 20px;
      padding: 30px;
      box-shadow: var(--shadow);
    }
    .details-card img {
      width: 280px;
      border-radius: 16px;
      box-shadow: 0 10px 35px rgba(0,0,0,0.4);
      margin-bottom: 20px;
    }
    iframe {
      width: 100%;
      max-width: 700px;
      height: 390px;
      border-radius: 14px;
      margin: 24px 0;
      border: none;
    }
    .book-btn.big {
      padding: 14px 28px;
      font-size: 16px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--brand), var(--brand-2));
      color: #111;
      font-weight: 800;
      cursor: pointer;
      text-decoration: none;
      box-shadow: 0 8px 22px rgba(255, 213, 74, 0.25);
    }
    .book-btn.big:hover {
      transform: translateY(-1px);
    }
    .back-home {
      display: inline-block;
      margin-top: 20px;
      color: var(--muted);
      text-decoration: none;
    }
    .back-home:hover {
      color: var(--brand);
    }
  </style>
</head>
<body>
  <div class="details-hero">
    <div class="details-card">
      <h1><?= $movie ?></h1>
      <img src="<?= $data['poster'] ?>" alt="<?= $movie ?>">
      <p><?= $data['desc'] ?></p>
      <?php if ($data['trailer']): ?>
        <iframe src="<?= $data['trailer'] ?>" allowfullscreen></iframe>
      <?php endif; ?>

      <a href="premium-booking.php?movie=<?= urlencode($movie) ?>" class="book-btn big">Book Ticket</a>
      <br>
      <a href="index.php" class="back-home">← Back to Home</a>
    </div>
  </div>
</body>
</html>
