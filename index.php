<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAND OPEL - Wedding Hotel Reservations</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        header {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4a4a4a;
        }
        .nav-links a {
            color: #4a4a4a;
            text-decoration: none;
            margin-left: 1.5rem;
            transition: color 0.3s ease;
        }
        .nav-links a:hover {
            color: #ff9a9e;
        }
        .header-image {
            background-image: url('images/pic.jpg');
            background-size: cover;
            background-position: center;
            height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }
        .header-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }
        .header-image h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero {
            background-image: url('https://yvpxfvvxgwqvnqhvwjjm.supabase.co/storage/v1/object/public/images/wedding-venue.jpg');
            background-size: cover;
            background-position: center;
            height: 10vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 0 1rem;
        }
        .hero-content {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 10px;
        }
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .cta-button {
            background-color: #ff9a9e;
            color: #fff;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .cta-button:hover {
            background-color: #ff8088;
            transform: translateY(-3px);
        }
        .features {
            padding: 4rem 5%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .feature {
            flex-basis: calc(25% - 2rem);
            margin: 1rem;
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .feature img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .feature h3 {
            margin-bottom: 1rem;
            color: #4a4a4a;
        }
        .feature p {
            color: #666;
        }
        footer {
            background-color: #4a4a4a;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .feature {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }
        .feature:nth-child(1) { animation-delay: 0.1s; }
        .feature:nth-child(2) { animation-delay: 0.3s; }
        .feature:nth-child(3) { animation-delay: 0.5s; }
        .feature:nth-child(4) { animation-delay: 0.7s; }
        @media (max-width: 1024px) {
            .feature {
                flex-basis: calc(50% - 2rem);
            }
        }
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            .header-image h1, .hero h2 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 1rem;
            }
            .feature {
                flex-basis: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">GRAND OPEL</div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="aboutus.php">About</a>
                <a href="user_venues.php">Venues</a>
                <a href="contactus.php">Contact</a>
            </div>
        </nav>
    </header>

    <section class="header-image">
        <div class="header-content">
            <h1>Welcome to GRAND OPEL</h1>
            <p>Where Dreams Come True</p>
        </div>
    </section>

    <main>
        <section id="home" class="hero">
            <div class="hero-content">
                <h2>Your Dream Wedding Awaits</h2>
                <p>Experience luxury and romance at GRAND OPEL</p>
                <button class="cta-button" onclick="openReservation()">Book Now</button>
            </div>
        </section>

        <section id="features" class="features">
            <div class="feature">
                <img src="images/pic1.jpg" alt="Signature Cocktails">
                <h3>Signature Cocktails</h3>
                <p>Indulge in our exquisite selection of handcrafted cocktails, perfect for your celebration.</p>
            </div>
            <div class="feature">
                <img src="images/pic2.jpg" alt="Gourmet Cuisine">
                <h3>Gourmet Cuisine</h3>
                <p>Delight your guests with our world-class cuisine prepared by award-winning chefs.</p>
            </div>
            <div class="feature">
                <img src="images/pic3.jpg" alt="Family Packages">
                <h3>Family Packages</h3>
                <p>Create unforgettable memories with our specially curated family-friendly wedding packages.</p>
            </div>
            <div class="feature">
                <img src="images/pic4.jpg" alt="Decadent Desserts">
                <h3>Decadent Desserts</h3>
                <p>Indulge in our heavenly chocolate creations and sweet delights for your special day.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 GRAND OPEL. All rights reserved.</p>
    </footer>

    <script>

        // Intersection Observer for feature animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.feature').forEach(feature => {
            observer.observe(feature);
        });
    </script>
    <script>
        function openReservation() {
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>