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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user'])) {
    $id = $_POST['edit_user_id'];
    $full_name = $_POST['edit_full_name'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];

    $sql = "UPDATE users SET full_name='$full_name', email='$email'";
    if (!empty($password)) {
        $sql .= ", password='$password'";
    }
    $sql .= " WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php?message=User updated successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: users.php");
}
?>