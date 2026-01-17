<?php
require_once 'functions.php';
admin_check();
include __DIR__ . '/../config.php';

$msg = "";

// 🎬 Add Movie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $genre = $_POST['genre'];
  $duration = $_POST['duration'];
  $rating = $_POST['rating'];
  $release_date = $_POST['release_date'];
  $trailer_url = $_POST['trailer_url'];
  $show_in_slider = isset($_POST['show_in_slider']) ? 1 : 0;

  // Upload Paths
  $poster_path = '';
  $banner_path = '';
  $targetDir = __DIR__ . '/../images/';
  if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

  // Upload Poster
  if (!empty($_FILES['poster']['name'])) {
    $pname = 'poster_' . time() . '_' . basename($_FILES['poster']['name']);
    $targetFile = $targetDir . $pname;
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFile)) {
      $poster_path = 'images/' . $pname;
    }
  }

  // Upload Banner
  if (!empty($_FILES['banner']['name'])) {
    $bname = 'banner_' . time() . '_' . basename($_FILES['banner']['name']);
    $targetFile2 = $targetDir . $bname;
    if (move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile2)) {
      $banner_path = 'images/' . $bname;
    }
  }

  $stmt = $conn->prepare("INSERT INTO movies (title, description, genre, duration, rating, release_date, trailer_url, poster, banner, show_in_slider) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssssi", $title, $description, $genre, $duration, $rating, $release_date, $trailer_url, $poster_path, $banner_path, $show_in_slider);

  if ($stmt->execute()) {
    $msg = "✅ Movie Added Successfully!";
    admin_log('Add Movie', $title);
  } else {
    $msg = "❌ Error: " . $conn->error;
  }
}

// 🗑 Delete Movie
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $r = $conn->query("SELECT poster, banner FROM movies WHERE id = $id")->fetch_assoc();
  if ($r) {
    foreach (['poster', 'banner'] as $img) {
      if (!empty($r[$img]) && file_exists(__DIR__ . '/../' . $r[$img])) unlink(__DIR__ . '/../' . $r[$img]);
    }
  }
  $conn->query("DELETE FROM movies WHERE id = $id");
  header("Location: movies.php");
  exit;
}

// 🎞 Fetch all movies
$result = $conn->query("SELECT * FROM movies ORDER BY release_date DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Manage Movies | Admin</title>
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

    /* Main */
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

    input, textarea {
      width: 100%;
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #cbd5e1;
      background: #f9fafb;
      font-size: 15px;
      margin-bottom: 10px;
      color: #1e293b;
    }

    input:focus, textarea:focus {
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

    img {
      border-radius: 8px;
      width: 60px;
      height: 60px;
      object-fit: cover;
    }

    a.edit {
      color: #0b63ff;
      text-decoration: none;
      font-weight: 600;
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
  <a href="movies.php" class="active">🎬 <span>Movies</span></a>
  <a href="showtimes.php">🕒 <span>Showtimes</span></a>
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

<!-- Main -->
<div class="main">
  <h1>🎬 Manage Movies</h1>
  <?php if($msg): ?><div class="msg"><?= $msg ?></div><?php endif; ?>

  <div class="card">
    <h3>Add New Movie</h3>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="add">

      <div class="form-row">
        <div class="form-col"><label>Title</label><input name="title" required></div>
        <div class="form-col"><label>Genre</label><input name="genre"></div>
        <div class="form-col"><label>Duration</label><input name="duration"></div>
      </div>

      <label>Description</label>
      <textarea name="description" rows="3"></textarea>

      <div class="form-row">
        <div class="form-col"><label>Rating</label><input name="rating"></div>
        <div class="form-col"><label>Release Date</label><input type="date" name="release_date"></div>
        <div class="form-col"><label>Trailer URL</label><input name="trailer_url" placeholder="YouTube embed link"></div>
      </div>

      <div class="form-row">
        <div class="form-col"><label>Poster Image</label><input type="file" name="poster" accept="image/*"></div>
        <div class="form-col"><label>Banner Image</label><input type="file" name="banner" accept="image/*"></div>
      </div>

      <label><input type="checkbox" name="show_in_slider" value="1"> Show in Home Slider</label><br>
      <button type="submit">➕ Add Movie</button>
    </form>
  </div>

  <div class="card">
    <h3>Existing Movies</h3>
    <table>
      <thead>
        <tr><th>Poster</th><th>Banner</th><th>Title</th><th>Release</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><img src="../<?= htmlspecialchars($row['poster']); ?>" alt=""></td>
          <td><img src="../<?= htmlspecialchars($row['banner']); ?>" alt=""></td>
          <td><?= htmlspecialchars($row['title']); ?></td>
          <td><?= htmlspecialchars($row['release_date']); ?></td>
          <td>
            <a href="edit-movie.php?id=<?= $row['id']; ?>" class="edit">Edit</a> |
            <a href="movies.php?delete=<?= $row['id']; ?>" class="delete" onclick="return confirm('Delete this movie?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
