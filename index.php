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
        <a class="showtimings" href="showtimes.php"><i class="ri-film-line"></i> Showtimes</a>
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

      <!-- <div class="location-dropdown">
        <i class="ri-map-pin-2-line"></i>
        <select aria-label="Select Location">
          <option>Ahmedabad</option>
          <option>Mumbai</option>
          <option>Delhi</option>
          <option>Bengaluru</option>
        </select>
      </div> -->

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
        <div class="swiper-slide" style="--bg:url('img/war-2-cover-img.jpeg');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>War 2</h2>
              <p>Years ago Agent Kabir went rogue, became India’s greatest villain ever. As he descends further into the deepest shadows... India sends its deadliest, most lethal agent af . . .</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/28727_bBwcaxjU.jpeg" alt="Midnight Heist Poster">
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide" style="--bg:url('https://i.ytimg.com/vi/XTSewtmCGTo/maxresdefault.jpg');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>Mahavatar Narsimha</h2>
              <p>In the animated epic Mahavatar Narsimha, the powerful demon king Hiranyakashipu becomes nearly invincible after a boon from Brahma, but his own son, Prahlad, remains devoted to Vishnu.</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/32605_s7Bm7YZN.jpg" alt="Galactic Drift Poster">
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="swiper-slide" style="--bg:url('https://cdn.district.in/movies-assets/images/cinema/Jurrasic-world-Rebirth-17bde1d0-559a-11f0-b09a-11c880b90aa7.jpg');">
          <div class="overlay"></div>
          <div class="movie-card">
            <div class="movie-content">
              <h2>Jurassic World: Rebirth</h2>
              <p>Thrills. Survival. Adventure. Witness the epic comeback in Jurassic World: Rebirth – Book Now!</p>
              <button class="cta book-btn" onclick="document.getElementById('quick-book').scrollIntoView({behavior:'smooth'})">
                Book Tickets <i class="ri-arrow-right-line"></i>
              </button>
            </div>
            <div class="movie-poster">
              <img src="https://stat4.bollywoodhungama.in/wp-content/uploads/2025/07/JurassicWorldRebirth1-306x393.jpg" alt="Echoes of Dawn Poster">
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
            <option>War 2</option>
            <option>Mahavatar Narsimha</option>
            <option>Jurassic World: Rebirth</option>
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
          <img src="https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/28727_bBwcaxjU.jpeg" alt="War 2">
          <h3>War 2</h3>
          <a href="movie-details.php?movie=War 2" class="book-btn small">Book</a>
        </div>
        <div class="movie-card-mini">
          <img src="https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/32605_s7Bm7YZN.jpg" alt="Galactic Drift">
          <h3>Mahavatar Narsimha</h3>
          <a href="movie-details.php?movie=Dune: Part Two" class="book-btn small">Book</a>
        </div>
        <div class="movie-card-mini">
          <img src="https://stat4.bollywoodhungama.in/wp-content/uploads/2025/07/JurassicWorldRebirth1-306x393.jpg" alt="Echoes of Dawn">
          <h3>Jurassic World: Rebirth</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://originserver-static1-uat.pvrcinemas.com/pvrcms/movie_v/33622_oe1HFYFh.jpg" alt="Another Movie">
          <h3>Saiyaara</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://i.pinimg.com/736x/fb/d8/aa/fbd8aad8e0004256833a6dcd92991521.jpg" alt="Desi Boyz">
          <h3>Desi Boyz</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://i.pinimg.com/1200x/ac/60/63/ac60638869fb54bdc172d0cb32817dcc.jpg" alt="Boss">
          <h3>Boss</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://i.pinimg.com/736x/1b/29/a4/1b29a464df388691fb084dc00e94d927.jpg" alt="Dilwale">
          <h3>Dilwale</h3>
          <button class="book-btn small">Book</button>
        </div>
        <div class="movie-card-mini">
          <img src="https://i.pinimg.com/736x/30/55/56/30555695a7dd468a2d04be688d5c21b4.jpg" alt="PK">
          <h3>PK</h3>
          <button class="book-btn small">Book</button>
        </div>
      </div>
    </div>
  </section>

<!-- Coming Soon Section -->
<section class="now-showing" id="coming-soon">
  <div class="section-inner">
    <h2 class="section-title">🔜 Coming Soon</h2>
    <div class="movie-grid">
      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/736x/c7/99/af/c799af68780b506d199261a189af19c7.jpg" alt="pushpa 2">
        <h3>Pushpa 2</h3>
        <button class="book-btn small" disabled>Coming Soon</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/1200x/16/95/c0/1695c077e8483eb37828fc4a100372f6.jpg" alt="Avengers 5">
        <h3>Avengers 5</h3>
        <button class="book-btn small" disabled>Coming Soon</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/1200x/a8/2f/d2/a82fd2ae7351892bc561f6943448e86a.jpg" alt="Tiger 3">
        <h3>Tiger 3</h3>
        <button class="book-btn small" disabled>Coming Soon</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/1200x/ac/a4/a0/aca4a0922c6165d1e5e44de963af12f8.jpg" alt="Chhichhore">
        <h3>Chhichhore</h3>
        <button class="book-btn small" disabled>Coming Soon</button>
      </div>
    </div>
  </div>
</section>


