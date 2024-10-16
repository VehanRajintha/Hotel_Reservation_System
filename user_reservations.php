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

$notification = "";

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $sql = "DELETE FROM reservations WHERE id='$reservation_id'";
    if ($conn->query($sql) === TRUE) {
        $notification = "Reservation deleted successfully!";
    } else {
        $notification = "Error deleting reservation: " . $conn->error;
    }
}

// Handle update action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];
    $guests = $_POST['guests'];
    $venue = $_POST['venue'];
    $special_requests = $_POST['special_requests'];

    $sql = "UPDATE reservations SET reservation_date='$reservation_date', reservation_time='$reservation_time', guests='$guests', venue='$venue', special_requests='$special_requests' WHERE id='$reservation_id'";
    if ($conn->query($sql) === TRUE) {
        $notification = "Reservation updated successfully!";
    } else {
        $notification = "Error updating reservation: " . $conn->error;
    }
}

// Fetch reservations for the logged-in user
$user_email = $_SESSION['user_email'];
$sql = "SELECT * FROM reservations WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
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
            width: 80%;
            max-width: 1000px;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            display: block;
            width: 100px;
            padding: 10px;
            margin: 0 auto;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .edit-button, .delete-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .edit-button {
            background-color: #28a745;
            color: #fff;
        }
        .edit-button:hover {
            background-color: #218838;
        }
        .delete-button {
            background-color: #dc3545;
            color: #fff;
        }
        .delete-button:hover {
            background-color: #c82333;
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
        .popup-form .input-group input,
        .popup-form .input-group select,
        .popup-form .input-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            transition: border-color 0.3s;
        }
        .popup-form .input-group input:focus,
        .popup-form .input-group select:focus,
        .popup-form .input-group textarea:focus {
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
        .popup-form .input-group input:not(:placeholder-shown) + label,
        .popup-form .input-group select:focus + label,
        .popup-form .input-group select:not(:placeholder-shown) + label,
        .popup-form .input-group textarea:focus + label,
        .popup-form .input-group textarea:not(:placeholder-shown) + label {
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
            z-index: 1000;
        }
        .notification.error {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="notification" id="notification"></div>
    <div class="container">
        <h1>Reservations List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Email</th>
                    <th>Reservation Date</th>
                    <th>Reservation Time</th>
                    <th>Guests</th>
                    <th>Venue</th>
                    <th>Special Requests</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['user_email']}</td>
                                <td>{$row['reservation_date']}</td>
                                <td>{$row['reservation_time']}</td>
                                <td>{$row['guests']}</td>
                                <td>{$row['venue']}</td>
                                <td>{$row['special_requests']}</td>
                                <td>{$row['created_at']}</td>
                                <td class='action-buttons'>
                                    <button class='edit-button' onclick='openEditPopup({$row['id']}, \"{$row['reservation_date']}\", \"{$row['reservation_time']}\", {$row['guests']}, \"{$row['venue']}\", \"{$row['special_requests']}\")'>Edit</button>
                                    <form method='POST' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this reservation?\");'>
                                        <input type='hidden' name='reservation_id' value='{$row['id']}'>
                                        <button type='submit' name='delete_reservation' class='delete-button'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="user_dashboard.php" class="back-button">Back</a>
    </div>

    <div class="popup" id="editPopup">
        <div class="popup-header">
            <h2>Edit Reservation</h2>
            <button class="popup-close" onclick="closeEditPopup()">&times;</button>
        </div>
        <form class="popup-form" method="POST">
            <input type="hidden" id="edit_reservation_id" name="reservation_id">
            <div class="input-group">
                <input type="date" id="edit_reservation_date" name="reservation_date" required placeholder=" ">
                <label for="edit_reservation_date">Date</label>
            </div>
            <div class="input-group">
                <input type="time" id="edit_reservation_time" name="reservation_time" required placeholder=" ">
                <label for="edit_reservation_time">Time</label>
            </div>
            <div class="input-group">
                <input type="number" id="edit_guests" name="guests" required placeholder=" ">
                <label for="edit_guests">Number of Guests</label>
            </div>
            <div class="input-group">
                <select id="edit_venue" name="venue" required>
                    <option value="Venue 1">Venue 1</option>
                    <option value="Venue 2">Venue 2</option>
                    <option value="Venue 3">Venue 3</option>
                    <option value="Venue 4">Venue 4</option>
                    <option value="Venue 5">Venue 5</option>
                </select>
                <label for="edit_venue">Venue</label>
            </div>
            <div class="input-group">
                <textarea id="edit_special_requests" name="special_requests" placeholder=" "></textarea>
                <label for="edit_special_requests">Special Requests</label>
            </div>
            <button type="submit" name="update_reservation">Save</button>
        </form>
    </div>

    <script>
        function openEditPopup(id, date, time, guests, venue, specialRequests) {
            document.getElementById('edit_reservation_id').value = id;
            document.getElementById('edit_reservation_date').value = date;
            document.getElementById('edit_reservation_time').value = time;
            document.getElementById('edit_guests').value = guests;
            document.getElementById('edit_venue').value = venue;
            document.getElementById('edit_special_requests').value = specialRequests;
            document.getElementById('editPopup').classList.add('active');
        }

        function closeEditPopup() {
            document.getElementById('editPopup').classList.remove('active');
        }

        function showNotification(message, isError = false) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.toggle('error', isError);
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }

        <?php if (!empty($notification)): ?>
            document.addEventListener('DOMContentLoaded', () => {
                showNotification("<?php echo $notification; ?>", <?php echo strpos($notification, 'Error') !== false ? 'true' : 'false'; ?>);
            });
        <?php endif; ?>
    </script>
</body>
</html>