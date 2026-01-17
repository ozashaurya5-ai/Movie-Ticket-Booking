<?php
// admin/edit-movie.php
require_once __DIR__ . '/functions.php';
admin_check();

// fallback escape helper
if (!function_exists('e')) {
  function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
  }
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { echo "Invalid movie ID."; exit; }

// fetch movie
$movieRow = $conn->query("SELECT * FROM movies WHERE id = $id");
if (!$movieRow) { echo "DB error: " . $conn->error; exit; }
$movie = $movieRow->fetch_assoc();
if (!$movie) { echo "Movie not found."; exit; }

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $description = $_POST['description'] ?? '';
  $genre = $_POST['genre'] ?? '';
  $duration = $_POST['duration'] ?? '';
  $rating = $_POST['rating'] ?? '';
  $release_date = $_POST['release_date'] ?? '';
  $trailer_url = $_POST['trailer_url'] ?? '';
  $show_in_slider = isset($_POST['show_in_slider']) ? 1 : 0;

  $poster = $movie['poster'];
  $banner = $movie['banner'];

  // Upload Paths
  $targetDir = __DIR__ . '/../images/';
  if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

  if (!empty($_FILES['poster']['name'])) {
    $pname = 'poster_' . time() . '_' . basename($_FILES['poster']['name']);
    $targetFile = $targetDir . $pname;
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetFile)) {
      $poster = 'images/' . $pname;
    }
  }

  if (!empty($_FILES['banner']['name'])) {
    $bname = 'banner_' . time() . '_' . basename($_FILES['banner']['name']);
    $targetFile2 = $targetDir . $bname;
    if (move_uploaded_file($_FILES['banner']['tmp_name'], $targetFile2)) {
      $banner = 'images/' . $bname;
    }
  }

  $stmt = $conn->prepare("UPDATE movies SET title=?, description=?, genre=?, duration=?, rating=?, release_date=?, trailer_url=?, poster=?, banner=?, show_in_slider=? WHERE id=?");
  $stmt->bind_param("sssssssssii", $title, $description, $genre, $duration, $rating, $release_date, $trailer_url, $poster, $banner, $show_in_slider, $id);
  if ($stmt->execute()) {
    $msg = "✅ Movie updated successfully!";
    admin_log('Edit Movie', "ID:$id Title:$title");
    $movie = $conn->query("SELECT * FROM movies WHERE id = $id")->fetch_assoc();
  } else {
    $msg = "❌ Error: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit Movie | TRX Cinema Admin</title>
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

/* Main content */
.main {
  flex: 1;
  margin-left: 240px;
  padding: 40px;
}

.container {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 30px;
  max-width: 800px;
  margin: auto;
  box-shadow: 0 6px 20px rgba(0,0,0,0.05);
}

h2 {
  color: #0b63ff;
  text-align: center;
  margin-bottom: 20px;
}

label {
  display: block;
  margin-top: 12px;
  color: #334155;
  font-weight: 600;
}

input, textarea {
  width: 100%;
  padding: 10px 12px;
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  background: #f9fafb;
  color: #1e293b;
  font-size: 15px;
  margin-top: 6px;
  outline: none;
  transition: border 0.2s;
}
input:focus, textarea:focus {
  border-color: #0b63ff;
}

.images {
  display: flex;
  gap: 16px;
  margin-top: 16px;
  justify-content: center;
}

.images img {
  width: 160px;
  height: 100px;
  object-fit: cover;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

button {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 10px;
  background: #0b63ff;
  color: #fff;
  font-weight: 600;
  font-size: 16px;
  margin-top: 18px;
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
}
button:hover {
  background: #084edb;
  transform: translateY(-1px);
}

.msg {
  text-align: center;
  color: #10b981;
  font-weight: 600;
  margin-bottom: 16px;
}

a.back {
  color: #0b63ff;
  text-decoration: none;
  font-weight: 600;
  display: inline-block;
  margin-bottom: 16px;
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
  <div class="container">
    <a href="movies.php" class="back">← Back to Movies</a>
    <h2>🎬 Edit Movie</h2>

    <?php if(!empty($msg)): ?><div class="msg"><?php echo e($msg); ?></div><?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <label>Title</label>
      <input name="title" value="<?php echo e($movie['title']); ?>" required>

      <label>Description</label>
      <textarea name="description" rows="4"><?php echo e($movie['description']); ?></textarea>

      <label>Genre</label>
      <input name="genre" value="<?php echo e($movie['genre']); ?>">

      <label>Duration</label>
      <input name="duration" value="<?php echo e($movie['duration']); ?>">

      <label>Rating</label>
      <input name="rating" value="<?php echo e($movie['rating']); ?>">

      <label>Release Date</label>
      <input type="date" name="release_date" value="<?php echo e($movie['release_date']); ?>">

      <label>Trailer URL (embed)</label>
      <input name="trailer_url" value="<?php echo e($movie['trailer_url']); ?>">

      <label>Poster Image (replace)</label>
      <input type="file" name="poster" accept="image/*">

      <label>Banner Image (replace)</label>
      <input type="file" name="banner" accept="image/*">

      <div class="images">
        <?php if (!empty($movie['poster'])): ?><img src="../<?php echo e($movie['poster']); ?>" alt="Poster"><?php endif; ?>
        <?php if (!empty($movie['banner'])): ?><img src="../<?php echo e($movie['banner']); ?>" alt="Banner"><?php endif; ?>
      </div>

      <label style="margin-top:10px;">
        <input type="checkbox" name="show_in_slider" value="1" <?php echo ($movie['show_in_slider'] ? 'checked' : ''); ?>> Show in Home Slider
      </label>

      <button type="submit">💾 Update Movie</button>
    </form>
  </div>
</div>
</body>
</html>
