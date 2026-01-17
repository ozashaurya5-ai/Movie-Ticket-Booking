<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST["name"]);
  $email = trim($_POST["email"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  // Check if user already exists
  $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    $error = "⚠️ Email already exists! Please log in instead.";
  } else {
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute()) {
      header("Location: login.php?registered=1");
      exit();
    } else {
      $error = "❌ Something went wrong. Please try again.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - MovieTime</title>

  <!-- Main + Light Theme -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="css/theme-overrides.css" />

  <style>
    body {
      background: #f8fafc;
      font-family: 'Poppins', sans-serif;
      color: #0f172a;
      margin: 0;
    }

    .auth-section {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #e0f2ff 0%, #ffffff 100%);
      padding: 20px;
    }

    .auth-card {
      background: #ffffff;
      border: 1px solid rgba(15,23,42,0.08);
      border-radius: 18px;
      padding: 40px 36px;
      width: min(400px, 90vw);
      box-shadow: 0 10px 25px rgba(15,23,42,0.08);
      transition: all 0.3s ease;
    }
    .auth-card:hover {
      box-shadow: 0 14px 30px rgba(15,23,42,0.12);
    }

    .auth-card h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #0b63ff;
      font-size: 26px;
      font-weight: 700;
    }

    .auth-form {
      display: grid;
      gap: 18px;
    }

    .auth-form label {
      font-weight: 600;
      color: #475569;
      margin-bottom: 4px;
      display: block;
      font-size: 14px;
    }

    .auth-form input {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1px solid rgba(15,23,42,0.15);
      background: #ffffff;
      color: #0f172a;
      outline: none;
      font-size: 15px;
      transition: all 0.2s ease;
    }

    .auth-form input:focus {
      border-color: #0b63ff;
      box-shadow: 0 0 0 3px rgba(11,99,255,0.15);
    }

    .auth-btn {
      background: linear-gradient(180deg, #0b63ff, #0846c6);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(11,99,255,0.2);
      transition: all 0.2s ease;
    }

    .auth-btn:hover {
      transform: translateY(-2px);
      background: #0846c6;
      box-shadow: 0 8px 20px rgba(11,99,255,0.25);
    }

    .auth-card p {
      text-align: center;
      margin-top: 18px;
      color: #64748b;
      font-size: 14px;
    }

    .auth-card a {
      color: #0b63ff;
      text-decoration: none;
      font-weight: 600;
    }

    .auth-card a:hover {
      text-decoration: underline;
    }

    .error {
      text-align: center;
      color: #ff4d4d;
      margin-bottom: 10px;
      font-weight: 500;
    }

    @media (max-width: 480px) {
      .auth-card {
        padding: 28px 20px;
      }
      .auth-card h2 {
        font-size: 22px;
      }
    }
  </style>
</head>

<body>
  <div class="auth-section">
    <div class="auth-card">
      <h2>Create Account ✨</h2>

      <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

      <form class="auth-form" method="POST" action="">
        <div>
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" class="auth-btn">Register</button>
      </form>

      <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>
