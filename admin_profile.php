<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

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

$admin_email = $_SESSION['admin_email'];
$sql = "SELECT email, password FROM admin WHERE email='$admin_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    echo "No admin found!";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Do not hash the password

    $update_sql = "UPDATE admin SET email='$email', password='$password' WHERE email='$admin_email'";

    if ($conn->query($update_sql) === TRUE) {
        // Destroy the session and redirect to admin_login.php
        session_destroy();
        header("Location: admin_login.php?message=Profile updated successfully. Please log in again.");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle add admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_admin'])) {
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password']; // Do not hash the password

    $insert_sql = "INSERT INTO admin (email, password) VALUES ('$new_email', '$new_password')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('Admin added successfully');</script>";
    } else {
        echo "Error adding admin: " . $conn->error;
    }
}

// Fetch all admins
$admins_sql = "SELECT email FROM admin";
$admins_result = $conn->query($admins_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .admin-list {
            width: 30%;
            padding: 20px;
            background-color: #007BFF;
            color: #fff;
        }
        .admin-list h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }
        .admin-list ul {
            list-style-type: none;
            padding: 0;
        }
        .admin-list li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #0056b3;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .admin-list li:hover {
            background-color: #004494;
        }
        .main-content {
            width: 70%;
            padding: 40px;
        }
        .main-content h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }
        .main-content form {
            display: flex;
            flex-direction: column;
        }
        .main-content form div {
            margin-bottom: 15px;
        }
        .main-content form label {
            font-size: 1em;
            margin-bottom: 5px;
            color: #555;
        }
        .main-content form input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }
        .main-content form input:focus {
            border-color: #007BFF;
            outline: none;
        }
        .main-content button {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .main-content button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 50%;
            border-radius: 8px;
            animation: fadeIn 0.3s ease;
        }
        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .popup-header h2 {
            font-size: 1.5em;
            color: #333;
        }
        .popup-close {
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #333;
        }
        .popup form {
            display: flex;
            flex-direction: column;
        }
        .popup form div {
            margin-bottom: 15px;
        }
        .popup form label {
            font-size: 1em;
            margin-bottom: 5px;
            color: #555;
        }
        .popup form input {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease;
        }
        .popup form input:focus {
            border-color: #007BFF;
            outline: none;
        }
        .popup button {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .popup button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="admin-list">
        <h2>Admin List</h2>
        <ul>
            <?php
            if ($admins_result->num_rows > 0) {
                while ($admin_row = $admins_result->fetch_assoc()) {
                    echo '<li>' . $admin_row['email'] . '</li>';
                }
            } else {
                echo '<li>No admins found.</li>';
            }
            ?>
        </ul>
    </div>
    <div class="main-content" style="width: 70%; padding: 40px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
    <h1 style="font-size: 2em; margin-bottom: 20px; color: #333;">Admin Profile</h1>
    <button onclick="redirectToDashboard()" style="margin-bottom: 20px; padding: 10px 20px; font-size: 1em; color: #fff; background-color: #6c757d; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease; display: flex; align-items: center;">
        <span style="margin-right: 10px;">&#8592;</span> Back to Dashboard
    </button>
    <form action="admin_profile.php" method="POST" style="display: flex; flex-direction: column;">
        <div style="margin-bottom: 15px;">
            <label for="email" style="font-size: 1em; margin-bottom: 5px; color: #555;">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required style="padding: 10px; font-size: 1em; border: 1px solid #ccc; border-radius: 4px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); transition: border-color 0.3s ease;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="password" style="font-size: 1em; margin-bottom: 5px; color: #555;">Password:</label>
            <input type="password" id="password" name="password" required style="padding: 10px; font-size: 1em; border: 1px solid #ccc; border-radius: 4px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1); transition: border-color 0.3s ease;">
        </div>
        <button type="submit" name="update_profile" style="padding: 10px 20px; font-size: 1em; color: #fff; background-color: #007BFF; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">Update Profile</button>
    </form>
    <button onclick="openAddAdminPopup()" style="margin-top: 20px; padding: 10px 20px; font-size: 1em; color: #fff; background-color: #28a745; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">Add Admin</button>
</div>

    <!-- Add Admin Popup -->
    <div class="popup" id="addAdminPopup">
        <div class="popup-header">
            <h2>Add Admin</h2>
            <button class="popup-close" onclick="closeAddAdminPopup()">&times;</button>
        </div>
        <form action="admin_profile.php" method="POST">
            <div>
                <label for="new_email">Email:</label>
                <input type="email" id="new_email" name="new_email" required>
            </div>
            <div>
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="add_admin">Add Admin</button>
        </form>
    </div>

    <script>
        function openAddAdminPopup() {
            document.getElementById('addAdminPopup').style.display = 'block';
        }

        function closeAddAdminPopup() {
            document.getElementById('addAdminPopup').style.display = 'none';
        }
        function redirectToDashboard() {
            window.location.href = 'admin_dashboard.php';
        }
    </script>
</body>
</html>