<?php
include 'config.php';
session_start();

// Check DB connection
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST["email"]);
  $password = trim($_POST["password"]);

  $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $name, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION["user_id"] = $id;
      $_SESSION["user_name"] = $name;
      header("Location: index.php");
      exit();
    } else {
      $error = "❌ Incorrect password. Please try again.";
    }
  } else {
    $error = "❌ No account found with that email.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - MovieTime</title>

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

    .success {
      text-align: center;
      color: #22c55e;
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
      <h2>Welcome Back 👋</h2>
      <?php 
        if(isset($_GET['registered'])) echo "<p class='success'>✅ Registration successful! Please log in.</p>";
        if(isset($error)) echo "<p class='error'>$error</p>"; 
      ?>

      <form class="auth-form" method="POST" action="">
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required />
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit" class="auth-btn">Login</button>
      </form>

      <p>Don’t have an account? <a href="register.php">Register</a></p>
    </div>
  </div>
</body>
</html>
