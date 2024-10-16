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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $full_name = $_POST['new_full_name'];
    $email = $_POST['new_email'];
    $password = $_POST['new_password']; // Note: Consider hashing the password for security

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php?message=User added successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: users.php");
}
?>