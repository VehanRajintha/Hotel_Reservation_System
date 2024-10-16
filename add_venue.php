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



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_venue'])) {
    // Get the form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    // Handle the file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Prepare the SQL statement
        $sql = "INSERT INTO venues (name, description, capacity, image_url) VALUES (?, ?, ?, ?)";

        // Initialize the prepared statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind the parameters
            $stmt->bind_param('ssis', $name, $description, $capacity, $target_file);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to the venues page with a success message
                header("Location: venues.php?message=Venue added successfully");
            } else {
                // Redirect to the venues page with an error message
                header("Location: venues.php?error=Failed to add venue");
            }

            // Close the statement
            $stmt->close();
        } else {
            // Redirect to the venues page with an error message
            header("Location: venues.php?error=Failed to prepare the SQL statement");
        }
    } else {
        header("Location: venues.php?error=Failed to upload image");
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the venues page if the request method is not POST
    header("Location: venues.php");
}
?>