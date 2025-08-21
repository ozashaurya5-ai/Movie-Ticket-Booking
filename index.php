<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>TRX — Theatre Real eXperience</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

  <!-- Swiper -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

  <!-- Styles -->
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <!-- Header / Navbar -->
  <header class="navbar">
    <div class="navbar-left">
      <a href="#" class="brand">
        <span class="brand-mark">🎬</span>
        <span class="brand-text">TRX</span>
      </a>

      <nav class="nav-links">
        <a class="home" href="#"><i class="ri-home-5-line"></i> Home</a>
        <a class="showtimings" href="#showtimes"><i class="ri-film-line"></i> Showtimes</a>
        <a class="cinemas" href="#cinemas"><i class="ri-clapperboard-line"></i> Cinemas</a>
        <a class="order_food" href="#order_food"><i class="ri-goblet-line"></i> Order Food</a>

        <div class="dropdown">
          <button class="dropbtn" aria-haspopup="true" aria-expanded="false">
            <i class="ri-star-smile-line"></i> More <i class="ri-arrow-down-s-line"></i>
          </button>
          <div id="dropdown-content" class="dropdown-content" role="menu">
            <a href="#offers" role="menuitem"><i class="ri-gift-line"></i> Offers</a>
            <a href="#food" role="menuitem"><i class="ri-cup-line"></i> Food & Drinks</a>
            <a href="#help" role="menuitem"><i class="ri-customer-service-2-line"></i> Help</a>
          </div>
        </div>
      </nav>
    </div>

    <div class="navbar-right">
      <div class="search-wrap">
        <i class="ri-search-line"></i>
        <input class="search" type="text" placeholder="Search movies, cinemas…" />
      </div>

      <div class="location-dropdown">
        <i class="ri-map-pin-2-line"></i>
        <select aria-label="Select Location">
          <option>Ahmedabad</option>
          <option>Mumbai</option>
          <option>Delhi</option>
          <option>Bengaluru</option>
        </select>
      </div>

      <button id="themeToggle" class="icon-btn" aria-label="Toggle theme">
        <i class="ri-moon-line"></i>
      </button>

      <button id="loginOpen" class="login-btn">
        <i class="ri-user-3-line"></i> Login
      </button>
    </div>
  </header>

  <!-- Hero Swiper -->
  <section class="hero">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide" style="--bg:url('https://images.unsplash.com/photo-1542204625-de6161c72a5d?q=80&w=1600&auto=format&fit=crop');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>Midnight Heist</h2>
              <p>A crew of misfits pulls off the most daring vault break-in of the decade. Time is ticking. Stakes are sky-high.</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?q=80&w=900&auto=format&fit=crop" alt="Midnight Heist Poster">
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide" style="--bg:url('https://images.unsplash.com/photo-1535016120720-40c646be5580?q=80&w=1600&auto=format&fit=crop');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>Galactic Drift</h2>
              <p>Across nebulas and wormholes, two pilots race to save a splintered federation in this space-opera spectacle.</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=900&auto=format&fit=crop" alt="Galactic Drift Poster">
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide" style="--bg:url('https://images.unsplash.com/photo-1495567720989-cebdbdd97913?q=80&w=1600&auto=format&fit=crop');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>Echoes of Dawn</h2>
              <p>A music prodigy returns home to face the past that made her. Notes, nostalgia, and new beginnings.</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://images.unsplash.com/photo-1515169067865-5387ec356754?q=80&w=900&auto=format&fit=crop" alt="Echoes of Dawn Poster">
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>

      <!-- Quick Book -->
      <div id="quick-book" class="quick-book-row">
        <div class="quick-book" role="form" aria-label="Quick Book">
          <h3>Quick Book</h3>

          
          <div class="toggle-btns" role="tablist">
            <button class="active" onclick="setToggle(this)" role="tab" aria-selected="true">Movies</button>
            <button onclick="setToggle(this)" role="tab" aria-selected="false">Cinemas</button>
          </div>
    

          <select id="movie">
            <option>Select Movie</option>
            <option>Midnight Heist</option>
            <option>Galactic Drift</option>
            <option>Echoes of Dawn</option>
          </select>

          <select id="date">
            <option>Select Date</option>
            <option>Today</option>
            <option>Tomorrow</option>
            <option>Weekend</option>
          </select>

          <select id="cinema">
            <option>Select Cinema</option>
            <option>City Centre</option>
            <option>Riverview Mall</option>
            <option>Grand IMAX</option>
          </select>

          <select id="time">
            <option>Select Time</option>
            <option>10:00 AM</option>
            <option>01:30 PM</option>
            <option>07:45 PM</option>
          </select>

          <button class="book-btn" onclick="bookNow()">Book Now</button>
        </div>
      </div>
    </div>
  </section>

  
  
  <!-- Sub Navigation -->
  <nav class="subnav">
    <div class="subnav-inner">
      <a href="#showtimes">Now Showing</a>
      <a href="#coming-soon">Coming Soon</a>
      <a href="#experiences">Experiences</a>
      <a href="#trailers">Trailers</a>
      <a href="#offers">Offers</a>
    </div>
  </nav>

  <!-- Now Showing -->

  <section class="now-showing" id="showtimes">
    <div class="section-inner">
      <h2 class="section-title">🎥 Now Showing</h2>
      <div class="movie-grid">
        <div class="movie-card-mini">
          <img src="https://images.unsplash.com/photo-1524985069026-dd778a71c7b4?q=80&w=500" alt="Midnight Heist">
          <h3>Midnight Heist</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=500" alt="Galactic Drift">
          <h3>Galactic Drift</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://images.unsplash.com/photo-1515169067865-5387ec356754?q=80&w=500" alt="Echoes of Dawn">
          <h3>Echoes of Dawn</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://images.unsplash.com/photo-1542204625-de6161c72a5d?q=80&w=500" alt="Another Movie">
          <h3>Crimson Chase</h3>
          <button class="book-btn small">Book</button>
        </div>
      </div>
    </div>
  </section>

<!-- Footer -->

  <footer class="footer">
    <div class="footer-inner">
      <div class="foot-col">
        <h4>Company</h4>
        <a href="#">About</a>
        <a href="#">Careers</a>
        <a href="#">Press</a>
      </div>
      <div class="foot-col">
        <h4>Support</h4>
        <a href="#">Help Center</a>
        <a href="#">Terms</a>
        <a href="#">Privacy</a>
      </div>
      <div class="foot-col">
        <h4>Connect</h4>
        <div class="socials">
          <a href="#"><i class="ri-instagram-line"></i></a>
          <a href="#"><i class="ri-twitter-x-line"></i></a>
          <a href="#"><i class="ri-youtube-line"></i></a>
        </div>
      </div>
      <div class="foot-col brand-end">
        <div class="brand">
          <span class="brand-mark">🎬</span>
          <span class="brand-text">TRX</span>
        </div>
        <p class="tiny">© <?php echo date('Y'); ?> BookMySeat. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script src="script.js"></script>

  <!-- Login Modal -->
  <div id="loginModal" class="modal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="modal-content">
      <button class="modal-close" id="loginClose" aria-label="Close login"><i class="ri-close-line"></i></button>
      <h3>Welcome Back</h3>
      <form class="form">
        <label>
          Email
          <input type="email" placeholder="you@example.com" required>
        </label>
        <label>
          Password
          <input type="password" placeholder="••••••••" required>
        </label>
        <button type="submit" class="book-btn w-full">Login</button>
        <p class="tiny center">New here? <a href="#">Create an account</a></p>
      </form>
    </div>
  </div>
</body>
</html>
