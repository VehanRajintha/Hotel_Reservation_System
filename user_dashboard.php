<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Hotel Reservation Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
            color: #1f2937;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            flex-grow: 1;
        }
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .reservation {
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            margin-bottom: 1rem;
        }
        .action-btn {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #2563eb;
        }
        .activity-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .activity-icon {
            width: 1.5rem;
            height: 1.5rem;
            margin-right: 0.5rem;
            background-color: #e5e7eb;
            border-radius: 50%;
        }
        nav {
            background-color: #ffffff;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav ul li a {
            text-decoration: none;
            color: #1f2937;
            font-weight: 500;
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #3b82f6;
        }
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        footer {
            background-color: #1f2937;
            color: #ffffff;
            padding: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="#" style="font-size: 1.25rem; font-weight: 600;">WeddingStay</a></li>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="user_reservations.php">Reservations</a></li>
            <li><a href="user_venues.php">Venues</a></li>
            <li><a href="user_profile.php">Profile</a></li>
            <li class="user-profile">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
                <img src="images/profile.png" alt="User Avatar" class="user-avatar">
            </li>
            <li><a href="logout.php" style="font-size: 1.25rem; font-weight: 600;">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1 style="margin-bottom: 2rem;">Wedding Hotel Reservation Dashboard</h1>
        <div class="dashboard">
            <div class="card">
                <h2 class="card-title">Upcoming Reservations</h2>
                <div class="reservation">
                    <h3 style="margin: 0;">Smith-Johnson Wedding</h3>
                    <p style="margin: 0.5rem 0;">June 15, 2024 - June 17, 2024</p>
                    <p style="margin: 0;">50 guests • Grand Ballroom</p>
                </div>
                <div class="reservation">
                    <h3 style="margin: 0;">Garcia-Lee Celebration</h3>
                    <p style="margin: 0.5rem 0;">July 22, 2024 - July 24, 2024</p>
                    <p style="margin: 0;">75 guests • Garden Terrace</p>
                </div>
            </div>
            <div class="card">
                <h2 class="card-title">Quick Actions</h2>
                <button class="action-btn" style="display: block; width: 100%; margin-bottom: 1rem;" onclick="redirectToReservation()">New Reservation</button>
                <button class="action-btn" style="display: block; width: 100%; margin-bottom: 1rem;" onclick="redirectToReservations()">Modify Booking</button>
                <button class="action-btn" style="display: block; width: 100%; margin-bottom: 1rem;">Contact Support</button>
            </div>
            <div class="card">
                <h2 class="card-title">Recent Activities</h2>
                <div class="activity-item">
                    <div class="activity-icon"></div>
                    <p style="margin: 0;">Updated guest list for Smith-Johnson Wedding</p>
                </div>
                <div class="activity-item">
                    <div class="activity-icon"></div>
                    <p style="margin: 0;">Added special meal requests for Garcia-Lee Celebration</p>
                </div>
                <div class="activity-item">
                    <div class="activity-icon"></div>
                    <p style="margin: 0;">Confirmed floral arrangements for Thompson Wedding</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">WeddingStay</h3>
                    <p style="margin: 0;">Making your special day perfect</p>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Quick Links</h4>
                    <ul style="list-style-type: none; padding: 0;">
                        <li><a href="#" style="color: #ffffff; text-decoration: none;">About Us</a></li>
                        <li><a href="#" style="color: #ffffff; text-decoration: none;">Contact</a></li>
                        <li><a href="#" style="color: #ffffff; text-decoration: none;">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="margin-bottom: 0.5rem;">Follow Us</h4>
                    <a href="#" style="color: #ffffff; text-decoration: none; margin-right: 1rem;">Facebook</a>
                    <a href="#" style="color: #ffffff; text-decoration: none; margin-right: 1rem;">Instagram</a>
                    <a href="#" style="color: #ffffff; text-decoration: none;">Twitter</a>
                </div>
            </div>
            <p style="margin: 0;">&copy; 2024 WeddingStay. All rights reserved.</p>
        </div>
    </footer>
    <script>
        function redirectToReservation() {
            window.location.href = 'book_reservation.php';
        }
    </script>
    <script>
        function redirectToReservations() {
            window.location.href = 'user_reservations.php';
        }
    </script>
</body>
</html>