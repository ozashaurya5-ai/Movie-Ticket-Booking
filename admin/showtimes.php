<?php
require 'functions.php';
admin_check();

$msg = '';

// 🎞 Add Showtime
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
  $movie_id = (int)$_POST['movie_id'];
  $cinema = $_POST['cinema'];
  $show_date = $_POST['show_date'];
  $show_time = $_POST['show_time'];

  $stmt = $conn->prepare("INSERT INTO showtimes (movie_id, cinema, show_date, show_time) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isss", $movie_id, $cinema, $show_date, $show_time);
  
  if ($stmt->execute()) $msg = "✅ Showtime added successfully!";
  else $msg = "❌ Error: " . $conn->error;
}

// 🗑 Delete Showtime
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $conn->query("DELETE FROM showtimes WHERE id = $id");
  header("Location: showtimes.php");
  exit;
}

// 🎬 Fetch movies and showtimes
$movies = $conn->query("SELECT id, title FROM movies ORDER BY title ASC");
$showtimes = $conn->query("SELECT s.*, m.title FROM showtimes s JOIN movies m ON s.movie_id=m.id ORDER BY s.show_date, s.show_time");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Showtimes | TRX Cinema Admin</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f8fafc;
      color: #1e293b;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: #ffffff;
      border-right: 1px solid #e2e8f0;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      position: fixed;
      top: 0;
      bottom: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.05);
    }

    .sidebar h2 {
      text-align: center;
      color: #0b63ff;
      font-weight: 800;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      color: #334155;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .sidebar a:hover, .sidebar a.active {
      background: #0b63ff;
      color: #fff;
      border-radius: 8px;
    }

    .sidebar .bottom {
      margin-top: auto;
      padding: 12px 20px;
      font-size: 0.9em;
      color: #64748b;
    }

    /* Main Section */
    .main {
      flex: 1;
      margin-left: 240px;
      padding: 30px;
    }

    h1 {
      color: #0b63ff;
      margin-bottom: 20px;
    }

    .msg {
      background: #dcfce7;
      color: #166534;
      border: 1px solid #86efac;
      padding: 10px 14px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: 600;
      width: fit-content;
    }

    .card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 14px;
      padding: 24px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.04);
      margin-bottom: 30px;
    }

    .card h3 {
      color: #0b63ff;
      margin-bottom: 16px;
    }

    input, select {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      background: #f9fafb;
      font-size: 15px;
      margin-bottom: 10px;
      color: #1e293b;
    }

    input:focus, select:focus {
      border-color: #0b63ff;
      outline: none;
    }

    .form-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form-col {
      flex: 1;
      min-width: 200px;
    }

    button {
      background: #0b63ff;
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }

    button:hover {
      background: #084edb;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #f1f5f9;
    }

    th {
      background: #f8fafc;
      color: #0b63ff;
      font-weight: 600;
    }

    tr:hover td {
      background: #f1f5f9;
    }

    a.delete {
      color: #dc2626;
      text-decoration: none;
      font-weight: 600;
    }

    a.delete:hover {
      text-decoration: underline;
    }

    @media(max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      .sidebar h2 { display: none; }
      .sidebar a span { display: none; }
      .main { margin-left: 70px; padding: 15px; }
      table { font-size: 13px; }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>TRX Admin</h2>
  <a href="index.php">🏠 <span>Dashboard</span></a>
  <a href="movies.php">🎬 <span>Movies</span></a>
  <a href="showtimes.php" class="active">🕒 <span>Showtimes</span></a>
  <a href="bookings.php">🎟 <span>Bookings</span></a>
  <a href="manage-payments.php">💸 <span>Payments</span></a>
  <a href="users.php">👥 <span>Users</span></a>
  <a href="images.php">🖼 <span>Images</span></a>
  <a href="manage-messages.php">📩 <span>Messages</span></a>
  <div class="bottom">
    Logged in as <b><?php echo htmlspecialchars($_SESSION['admin_name']); ?></b><br>
    <a href="logout.php" style="color:#0b63ff; text-decoration:none;">Logout</a>
  </div>
</div>

<!-- Main Content -->
<div class="main">
  <h1>🕒 Manage Showtimes</h1>

  <?php if($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>

  <div class="card">
    <h3>Add New Showtime</h3>
    <form method="post">
      <input type="hidden" name="action" value="add">

      <div class="form-row">
        <div class="form-col">
          <label>Movie</label>
          <select name="movie_id" required>
            <option value="">Select Movie</option>
            <?php while($mv = $movies->fetch_assoc()): ?>
              <option value="<?= $mv['id']; ?>"><?= htmlspecialchars($mv['title']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="form-col">
          <label>Cinema</label>
          <input name="cinema" placeholder="Cinema (e.g. PVR Mumbai)" required>
        </div>
        <div class="form-col">
          <label>Date</label>
          <input type="date" name="show_date" required>
        </div>
        <div class="form-col">
          <label>Time</label>
          <input type="time" name="show_time" required>
        </div>
      </div>

      <button type="submit">➕ Add Showtime</button>
    </form>
  </div>

  <div class="card">
    <h3>All Showtimes</h3>
    <table>
      <thead>
        <tr><th>Movie</th><th>Cinema</th><th>Date</th><th>Time</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($s = $showtimes->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($s['title']); ?></td>
          <td><?= htmlspecialchars($s['cinema']); ?></td>
          <td><?= htmlspecialchars($s['show_date']); ?></td>
          <td><?= htmlspecialchars($s['show_time']); ?></td>
          <td><a href="showtimes.php?delete=<?= $s['id']; ?>" class="delete" onclick="return confirm('Delete this showtime?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
