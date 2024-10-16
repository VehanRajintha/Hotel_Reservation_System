<?php
// Include database connection

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reservation'])) {
    // Get the form data
    $date = $_POST['reservation_date'];
    $time = $_POST['reservation_time'];
    $guests = $_POST['guests'];
    $venue = $_POST['venue'];
    $specialRequests = $_POST['special_requests'];

    // Prepare the SQL statement
    $sql = "INSERT INTO reservations (reservation_date, reservation_time, guests, venue, special_requests) VALUES (?, ?, ?, ?, ?)";

    // Initialize the prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param('ssiss', $date, $time, $guests, $venue, $specialRequests);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the reservations page with a success message
            header("Location: admin_reservations.php?message=Reservation added successfully");
        } else {
            // Redirect to the reservations page with an error message
            header("Location: admin_reservations.php?error=Failed to add reservation");
        }

        // Close the statement
        $stmt->close();
    } else {
        // Redirect to the reservations page with an error message
        header("Location: admin_reservations.php?error=Failed to prepare the SQL statement");
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the reservations page if the request method is not POST
    header("Location: admin_reservations.php");
}
?>