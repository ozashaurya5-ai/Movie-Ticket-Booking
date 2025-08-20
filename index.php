<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PVR Navigation Bar</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <nav class="navbar">
    <div class="navbar-left">
      <img src="img/TRX5.png" alt="TRX logo" class="logo">
      <a href="#" class="nav-icon home">Home</a>
      <a href="#">Showtimings</a>
      <a href="#">Cinemas</a>
      <a href="#">Offers</a>
      <a href="#">Investor Section</a>
      <a href="#">Passport</a>
      <div class="dropdown">
        <button onclick="toggleDropdown()" class="dropbtn">More <span>&#9660;</span></button>
        <div id="dropdown-content" class="dropdown-content">
          <a href="#">About</a>
          <a href="#">Contact</a>
          <a href="#">FAQ</a>
        </div>
      </div>
    </div>
    <div class="navbar-right">
      <input type="text" class="search" placeholder="Search..."/>
      <div class="location-dropdown">
        <select>
          <option>Ahmedabad</option>
          <option>Mumbai</option>
          <option>Delhi</option>
          <!-- Add more cities as needed -->
        </select>
      </div>
      <button class="login-btn">Login</button>
    </div>
  </nav>
  <script src="script.js"></script>
</body>
</html>
