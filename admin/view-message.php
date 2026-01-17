<?php
include "functions.php"; // Correct path for your admin DB connection

// Check if ID exists
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid message request!");
}

$id = intval($_GET['id']);

// Fetch message from DB
$stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Message not found!");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Message</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f1f3f6;
            padding: 20px;
        }
        .container{
            width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }
        h2{
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .box{
            background: #f7f7f7;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
        }
        .label{
            font-weight: bold;
            color: #333;
        }
        .back-btn{
            display: block;
            text-align: center;
            background: #007bff;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 16px;
        }
        .back-btn:hover{
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>View Message</h2>

    <div class="box">
        <span class="label">Name:</span> <?= htmlspecialchars($row['name']); ?>
    </div>

    <div class="box">
        <span class="label">Email:</span> <?= htmlspecialchars($row['email']); ?>
    </div>

    <div class="box">
        <span class="label">Message:</span><br>
        <?= nl2br(htmlspecialchars($row['message'])); ?>
    </div>

    <a href="manage-messages.php" class="back-btn">Back to Messages</a>
</div>

</body>
</html>
