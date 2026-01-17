<?php
include 'config.php';
session_start();

// Fetch featured movies for hero slider
$featured = $conn->query("SELECT * FROM movies ORDER BY release_date DESC LIMIT 5");
$today = date("Y-m-d");
$nowShowing = $conn->query("SELECT * FROM movies WHERE release_date <= '$today' ORDER BY release_date DESC");
$trailers = $conn->query("SELECT * FROM movies WHERE trailer_url IS NOT NULL AND trailer_url <> '' ORDER BY release_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MovieTime - Home</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <style>
    /* NAVBAR */
    .navbar {
      background: #fff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 6%;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .navbar .brand {
      font-size: 1.5rem;
      font-weight: 700;
      text-decoration: none;
      color: #0f172a;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .navbar .brand span span {
      color: #0b63ff;
    }
    .nav-links {
      display: flex;
      gap: 18px;
      align-items: center;
    }
    .nav-links a {
      text-decoration: none;
      color: #334155;
      font-weight: 500;
      transition: 0.3s;
    }
    .nav-links a:hover {
      color: #0b63ff;
    }
    .navbar-right {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .login-btn {
      background: #0b63ff;
      color: #fff !important;
      padding: 6px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .login-btn:hover {
      background: #004fc2;
    }

    /* HERO SECTION */
.hero {
  width: 100%;
  position: relative;
  overflow: hidden;
}

.swiper {
  width: 100%;
  height: 85vh;
}

.swiper-slide {
  position: relative;
  background-size: cover;
  background-position: center;
}

/* Dark cinematic overlay */
.slide-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    120deg,
    rgba(15, 23, 42, 0.85),
    rgba(15, 23, 42, 0.4)
  );
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
}

.slide-content {
  max-width: 1100px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  background: rgba(255, 255, 255, 0.12);
  backdrop-filter: blur(12px);
  border-radius: 22px;
  padding: 40px;
  box-shadow: 0 20px 50px rgba(0,0,0,0.35);
}

.slide-text {
  flex: 1;
  color: #fff;
}

.slide-text h2 {
  font-size: 2.5rem;
  margin-bottom: 12px;
  color: #ffffff;
}

.slide-text p {
  font-size: 15px;
  line-height: 1.7;
  margin-bottom: 22px;
  color: #e5e7eb;
}

.slide-text a {
  display: inline-block;
  background: #0b63ff;
  color: #fff;
  padding: 12px 26px;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  transition: 0.3s;
}

.slide-text a:hover {
  background: #004fc2;
  transform: translateY(-2px);
}

.slide-img img {
  width: 260px;
  border-radius: 18px;
  box-shadow: 0 12px 35px rgba(0,0,0,0.45);
  transition: 0.3s;
}

.slide-img img:hover {
  transform: scale(1.05);
}

/* MOBILE RESPONSIVE */
@media (max-width: 900px) {
  .swiper {
    height: 75vh;
  }

  .slide-content {
    flex-direction: column-reverse;
    text-align: center;
    padding: 28px;
  }

  .slide-img img {
    width: 200px;
  }

  .slide-text h2 {
    font-size: 2rem;
  }
}


    /* NOW SHOWING */
    .now-showing {
      background: #fff;
      padding: 60px 20px;
    }
    .section-inner {
      max-width: 1200px;
      margin: auto;
    }
    .section-title {
      text-align: center;
      color: #0b63ff;
      margin-bottom: 30px;
      font-size: 28px;
      font-weight: 700;
    }
    .movie-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill,minmax(240px,1fr));
      gap: 24px;
    }
    .movie-card-mini {
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      overflow: hidden;
      text-align: center;
      transition: all 0.2s ease;
      box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    }
    .movie-card-mini:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .movie-card-mini img {
      width: 100%;
      height: 320px;
      object-fit: cover;
    }
    .movie-card-mini h3 {
      color: #0b63ff;
      margin: 8px 0;
    }
    .movie-card-mini p {
      color: #64748b;
      font-size: 14px;
      padding: 0 10px;
    }
    .movie-card-mini a {
      background: #0b63ff;
      color: #fff;
      padding: 8px 16px;
      border-radius: 8px;
      display: inline-block;
      margin-top: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    .movie-card-mini a:hover {
      background: #004fc2;
    }

    /* EXPERIENCES */
    .experiences {
      margin-top: 60px;
      background: #f8fafc;
      padding: 60px 20px;
    }
    .experience-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 28px;
    }
    .experience-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      transition: 0.2s;
    }
    .experience-card:hover {
      transform: translateY(-5px);
    }
    .experience-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .experience-card h3 {
      color: #0b63ff;
      margin: 8px 0;
    }
    .experience-card p {
      color: #64748b;
      font-size: 14px;
    }

    /* TRAILERS */
    .trailers {
      padding: 60px 20px;
      background: #ffffff;
    }
    .trailer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill,minmax(320px,1fr));
      gap: 28px;
    }
    .trailer-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .trailer-card h3 {
      color: #0b63ff;
      text-align: center;
      margin: 10px 0;
    }
  </style>
