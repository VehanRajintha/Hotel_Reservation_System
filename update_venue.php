<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "Hotel_Reservation"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];
    $image_url = $_POST['image_url'];

    // Update venue details
    $sql = "UPDATE venues SET name=?, description=?, capacity=?, image_url=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssisi', $name, $description, $capacity, $image_url, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Venue updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating venue: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: venues.php");
    exit();
}
?>