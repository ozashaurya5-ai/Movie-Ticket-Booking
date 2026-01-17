<?php
include('config.php');
session_start();

// User login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only POST requests allowed
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $showtime_id = intval($_POST['showtime_id'] ?? 0);
    $seat_number = trim($_POST['selected_seats'] ?? '');
    $total_price = floatval($_POST['total_price'] ?? 0);

    if (empty($showtime_id) || empty($seat_number) || $total_price <= 0) {
        die("<h3 style='color:red;text-align:center;margin-top:50px;'>⚠️ Invalid booking data. Please try again.</h3>");
    }

    // Insert booking safely using prepared statement
    $stmt = $conn->prepare("
        INSERT INTO bookings (user_id, showtime_id, seat_number, booking_time, total_price, payment_status)
        VALUES (?, ?, ?, NOW(), ?, 'Pending')
    ");
    $stmt->bind_param("iisd", $user_id, $showtime_id, $seat_number, $total_price);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        $stmt->close();

        // Redirect to payment
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();
    } else {
        $error = htmlspecialchars($stmt->error);
        $stmt->close();
        echo "<h3 style='color:red;text-align:center;margin-top:50px;'>❌ Booking failed: $error</h3>";
    }
} else {
    echo "<h3 style='color:red;text-align:center;margin-top:50px;'>⚠️ Invalid request method.</h3>";
}
?>