</head>
<body style="background:#ffffff; color:#0f172a; font-family:'Poppins', sans-serif;">

  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="index.php" class="brand">🎬 Movie<span>Time</span></a>

    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="showtimes.php">Showtimes</a>
      <a href="#nowshowing">Now Showing</a>
      <a href="#experiences">Experiences</a>
      <a href="#trailers">Trailers</a>
      <a href="my-bookings.php">My Bookings</a>
      <a href="contact.php">Contact</a>
    </div>

    <div class="navbar-right">
      <?php if(isset($_SESSION["user_id"])): ?>
        <div class="location-dropdown">👤 <?= htmlspecialchars($_SESSION["user_name"]) ?></div>
        <a href="logout.php" class="login-btn">Logout</a>
      <?php else: ?>
        <a href="login.php" class="login-btn">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php while($f = $featured->fetch_assoc()): ?>
        <div class="swiper-slide" style="background-image:url('<?php echo htmlspecialchars($f['banner']); ?>');">
          <div class="slide-overlay">
            <div class="slide-content">
              <div class="slide-text">
                <h2><?= htmlspecialchars($f['title']) ?></h2>
                <p><?= htmlspecialchars(substr($f['description'], 0, 180)) ?>...</p>
                <a href="movie-details.php?id=<?= $f['id'] ?>">Book Now</a>
              </div>
              <div class="slide-img">
                <img src="<?= htmlspecialchars($f['poster']); ?>" alt="<?= htmlspecialchars($f['title']); ?>">
              </div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>

      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>

  <!-- NOW SHOWING -->
  <section id="nowshowing" class="now-showing">
    <div class="section-inner">
      <h2 class="section-title">🎥 Now Showing</h2>
      <?php if ($nowShowing->num_rows > 0): ?>
        <div class="movie-grid">
          <?php while($m = $nowShowing->fetch_assoc()): ?>
            <div class="movie-card-mini">
              <img src="<?= htmlspecialchars($m['poster']); ?>" alt="<?= htmlspecialchars($m['title']); ?>">
              <div style="padding:12px;">
                <h3><?= htmlspecialchars($m['title']); ?></h3>
                <p><?= htmlspecialchars(substr($m['description'], 0, 90)); ?>...</p>
                <a href="movie-details.php?id=<?= $m['id']; ?>">Book Now</a>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p style="text-align:center; color:#64748b;">No movies currently showing.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- EXPERIENCES -->
  <section id="experiences" class="experiences">
    <div class="section-inner">
      <h2 class="section-title">🎭 Movie Experiences</h2>
      <div class="experience-grid">
        <div class="experience-card">
          <img src="images/imax.jpg" alt="IMAX Experience">
          <div style="padding:16px;">
            <h3>IMAX Experience</h3>
            <p>Ultra-high resolution, immersive sound, and larger-than-life screens. Feel every heartbeat of action!</p>
          </div>
        </div>
        <div class="experience-card">
          <img src="images/4dx.jpg" alt="4DX Experience">
          <div style="padding:16px;">
            <h3>4DX Motion Seats</h3>
            <p>Feel the wind, smell the rain, and move with the action in a fully immersive 4DX experience.</p>
          </div>
        </div>
        <div class="experience-card">
          <img src="images/goldclass.jpg" alt="Gold Class">
          <div style="padding:16px;">
            <h3>Gold Class Luxury</h3>
            <p>Luxury recliners, fine dining, and personalized service — perfect for a premium movie night!</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TRAILERS -->
  <section id="trailers" class="trailers">
    <div class="section-inner">
      <h2 class="section-title">🎞️ Latest Trailers</h2>
      <?php if ($trailers->num_rows > 0): ?>
        <div class="trailer-grid">
          <?php while($t = $trailers->fetch_assoc()): ?>
            <div class="trailer-card">
              <div style="position:relative; padding-top:56.25%; overflow:hidden;">
                <iframe src="<?= htmlspecialchars($t['trailer_url']); ?>" title="<?= htmlspecialchars($t['title']); ?> Trailer" frameborder="0" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;"></iframe>
              </div>
              <h3><?= htmlspecialchars($t['title']); ?></h3>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p style="text-align:center; color:#64748b;">No trailers available at the moment.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- FOOTER -->
  <?php include('footer.php'); ?>

  <script>
    const swiper = new Swiper(".mySwiper", {
      spaceBetween: 30,
      effect: "fade",
      autoplay: { delay: 4000 },
      pagination: { el: ".swiper-pagination", clickable: true },
      navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
  </script>
</body>
</html>
