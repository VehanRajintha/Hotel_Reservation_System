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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_reservation'])) {
    $user_email = $_SESSION['user_email'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $guests = $_POST['guests'];
    $venue = $_POST['venue'];
    $special_requests = $_POST['special_requests'];

    $sql = "INSERT INTO reservations (user_email, reservation_date, reservation_time, guests, venue, special_requests) 
            VALUES ('$user_email', '$reservation_date', '$reservation_time', '$guests', '$venue', '$special_requests')";

    if ($conn->query($sql) === TRUE) {
        header("Location: fake_payment.php");
        exit();
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
    <title>Book Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            animation: slideIn 0.5s ease-in-out;
        }
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        h1 {
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            position: relative;
        }
        .input-group input,
        .input-group textarea,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-group input:focus,
        .input-group textarea:focus,
        .input-group select:focus {
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
        .input-group input:not(:placeholder-shown) + label,
        .input-group textarea:focus + label,
        .input-group textarea:not(:placeholder-shown) + label,
        .input-group select:focus + label,
        .input-group select:not(:placeholder-shown) + label {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Book a Reservation</h1>
        <form method="POST">
            <div class="input-group">
                <input type="date" id="reservation_date" name="reservation_date" required placeholder=" ">
                <label for="reservation_date">Date</label>
            </div>
            <div class="input-group">
                <input type="time" id="reservation_time" name="reservation_time" required placeholder=" ">
                <label for="reservation_time">Time</label>
            </div>
            <div class="input-group">
                <input type="number" id="guests" name="guests" required placeholder=" ">
                <label for="guests">Number of Guests</label>
            </div>
            <div class="input-group">
                <select id="venue" name="venue" required>
                    <option value="" disabled selected hidden></option>
                    <option value="Venue 1">Grand Ballroom</option>
                    <option value="Venue 2">Garden Terrace</option>
                    <option value="Venue 3">Seaside Pavilion</option>
                    <option value="Venue 4">Skyline Lounge</option>
                    <option value="Venue 5">Rustic Barn</option>
                    <option value="Venue 5">Crystal Hall</option>
                </select>
                <label for="venue">Venue</label>
            </div>
            <div class="input-group">
                <textarea id="special_requests" name="special_requests" placeholder=" "></textarea>
                <label for="special_requests">Special Requests</label>
            </div>
            <button type="submit" name="book_reservation">Book Reservation</button>
        </form>
    </div>
</body>
</html>