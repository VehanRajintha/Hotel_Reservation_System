
<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "Hotel_Reservation"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch venues from the database
$sql = "SELECT * FROM venues";
$result = $conn->query($sql);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awesome Venues - WeddingStay</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        h1 {
            font-size: 2.5rem;
            color: #3a0ca3;
        }
        .add-venue-btn {
            background-color: #4361ee;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .add-venue-btn:hover {
            background-color: #3a0ca3;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
        }
        .venues-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .venue-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .venue-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        .venue-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .venue-info {
            padding: 1.5rem;
        }
        .venue-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #3a0ca3;
        }
        .venue-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }
        .venue-capacity {
            font-size: 0.9rem;
            color: #4361ee;
            font-weight: 500;
        }
        .book-btn {
            display: inline-block;
            background-color: #4361ee;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .book-btn:hover {
            background-color: #3a0ca3;
            transform: translateY(-2px);
        }
        .action-btn {
            background-color: #4f46e5;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
        .delete-btn {
    background-color: #e3342f;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    margin-top: 10px;
}
.delete-btn:hover {
    background-color: #cc1f1a;
}
    </style>
</head>
<body>

    <br>
    <h1 style="text-align: center; margin-top: 20px;">Venues</h1>
    <br><br>
<div class="venues-grid">
<?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="venue-card">';
            echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" class="venue-image">';
            echo '<div class="venue-info">';
            echo '<h2 class="venue-name">' . $row['name'] . '</h2>';
            echo '<p class="venue-description">' . $row['description'] . '</p>';
            echo '<p class="venue-capacity">Capacity: ' . $row['capacity'] . ' guests</p>';
            echo '<a href="book_reservation.php" class="book-btn">Book Now</a>';
            
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No venues found.</p>';
    }
    $conn->close();
    ?>
    </div>
    </div>

  <!-- Add Venue Popup -->
<div class="popup" id="addVenuePopup"
    style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000; width: 50%;">
    <div class="popup-header"
        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Add Venue</h2>
        <button class="popup-close" onclick="closeAddVenuePopup()"
            style="background: none; border: none; font-size: 1.5em; cursor: pointer;">&times;</button>
    </div>
    <form action="add_venue.php" method="POST" enctype="multipart/form-data">
        <div class="input-group" style="margin-bottom: 15px;">
        <label for="add_venue_name" style="display: block; margin-top: 5px;">Name</label>
            <input type="text" id="add_venue_name" name="name" required placeholder=" "
                style="width: 100%; padding: 10px; box-sizing: border-box;">
            
        </div>
        <div class="input-group" style="margin-bottom: 15px;">
        <label for="add_venue_description" style="display: block; margin-top: 5px;">Description</label>
            <textarea id="add_venue_description" name="description" required placeholder=" "
                style="width: 100%; padding: 10px; box-sizing: border-box;"></textarea>
           
        </div>
        <div class="input-group" style="margin-bottom: 15px;">
        <label for="add_venue_capacity" style="display: block; margin-top: 5px;">Capacity</label>
            <input type="number" id="add_venue_capacity" name="capacity" required placeholder=" "
                style="width: 100%; padding: 10px; box-sizing: border-box;">
            
        </div>
        <div class="input-group" style="margin-bottom: 15px;">
        <label for="add_venue_image" style="display: block; margin-top: 5px;">Image</label>
            <input type="file" id="add_venue_image" name="image" required
                style="width: 100%; padding: 10px; box-sizing: border-box;">
           
        </div>
        <button type="submit" name="add_venue"
            style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer;">Save</button>
    </form>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addVenueBtn = document.querySelector('.add-venue-btn');
            const venueCards = document.querySelectorAll('.venue-card');

            addVenueBtn.addEventListener('click', () => {
                alert('Add Venue functionality coming soon!');
            });

            venueCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) scale(1.03)';
                    card.style.boxShadow = '0 12px 30px rgba(0, 0, 0, 0.2)';
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) scale(1)';
                    card.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
                });
            });
        });
    </script>
    <script>
        function openAddVenuePopup() {
            document.getElementById('addVenuePopup').style.display = 'block';
        }

        function closeAddVenuePopup() {
            document.getElementById('addVenuePopup').style.display = 'none';
        }
    </script>
    <script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this venue?")) {
        window.location.href = "delete_venue.php?id=" + id;
    }
}
</script>
    
</body>
</html>