<!-- Experiences Section -->
<section class="now-showing" id="experiences">
  <div class="section-inner">
    <h2 class="section-title">😍 Experiences</h2>
    <div class="movie-grid">

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/736x/ed/9e/98/ed9e9863d4c18f364639a9632f6b7593.jpg" alt="Screen Experience">
        <h3>Screen Experience</h3>
        <p>Enjoy movies on giant screens with crystal-clear visuals and immersive sound.</p>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/736x/6c/7e/b2/6c7eb2d4a00ed681094bbfd7d59cee58.jpg" alt="Seat Experience">
        <h3>Seat Experience</h3>
        <p>Feel the action with motion seats, water sprays, and wind effects!</p>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/736x/0c/b3/9e/0cb39ea2ee17e7088bafff73e47707df.jpg" alt="Dolby Atmos">
        <h3>Dolby Atmos</h3>
        <p>Surround sound that moves all around you — experience cinema like never before.</p>
      </div>

      <div class="movie-card-mini">
        <img src="https://i.pinimg.com/736x/45/15/4f/45154f37330d65f4d6d3df6a73f7fc29.jpg" alt="Luxury Recliner">
        <h3>Luxury Recliner</h3>
        <p>Relax in premium recliners with in-seat service for a VIP movie experience.</p>
      </div>

    </div>
  </div>
</section>


<!-- Trailers Section -->
<section class="now-showing" id="trailers">
  <div class="section-inner">
    <h2 class="section-title">🔥 Latest Trailers</h2>
    <div class="movie-grid">

      <div class="movie-card-mini">
        <iframe width="100%" height="200" 
        src="https://www.youtube.com/embed/1kVK0MZlbI4?si=nUHARujUY_h2VhBm" 
        title="YouTube video player" 
        frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        referrerpolicy="strict-origin-when-cross-origin" 
        allowfullscreen>
        </iframe>
        <h3>Pushpa 2</h3>
        <button class="book-btn small" onclick="window.open('https://youtu.be/1kVK0MZlbI4?si=pd7H2mQis6fuToyQ', '_blank')">
          Watch on YouTube
        </button>
      </div>

      <div class="movie-card-mini">
        <iframe width="100%" height="200" 
        src="https://www.youtube.com/embed/wT4HcYAeV5U?si=DEYuxZnhaOsP--24" 
        title="YouTube video player" frameborder="0" 
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
        referrerpolicy="strict-origin-when-cross-origin" 
        allowfullscreen>
        </iframe>
        <h3>The Raja Saab</h3>
        <button class="book-btn small" onclick="window.open('https://youtu.be/wT4HcYAeV5U?si=ahGigX8gJ2--HQjH', '_blank')">
          Watch on YouTube
        </button>
      </div>

      <div class="movie-card-mini">
        <iframe width="100%" height="200" 
          src="https://www.youtube.com/embed/d9MyW72ELq0" 
          title="Avatar: The Way of Water Trailer"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
        <h3>Avatar: The Way of Water</h3>
        <button class="book-btn small" onclick="window.open('https://www.youtube.com/watch?v=d9MyW72ELq0', '_blank')">
          Watch on YouTube
        </button>
      </div>

      <div class="movie-card-mini">
        <iframe width="100%" height="200" 
          src="https://www.youtube.com/embed/RxAtuMu_ph4" 
          title="The Batman Trailer"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
        <h3>The Batman</h3>
        <button class="book-btn small" onclick="window.open('https://www.youtube.com/watch?v=RxAtuMu_ph4', '_blank')">
          Watch on YouTube
        </button>
      </div>

    </div>
  </div>
</section>


<!-- Offers Section -->
<section class="now-showing" id="offers">
  <div class="section-inner">
    <h2 class="section-title">🫶 Exclusive Offers</h2>
    <div class="movie-grid">

      <div class="movie-card-mini">
        <img src="https://cdn0.desidime.com/attachments/photos/1237370/medium/1000133415.jpg?1745666048" alt="Bank Offer">
        <h3>₹50 Off with HDFC Cards</h3>
        <p>Enjoy flat ₹50 off when you book tickets using HDFC Bank Credit Cards.</p>
        <button class="book-btn small">Use Code: HDFC50</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSzeE_cRg-bSiDvNEaBSHyJhvELqs7UOHnXZA&s" alt="Combo Offer">
        <h3>Movie + Meal Combo</h3>
        <p>Get a popcorn & drink combo at ₹99 with every movie ticket booked online.</p>
        <button class="book-btn small">Grab Deal</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://img.freepik.com/free-vector/student-discount-labels-design_23-2150555801.jpg" alt="Student Discount">
        <h3>Student Discount</h3>
        <p>Show your student ID and get 25% off on weekday shows before 6 PM.</p>
        <button class="book-btn small">Avail Now</button>
      </div>

      <div class="movie-card-mini">
        <img src="https://media.istockphoto.com/id/530649463/photo/premium-membership-gold-badge.jpg?s=612x612&w=0&k=20&c=j21z0bEdFdSU_KkF60LNTe9mxuaUdIyxUmiir_yBswo=" alt="Membership">
        <h3>Premium Membership</h3>
        <p>Join our MovieClub and enjoy priority bookings, cashback, and free snacks!</p>
        <button class="book-btn small">Join Now</button>
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
