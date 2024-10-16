<?php
// Database connection
$host = 'localhost';
$db = 'Hotel_Reservation';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php?message=User deleted successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: users.php");
}
?>