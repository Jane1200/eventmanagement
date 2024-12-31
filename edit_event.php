<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: events.php');
    exit();
}

$event_id = $_GET['id'];

// Fetch the event details
try {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
    $stmt->bindParam(':id', $event_id);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Event not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    try {
        $stmt = $conn->prepare("UPDATE events SET title = :title, description = :description, date = :date WHERE id = :id");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id', $event_id);
        $stmt->execute();
        header('Location: events.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Event Management System</header>
    <form method="POST">
        <label>Event Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($event['title']); ?>" required>
        <label>Event Description:</label>
        <textarea name="description" required><?= htmlspecialchars($event['description']); ?></textarea>
        <label>Event Date:</label>
        <input type="date" name="date" value="<?= $event['date']; ?>" required>
        <button type="submit">Update Event</button>
    </form>
</body>
</html>
