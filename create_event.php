<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    try {
        $stmt = $conn->prepare("INSERT INTO events (title, description, date) VALUES (:title, :description, :date)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
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
    <title>Create Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Event Management System</header>
    <form method="POST">
        <label>Event Title:</label>
        <input type="text" name="title" required>
        <label>Event Description:</label>
        <textarea name="description" required></textarea>
        <label>Event Date:</label>
        <input type="date" name="date" required>
        <button type="submit">Create Event</button>
    </form>
</body>
</html>
