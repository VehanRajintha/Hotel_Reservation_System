<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - WeddingStay</title>
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
        h1, h2 {
            font-family: 'Playfair Display', serif;
            color: #3a0ca3;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #666;
        }
        .about-section {
            display: flex;
            gap: 4rem;
            margin-bottom: 4rem;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .about-section.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .about-content {
            flex: 1;
        }
        .about-image {
            flex: 1;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }
        .about-image:hover img {
            transform: scale(1.05);
        }
        .values {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            margin-top: 2rem;
        }
        .value-item {
            text-align: center;
            flex: 1;
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .value-item:hover {
            transform: translateY(-5px);
            cursor: pointer;
        }
        .value-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #4361ee;
        }
        .faq-section {
            margin-top: 4rem;
        }
        .faq-item {
            background-color: #fff;
            border-radius: 10px;
            margin-bottom: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .faq-question {
            font-weight: 600;
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-question::after {
            content: '+';
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        .faq-answer {
            padding: 0 1rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        .faq-item.active .faq-answer {
            padding: 1rem;
            max-height: 1000px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>About WeddingStay</h1>
            <p class="subtitle">Creating Unforgettable Wedding Experiences</p>
        </header>

        <section class="about-section">
            <div class="about-content">
                <h2>Our Story</h2>
                <p>WeddingStay was born out of a passion for creating magical moments. Founded in 2010, we've been helping couples turn their dream weddings into reality for over a decade. Our team of dedicated professionals works tirelessly to ensure that every detail of your special day is perfect.</p>
                <p>With a portfolio of stunning venues and a commitment to exceptional service, we've become the go-to choice for couples seeking a truly memorable wedding experience.</p>
            </div>
            <div class="about-image">
                <img src="images/pic6.jpg?height=400&width=600" alt="WeddingStay Venue">
            </div>
        </section>

        <section class="about-section">
            <div class="about-image">
                <img src="images/pic7.jpg?height=400&width=600" alt="WeddingStay Team">
            </div>
            <div class="about-content">
                <h2>Our Mission</h2>
                <p>At WeddingStay, our mission is to transform your wedding dreams into unforgettable realities. We believe that every love story is unique, and your wedding should reflect that uniqueness. Our goal is to provide you with not just a venue, but a canvas for your perfect day.</p>
                <div class="values">
                    <div class="value-item">
                        <div class="value-icon">❤️</div>
                        <h3>Passion</h3>
                        <p>We're passionate about creating magical moments.</p>
                    </div>
                    <div class="value-item">
                        <div class="value-icon">🌟</div>
                        <h3>Excellence</h3>
                        <p>We strive for excellence in every detail.</p>
                    </div>
                    <div class="value-item">
                        <div class="value-icon">🤝</div>
                        <h3>Dedication</h3>
                        <p>We're dedicated to making your day perfect.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-item">
                <div class="faq-question">How far in advance should I book my wedding venue?</div>
                <div class="faq-answer">
                    <p>We recommend booking your wedding venue at least 12-18 months in advance, especially if you're planning a wedding during peak season (typically May to October). This ensures you have the best chance of securing your preferred date and venue.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">What's included in your wedding packages?</div>
                <div class="faq-answer">
                    <p>Our wedding packages typically include the venue rental, basic decor, catering services, and a dedicated wedding coordinator. Additional services such as floral arrangements, entertainment, and custom decor can be added to personalize your package. We offer a range of options to suit different budgets and preferences.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">Can you accommodate dietary restrictions?</div>
                <div class="faq-answer">
                    <p>Our catering team is experienced in accommodating various dietary requirements, including vegetarian, vegan, gluten-free, and allergy-specific meals. We'll work with you to ensure all your guests' dietary needs are met without compromising on taste or presentation.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">Do you offer on-site accommodation for guests?</div>
                <div class="faq-answer">
                    <p>Yes, many of our venues offer on-site accommodation for the wedding couple and guests. The availability and capacity vary by location. We can also recommend nearby hotels and assist with group booking rates for your out-of-town guests.</p>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Animate sections on scroll
        function animateSections() {
            const sections = document.querySelectorAll('.about-section');
            sections.forEach(section => {
                const sectionTop = section.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (sectionTop < windowHeight * 0.75) {
                    section.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', animateSections);
        window.addEventListener('load', animateSections);

        // FAQ accordion functionality
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                faqItems.forEach(faqItem => faqItem.classList.remove('active'));
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>