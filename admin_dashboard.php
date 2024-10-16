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

// Fetch the count of rows in the reservations table
$sql = "SELECT COUNT(*) as count FROM reservations";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$reservation_count = $row['count'];

// Fetch the count of rows in the venues table
$sql = "SELECT COUNT(*) as count FROM venues";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$venue_count = $row['count'];

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
        .nav-link:hover, .nav-link.active {
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            font-weight: 600;
            color: #4b5563;
        }
        .status {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-confirmed {
            background-color: #dcfce7;
            color: #15803d;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
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
                        <a href="admin_dashboard.php" class="nav-link active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_reservations.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Reservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="venues.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Venues
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="users.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Clients
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_profile.php" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1 class="greeting">Welcome back, Admin</h1>
                
            </header>
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Reservations</div>
                    <div class="stat-value"><?php echo $reservation_count; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Upcoming Events</div>
                    <div class="stat-value">42</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Available Venues</div>
                    <div class="stat-value"><?php echo $venue_count; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Revenue (This Month)</div>
                    <div class="stat-value">$52,680</div>
                </div>
            </section>
            <section class="recent-bookings">
                <h2 class="section-title">Recent Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Guests</th>
                            <th>Venue</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Hardcoding status for demonstration purposes
                        $status_class = 'status-confirmed'; // or 'status-pending'
                        $status_text = 'Confirmed'; // or 'Pending'
                        echo "<tr>
                                <td>{$row['user_email']}</td>
                                <td>{$row['reservation_date']}</td>
                                <td>{$row['reservation_time']}</td>
                                <td>{$row['guests']}</td>
                                <td>{$row['venue']}</td>
                                <td>{$row['special_requests']}</td>
                                <td><span class='status {$status_class}'>{$status_text}</span></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No reservations found</td></tr>";
                }
                ?>
            </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>