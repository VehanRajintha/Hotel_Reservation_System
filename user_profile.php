<?php
session_start();
if (!isset($_SESSION['user_email'])) {
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

$user_email = $_SESSION['user_email'];
$sql = "SELECT full_name, email, password FROM users WHERE email='$user_email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found!";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $update_sql = "UPDATE users SET full_name='$fullName', email='$email', password='$password' WHERE email='$user_email'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['user_email'] = $email; // Update session email
        header("Location: user_profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_account'])) {
    $delete_sql = "DELETE FROM users WHERE email='$user_email'";

    if ($conn->query($delete_sql) === TRUE) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1f2937;
        }
        .profile-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            width: 100%;
            max-width: 480px;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1.5rem;
        }
        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }
        .profile-info {
            margin-bottom: 2rem;
        }
        .info-item {
            display: flex;
            margin-bottom: 1rem;
            align-items: center;
        }
        .info-label {
            font-weight: 600;
            width: 120px;
        }
        .info-value {
            color: #4b5563;
            flex: 1;
        }
        .profile-actions {
            display: flex;
            gap: 1rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
        }
        .btn-edit:hover {
            background-color: #2563eb;
        }
        .btn-delete {
            background-color: #ef4444;
            color: #ffffff;
            border: none;
        }
        .btn-delete:hover {
            background-color: #dc2626;
        }
        .password-field {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .popup.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }
        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .popup-header h2 {
            margin: 0;
        }
        .popup-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }
        .popup-form .input-group {
            margin-bottom: 15px;
            position: relative;
        }
        .popup-form .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }
        .popup-form .input-group input:focus {
            border-color: #007bff;
        }
        .popup-form .input-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 0 5px;
            color: #999;
            transition: top 0.3s, color 0.3s;
        }
        .popup-form .input-group input:focus + label,
        .popup-form .input-group input:not(:placeholder-shown) + label {
            top: -10px;
            color: #007bff;
        }
        .popup-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .popup-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img src="images/profile.png" alt="<?php echo htmlspecialchars($user['full_name']); ?>" class="profile-picture">
            <div>
                <h1 class="profile-name"><?php echo htmlspecialchars($user['full_name']); ?></h1>
            </div>
        </div>
        <div class="profile-info">
            <div class="info-item">
                <span class="info-label">Full Name:</span>
                <span class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Password:</span>
                <div class="info-value password-field">
                    <span id="password-display">••••••••</span>
                   
                </div>
            </div>
        </div>
        <div class="profile-actions">
            <button class="btn btn-edit" onclick="openPopup()">Edit Profile</button>
            <button class="btn btn-delete" onclick="confirmDelete()">Delete Account</button>
        </div>
    </div>

    <div class="popup" id="editPopup">
        <div class="popup-header">
            <h2>Edit Profile</h2>
            <button class="popup-close" onclick="closePopup()">&times;</button>
        </div>
        <form class="popup-form" method="POST">
            <div class="input-group">
                <input type="text" id="full_name" name="full_name" required placeholder=" " value="<?php echo htmlspecialchars($user['full_name']); ?>">
                <label for="full_name">Full Name</label>
            </div>
            <div class="input-group">
                <input type="email" id="email" name="email" required placeholder=" " value="<?php echo htmlspecialchars($user['email']); ?>">
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" required placeholder=" ">
                <label for="password">Password</label>
            </div>
            <button type="submit" name="update_profile">Update</button>
        </form>
    </div>
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="delete_account" value="1">
    </form>

    <script>
        function togglePassword() {
            const passwordDisplay = document.getElementById('password-display');
            const toggleButton = document.querySelector('.password-toggle');
            if (passwordDisplay.textContent === '••••••••') {
                passwordDisplay.textContent = '<?php echo htmlspecialchars($user['password']); ?>'; // Replace with actual password in a real app
                toggleButton.textContent = 'Hide';
            } else {
                passwordDisplay.textContent = '••••••••';
                
            }
        }

        function openPopup() {
            document.getElementById('editPopup').classList.add('active');
        }

        function closePopup() {
            document.getElementById('editPopup').classList.remove('active');
        }
        function confirmDelete() {
            if (confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>