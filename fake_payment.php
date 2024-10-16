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

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pay'])) {
    $user_email = $_SESSION['user_email'];
    $reservation_date = $_SESSION['reservation_date'];
    $reservation_time = $_SESSION['reservation_time'];
    $guests = $_SESSION['guests'];
    $special_requests = $_SESSION['special_requests'];

    $sql = "INSERT INTO reservations (user_email, reservation_date, reservation_time, guests, special_requests) VALUES ('$user_email', '$reservation_date', '$reservation_time', '$guests', '$special_requests')";

    if ($conn->query($sql) === TRUE) {
        // Clear session variables
        unset($_SESSION['reservation_date']);
        unset($_SESSION['reservation_time']);
        unset($_SESSION['guests']);
        unset($_SESSION['special_requests']);

        // Set a flag to show the notification
        $_SESSION['payment_success'] = true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake Payment Gateway</title>
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
        .payment-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="notification" id="notification">Payment Successful!</div>
    <div class="payment-container">
        <h1>Payment </h1>
        <p>Please enter your card details to complete your payment.</p>
        <form method="POST" onsubmit="showNotification(event)">
            <div class="input-group">
                <input type="text" id="card_number" name="card_number" required placeholder=" ">
                <label for="card_number">Card Number</label>
            </div>
            <div class="input-group">
                <input type="text" id="card_name" name="card_name" required placeholder=" ">
                <label for="card_name">Cardholder Name</label>
            </div>
            <div class="input-group">
                <input type="text" id="expiry_date" name="expiry_date" required placeholder=" ">
                <label for="expiry_date">Expiry Date (MM/YY)</label>
            </div>
            <div class="input-group">
                <input type="text" id="cvv" name="cvv" required placeholder=" ">
                <label for="cvv">CVV</label>
            </div>
            <button type="submit" name="pay">Pay</button>
        </form>
    </div>

    <script>
        function showNotification(event) {
            event.preventDefault();
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
                window.location.href = 'user_dashboard.php';
            }, 3000);
        }

        <?php if (isset($_SESSION['payment_success']) && $_SESSION['payment_success']): ?>
            document.addEventListener('DOMContentLoaded', () => {
                showNotification(new Event('submit'));
                <?php unset($_SESSION['payment_success']); ?>
            });
        <?php endif; ?>
    </script>
</body>
</html>