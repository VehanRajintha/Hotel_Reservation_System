<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - WeddingStay</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Raleway:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        header {
            text-align: center;
            margin-bottom: 3rem;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: #3a0ca3;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #666;
        }
        .contact-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 4rem;
        }
        .contact-form {
            flex: 1;
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        input, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            font-family: 'Raleway', sans-serif;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        button {
            background-color: #4361ee;
            color: #fff;
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #3a0ca3;
        }
        .contact-info {
            flex: 1;
        }
        .info-item {
            margin-bottom: 2rem;
        }
        .info-item h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: #3a0ca3;
            margin-bottom: 0.5rem;
        }
        .info-item p {
            font-size: 1.1rem;
            color: #666;
        }
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .social-links a {
            color: #4361ee;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }
        .social-links a:hover {
            color: #3a0ca3;
        }
        #successMessage {
            display: none;
            background-color: #4caf50;
            color: white;
            text-align: center;
            padding: 1rem;
            border-radius: 5px;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Contact Us</h1>
            <p class="subtitle">We're here to make your special day perfect</p>
        </header>
        <div class="contact-wrapper">
            <form id="contactForm" class="contact-form">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit">Send Message</button>
            </form>
            <div class="contact-info">
                <div class="info-item">
                    <h3>Address</h3>
                    <p>123 Wedding Lane, Celebration City, State 12345</p>
                </div>
                <div class="info-item">
                    <h3>Phone</h3>
                    <p>+1 (555) 123-4567</p>
                </div>
                <div class="info-item">
                    <h3>Email</h3>
                    <p>info@weddingstay.com</p>
                </div>
                <div class="info-item">
                    <h3>Business Hours</h3>
                    <p>Monday - Friday: 9am - 6pm<br>Saturday: 10am - 4pm<br>Sunday: Closed</p>
                </div>
                <div class="social-links">
                    <a href="#" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="#" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        <div id="successMessage">Thank you for your message. We'll get back to you soon!</div>
    </div>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Simulate form submission
            setTimeout(function() {
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('contactForm').reset();
            }, 1000);
        });
    </script>
</body>
</html>