<?php
$host = "localhost";
$user = "root"; // change if needed
$pass = "";     // your MySQL password
$dbname = "cinema_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
