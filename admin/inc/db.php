<?php
$host = "localhost";      // change if needed
$user = "root";           // DB username
$pass = "";               // DB password
$db   = "trx_cinema";     // your database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: set timezone
date_default_timezone_set("Asia/Kolkata");
?>
