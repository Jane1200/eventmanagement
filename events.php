<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM events");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Event Management System</header>
    <div class="nav">
        <a href="create_event.php">Create Event</a>
        <a href="logout.php">Logout</a>
    </div>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <strong><?= htmlspecialchars($event['title']); ?></strong> (<?= $event['date']; ?>)
                <a href="edit_event.php?id=<?= $event['id']; ?>">Edit</a>
                <a href="delete_event.php?id=<?= $event['id']; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
