<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
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

// Fetch reservations
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Hotel Reservation Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 2rem;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #4f46e5;
        }

        .nav-list {
            list-style-type: none;
            padding: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #4b5563;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: background-color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #f3f4f6;
            color: #4f46e5;
        }

        .nav-link svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
        }

        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .greeting {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-title {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
        }

        .recent-bookings {
            background-color: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
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

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
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

        .edit-button,
        .delete-button {
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

        .popup-form .input-group input:focus+label,
        .popup-form .input-group input:not(:placeholder-shown)+label,
        .popup-form .input-group select:focus+label,
        .popup-form .input-group select:not(:placeholder-shown)+label,
        .popup-form .input-group textarea:focus+label,
        .popup-form .input-group textarea:not(:placeholder-shown)+label {
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
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">WeddingStay</div>
            <nav>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="admin_dashboard.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_reservations.php" class="nav-link active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Reservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="venues.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Venues
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="users.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_profile.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                
            <button class="action-btn" onclick="openAddPopup()"
        style="background-color: #4f46e5; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; position: absolute; top: 1rem; right: 1rem;">
    + New Reservation
</button>
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
                                while ($row = $result->fetch_assoc()) {
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

                </div>

                <div class="popup" id="editPopup">
                    <div class="popup-header">
                        <h2>Edit Reservation</h2>
                        <button class="popup-close" onclick="closeEditPopup()">&times;</button>
                    </div>
                    <form action="update_reservation.php" method="POST">
                        <input type="hidden" id="edit_reservation_id" name="reservation_id">
                        <div class="input-group">
                            <input type="date" id="edit_reservation_date" name="reservation_date" required
                                placeholder=" ">
                            <label for="edit_reservation_date">Date</label>
                        </div>
                        <div class="input-group">
                            <input type="time" id="edit_reservation_time" name="reservation_time" required
                                placeholder=" ">
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
        </main>
    </div>
    <!-- Add Reservation Popup -->
    <div class="popup" id="addPopup"
        style="display: none; position: fixed; top: 50%; left: 30%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
        <div class="popup-header"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Add Reservation</h2>
            <button class="popup-close" onclick="closeAddPopup()"
                style="background: none; border: none; font-size: 1.5em; cursor: pointer;">&times;</button>
        </div>
        <form action="add_reservation.php" method="POST">
            <div class="input-group" style="margin-bottom: 15px;">
            <label for="add_reservation_date" style="display: block; margin-top: 5px;">Date</label>
                <input type="date" id="add_reservation_date" name="reservation_date" required placeholder=" "
                    style="width: 100%; padding: 10px; box-sizing: border-box;">
                
            </div>
            <div class="input-group" style="margin-bottom: 15px;">
            <label for="add_reservation_time" style="display: block; margin-top: 5px;">Time</label>
                <input type="time" id="add_reservation_time" name="reservation_time" required placeholder=" "
                    style="width: 100%; padding: 10px; box-sizing: border-box;">
                
            </div>
            <div class="input-group" style="margin-bottom: 15px;">
            <label for="add_guests" style="display: block; margin-top: 5px;">Number of Guests</label>
                <input type="number" id="add_guests" name="guests" required placeholder=" "
                    style="width: 100%; padding: 10px; box-sizing: border-box;">
                
            </div>
            <div class="input-group" style="margin-bottom: 15px;">
            <label for="add_venue" style="display: block; margin-top: 5px;">Venue</label>
                <select id="add_venue" name="venue" required
                    style="width: 100%; padding: 10px; box-sizing: border-box;">
                    <option value="Venue 1">Venue 1</option>
                    <option value="Venue 2">Venue 2</option>
                    <option value="Venue 3">Venue 3</option>
                    <option value="Venue 4">Venue 4</option>
                    <option value="Venue 5">Venue 5</option>
                </select>
               
            </div>
            <div class="input-group" style="margin-bottom: 15px;">
            <label for="add_special_requests" style="display: block; margin-top: 5px;">Special Requests</label>
                <textarea id="add_special_requests" name="special_requests" placeholder=" "
                    style="width: 100%; padding: 10px; box-sizing: border-box;"></textarea>
               
            </div>
            <button type="submit" name="add_reservation"
                style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer;">Save</button>
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
    </script>
    <script>
        function openAddPopup() {
            document.getElementById('addPopup').style.display = 'block';
        }

        function closeAddPopup() {
            document.getElementById('addPopup').style.display = 'none';
        }
    </script>
</body>

</html>