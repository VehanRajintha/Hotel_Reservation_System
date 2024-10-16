<?php
session_start();
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

$notification = "";

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $fullName = $_POST['registerName'];
    $email = $_POST['registerEmail'];
    $password = password_hash($_POST['registerPassword'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$fullName', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $notification = "Registration successful!";
    } else {
        $notification = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: user_dashboard.php");
            exit();
        } else {
            $notification = "Invalid password!";
        }
    } else {
        $notification = "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            position: relative;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-group input:focus {
            border-color: #007bff;
        }
        .input-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background-color: #fff;
            padding: 0 5px;
            color: #999;
            transition: top 0.3s, color 0.3s;
        }
        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            top: -10px;
            color: #007bff;
        }
        button {
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
        button:hover {
            background-color: #0056b3;
        }
        .switch {
            margin-top: 15px;
            color: #007bff;
            cursor: pointer;
            transition: color 0.3s;
        }
        .switch:hover {
            color: #0056b3;
        }
        .hidden {
            display: none;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
        .notification.error {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="notification" id="notification"><?php echo $notification; ?></div>
    <div class="container">
        <h2>Welcome Back</h2>
        <form id="loginForm" method="POST">
            <div class="input-group">
                <input type="email" id="loginEmail" name="loginEmail" required placeholder=" ">
                <label for="loginEmail">Email</label>
            </div>
            <div class="input-group">
                <input type="password" id="loginPassword" name="loginPassword" required placeholder=" ">
                <label for="loginPassword">Password</label>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <p class="switch" onclick="flipCard()">Need an account? Register</p>

        <h2 class="hidden">Create Account</h2>
        <form id="registerForm" method="POST" class="hidden">
            <div class="input-group">
                <input type="text" id="registerName" name="registerName" required placeholder=" ">
                <label for="registerName">Full Name</label>
            </div>
            <div class="input-group">
                <input type="email" id="registerEmail" name="registerEmail" required placeholder=" ">
                <label for="registerEmail">Email</label>
            </div>
            <div class="input-group">
                <input type="password" id="registerPassword" name="registerPassword" required placeholder=" ">
                <label for="registerPassword">Password</label>
            </div>
            <div class="input-group">
                <input type="password" id="confirmPassword" name="confirmPassword" required placeholder=" ">
                <label for="confirmPassword">Confirm Password</label>
            </div>
            <button type="submit" name="register">Register</button>
        </form>
        <p class="switch hidden" onclick="flipCard()">Already have an account? Login</p>
    </div>

    <script>
        function flipCard() {
            document.querySelectorAll('h2, form, .switch').forEach(el => el.classList.toggle('hidden'));
        }

        // Show notification if it exists
        const notification = document.getElementById('notification');
        if (notification.textContent.trim() !== "") {
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>