<?php
// admin/login.php
include __DIR__ . '/../config.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
  header("Location: index.php");
  exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, password, name FROM admins WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hash, $name);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
      $_SESSION['admin_id'] = $id;
      $_SESSION['admin_name'] = $name;
      header("Location: index.php");
      exit;
    } else {
      $error = "❌ Incorrect password.";
    }
  } else {
    $error = "⚠️ No account found with that username.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login | TRX Cinema</title>
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f8fafc;
      color: #1e293b;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      width: 360px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.06);
      padding: 40px 32px;
      text-align: center;
    }

    .login-box h2 {
      color: #0b63ff;
      margin-bottom: 24px;
      font-weight: 700;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1px solid #cbd5e1;
      background: #f9fafb;
      font-size: 15px;
      color: #1e293b;
      outline: none;
      transition: border 0.2s;
    }

    input:focus {
      border-color: #0b63ff;
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
      cursor: pointer;
      transition: background 0.2s, transform 0.2s;
    }

    button:hover {
      background: #084edb;
      transform: translateY(-1px);
    }

    .error {
      color: #ef4444;
      background: #fee2e2;
      border: 1px solid #fecaca;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      margin-bottom: 12px;
    }

    .footer-text {
      margin-top: 16px;
      font-size: 13px;
      color: #64748b;
    }

    @media (max-width: 420px) {
      .login-box {
        width: 90%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>
    <?php if($error): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Sign In</button>
    </form>
    <div class="footer-text">
      © <?php echo date('Y'); ?> TRX Cinema Admin
    </div>
  </div>
</body>
</html>
