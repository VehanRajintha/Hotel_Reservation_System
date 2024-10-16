<?php
// Include database connection
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM venues WHERE id = ?";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param('i', $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the venues page with a success message
            header("Location: venues.php?message=Venue deleted successfully");
        } else {
            // Redirect to the venues page with an error message
            header("Location: venues.php?error=Failed to delete venue");
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect to the venues page with an error message
        header("Location: venues.php?error=Failed to prepare the SQL statement");
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the venues page if no ID is provided
    header("Location: venues.php");
}
?>