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

// Fetch user data
$sql = "SELECT id, full_name, email FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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
            width: 80%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        .user-list {
            list-style-type: none;
            padding: 0;
        }
        .user-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .user-list li:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        .user-details {
            display: flex;
            flex-direction: column;
        }
        .user-details span {
            font-size: 1em;
            color: #555;
        }
        .user-details span.email {
            font-size: 0.9em;
            color: #777;
        }
        .add-user-btn {
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-bottom: 20px;
        }
        .add-user-btn:hover {
            background-color: #218838;
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
    
<div class="container">
        <h1>User List</h1>
        <button class="add-user-btn" onclick="openAddUserPopup()">Add User</button>
        <button onclick="redirectToDashboard()" style="margin-bottom: 20px; padding: 10px 20px; font-size: 1em; color: #fff; background-color: #6c757d; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease; display: flex; align-items: center;">
        <span style="margin-right: 10px;">&#8592;</span> Back to Dashboard
    </button>
        <ul class="user-list">
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li>';
                    echo '<div class="user-details">';
                    echo '<span class="full-name">' . $row['full_name'] . '</span>';
                    echo '<span class="email">' . $row['email'] . '</span>';
                    echo '</div>';
                    echo '<button class="edit-btn" onclick="openEditUserPopup(' . $row['id'] . ', \'' . $row['full_name'] . '\', \'' . $row['email'] . '\')" style="padding: 10px 20px; font-size: 1em; color: #fff; background-color: #007BFF; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;right: 10px;">Edit</button>';
                    echo '<button class="delete-btn" onclick="confirmDelete(' . $row['id'] . ')" style="padding: 10px 20px; font-size: 1em; color: #fff; background-color: #dc3545; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s ease, transform 0.3s ease;">Delete</button>';
                    echo '</li>';
                }
            } else {
                echo '<li>No users found.</li>';
            }
            $conn->close();
            ?>
        </ul>
        <!-- Edit User Popup -->
    <div class="popup" id="editUserPopup">
        <div class="popup-header">
            <h2>Edit User</h2>
            <button class="popup-close" onclick="closeEditUserPopup()">&times;</button>
        </div>
        <form action="edit_user.php" method="POST">
            <input type="hidden" id="edit_user_id" name="edit_user_id">
            <div>
                <label for="edit_full_name">Full Name:</label>
                <input type="text" id="edit_full_name" name="edit_full_name" required>
            </div>
            <div>
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="edit_email" required>
            </div>
            <div>
                <label for="edit_password">Password:</label>
                <input type="password" id="edit_password" name="edit_password">
            </div>
            <button type="submit" name="edit_user">Save Changes</button>
        </form>
    </div>
    </div>
    <!-- Add User Popup -->
    <div class="popup" id="addUserPopup">
        <div class="popup-header">
            <h2>Add User</h2>
            <button class="popup-close" onclick="closeAddUserPopup()">&times;</button>
        </div>
        <form action="add_user.php" method="POST">
            <div>
                <label for="new_full_name">Full Name:</label>
                <input type="text" id="new_full_name" name="new_full_name" required>
            </div>
            <div>
                <label for="new_email">Email:</label>
                <input type="email" id="new_email" name="new_email" required>
            </div>
            <div>
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
            <button type="submit" name="add_user">Add User</button>
        </form>
    </div>
    <script>
        function openAddUserPopup() {
            document.getElementById('addUserPopup').style.display = 'block';
        }

        function closeAddUserPopup() {
            document.getElementById('addUserPopup').style.display = 'none';
        }
    </script>
    <script>
        function openEditUserPopup(id, fullName, email) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_full_name').value = fullName;
            document.getElementById('edit_email').value = email;
            document.getElementById('editUserPopup').style.display = 'block';
        }

        function closeEditUserPopup() {
            document.getElementById('editUserPopup').style.display = 'none';
        }

        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = 'delete_user.php?id=' + id;
            }
        }
        function redirectToDashboard() {
            window.location.href = 'admin_dashboard.php';
        }
    </script>
</body>
</html>