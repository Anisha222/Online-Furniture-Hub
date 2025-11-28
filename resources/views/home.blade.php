<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FurniHub</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html {
            scroll-behavior: smooth; /* Smooth scrolling for anchor links */
        }
        body {
            font-family: 'Times New Roman', serif; /* Changed font to Times New Roman */
            margin: 0;
            background-color: #f7f7f7;
            overflow-x: hidden; /* Prevent horizontal scroll from subtle animations */
        }
        /* Dynamic Feature 1: Navbar Base Style */
        .navbar {
            display: flex;
            justify-content: space-between; /* Distribute items with space between */
            align-items: center;
            padding: 1rem 2rem;
            background-color: #fff;
            box-shadow: 0 0 0 rgba(0,0,0,0); /* Base: No shadow */
            position: sticky; /* Make navbar sticky */
            top: 0;
            z-index: 1000; /* Ensure it stays on top */
            transition: all 0.3s ease-in-out; /* Smooth transition for dynamic changes */
        }
        /* Dynamic Feature 1: Navbar Scrolled State */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.95); /* Slightly translucent white */
            box-shadow: 0 2px 8px rgba(0,0,0,0.15); /* Prominent shadow when scrolled */
            padding: 0.8rem 2rem; /* Slight height reduction */
        }
        .navbar-brand {
            font-family: 'Times New Roman', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #4A0082;
            text-decoration: none;
            padding-bottom: 0;
            transition: color 0.3s ease, transform 0.2s ease; /* Added transform transition for hover */
        }
        .navbar-brand:hover {
            color: #333;
            transform: scale(1.05); /* Dynamic Feature 2: Subtle Zoom */
        }
        .navbar-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .navbar-links {
            display: flex;
            gap: 1.5rem;
        }
        .navbar-links a {
            color: #333;
            text-decoration: none;
            /* MODIFIED: Changed font-weight from 600 to 400 (normal) */
            font-weight: 400; 
            transition: color 0.3s ease, transform 0.2s ease; /* Added transform transition for hover */
        }
        .navbar-links a:hover,
        .navbar-links a.active {
            color: #4A0082;
            transform: translateY(-2px); /* Dynamic Feature 2: Subtle Lift */
        }
        .navbar-button button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .navbar-button button:hover {
            background-color: #0056b3;
            transform: translateY(-2px); /* Dynamic Feature 2: Subtle Lift */
        }

        /* --- Dynamic Feature 3: Hero Background Zoom Keyframes --- */
        @keyframes subtle-zoom {
            0% { background-size: 100%; }
            100% { background-size: 110%; }
        }

        .hero-section {
            background-image: url('/images/hero-bg.jpg'); /* Direct path from public folder for CSS */
            background-size: 100%; /* Initial size for animation */
            background-position: center;
            color: white;
            text-align: center;
            padding: 8rem 2rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            overflow: hidden; /* Hide excess background content from zoom */
            /* Apply Zoom Animation */
            animation: subtle-zoom 15s ease-in-out alternate infinite;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4); /* Dark overlay for text readability */
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        /* --- Dynamic Feature 4: Hero Text Animation Base State (Zoom In) --- */
        .hero-content h1, .hero-content p {
            opacity: 0;
            transform: scale(0.9); /* STARTS SLIGHTLY ZOOMED OUT (SMALL) */
            /* DECREASED DURATION FOR FASTER ANIMATION */
            transition: opacity 0.5s ease-out, transform 0.5s ease-out; 
            will-change: opacity, transform;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            /* DECREASED DELAY FOR FASTER START */
            transition-delay: 0.1s; 
        }
        .hero-content p {
            font-size: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
            /* DECREASED DELAY FOR FASTER START */
            transition-delay: 0.2s; 
        }
        /* --- Dynamic Feature 4: Hero Text Animated State (Visible) --- */
        .hero-content.animate h1, .hero-content.animate p {
            opacity: 1;
            transform: scale(1); /* ZOOOMS IN to normal size */
        }
        
        /* Rest of the styles remain the same */
        .section {
            padding: 4rem 2rem;
            text-align: center;
            background-color: #fff;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            /* Dynamic Feature 2: Scroll-Reveal Base */
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
            will-change: opacity, transform;
        }
        /* Dynamic Feature 2: Scroll-Reveal Visible State */
        .section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .section h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 3rem;
        }
        .section-content {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-item {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
            text-align: left;
            background-color: #fcfcfc; /* Light background for card effect */
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .section-item:hover {
            transform: translateY(-5px); /* Lift effect */
            box-shadow: 0 8px 20px rgba(0,0,0,0.15); /* Enhanced shadow */
            border: 1px solid #4A0082; /* Subtle highlight border */
        }
        .section-item h3 {
            font-size: 1.8rem;
            color: #4A0082;
            margin-bottom: 1rem;
        }
        .section-item p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
        }

        .team-grid, .guide-content {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }
        .team-member, .guide-member {
            text-align: center;
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            /* UPDATED: Smoother transition for 3D effect */
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); 
            /* NEW: Required for 3D transforms */
            transform-style: preserve-3d; 
        }

        /* Dynamic Feature 5: Card Tilt on Hover */
        .team-member:hover, .guide-member:hover {
            /* Adds a slight 3D tilt and zoom effect */
            transform: perspective(1000px) rotateX(2deg) rotateY(2deg) scale(1.03); 
            /* Enhanced shadow with a subtle purple glow */
            box-shadow: 0 10px 30px rgba(0,0,0,0.2), 0 0 10px rgba(74, 0, 130, 0.5); 
        }

        .team-member img, .guide-member img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 8px; /* Added slight border-radius for softer corners, adjust as desired */
            margin-bottom: 1rem;
            border: 3px solid #4A0082;
            /* To prevent image distortion during 3D transform */
            transform: translateZ(10px); 
        }
        .team-member h4, .guide-member h4 {
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        .team-member p, .guide-member p {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
            max-width: 400px;
            margin: 0.5rem auto 0 auto;
        }
        .guide-text {
            margin-top: 2rem;
            text-align: left;
            max-width: 800px;
            margin: 2rem auto 0 auto;
        }
        .guide-text p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .login-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="navbar" id="main-navbar">
        <a href="/" class="navbar-brand">FurniHub</a>
        <div class="navbar-group">
            <div class="navbar-links">
                <a href="#hero-section" class="active">Home</a>
                <a href="#mission-vision">Our Mission & Vision</a>
                <a href="#services-offered">Services</a>
                <a href="#system-overview">System Overview</a>
                <a href="#our-team">About Us</a>
            </div>
            <div class="navbar-button">
                <a href="{{ route('login') }}" class="login-btn">Login</a>
            </div>
        </div>
    </div>

    <div class="hero-section" id="hero-section">
        <div class="hero-content" id="hero-content">
            <h1>Welcome to FurniHub</h1>
            <p>Discover our beautiful collection of modern and classic furniture.</p>
        </div>
    </div>

    <div class="section" id="mission-vision">
        <h2>Our Mission and Vision</h2>
        <div class="section-content">
            <div class="section-item">
                <h3>Vision</h3>
                <p>Our vision is to revolutionize the furniture shopping experience by offering a seamless, customer-focused platform that provides high-quality, customizable furniture for every home.</p>
            </div>
            <div class="section-item">
                <h3>Mission</h3>
                <p>Our mission is to deliver a user-friendly, secure, and transparent platform where customers can explore, customize, and purchase furniture with ease, while ensuring exceptional quality and customer satisfaction.</p>
            </div>
        </div>
    </div>

    <div class="section" id="services-offered">
        <h2>Services Offered</h2>
        <div class="section-content">
            <div class="section-item">
                <h3>Online Furniture Catalog</h3>
                <p>Browse a wide range of furniture, including sofas, beds, chairs, and tables, with detailed descriptions and images.</p>
            </div>
            <div class="section-item">
                <h3>Order Tracking</h3>
                <p>Monitor the status of your orders in real-time, from confirmation to delivery.</p>
            </div>
            <div class="section-item">
                <h3>Customization Options</h3>
                <p>Personalize your furniture with various colors, materials, and designs to suit your style.</p>
            </div>
            <div class="section-item">
                <h3>Customer Support</h3>
                <p>Receive instant assistance via our support team for any inquiries or issues.</p>
            </div>
        </div>
    </div>

    <div class="section" id="system-overview">
        <h2>System Overview</h2>
        <div class="section-content">
            <div class="section-item">
                <h3>Why Choose FurniHub?</h3>
                <p><strong>Effortless Shopping:</strong> Browse, customize, and order furniture with ease through our intuitive platform.</p>
                <p><strong>Real-Time Updates:</strong> Stay informed with order tracking and delivery notifications.</p>
            </div>
            <div class="section-item">
                <h3>Seamless Integration</h3>
                <p>Our platform integrates with payment gateways and delivery systems for a smooth experience.</p>
                <p><strong>Customer-Centric Design:</strong> Designed with you in mind, ensuring an easy and enjoyable shopping journey.</p>
            </div>
        </div>
    </div>

    <div class="section" id="our-team">
        <h2>Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <!-- --- UPDATED: Sonam Lhamo's image --- -->
                <img src="{{ asset('images/sonam.jpg') }}" alt="Sonam Lhamo">
                <h4>Sonam Lhamo</h4>
            </div>
            <div class="team-member">
                <!-- --- UPDATED: Anisha Chhetri's image --- -->
                <img src="{{ asset('images/anisha.jpg') }}" alt="Anisha Chhetri">
                <h4>Anisha Chhetri</h4>
            </div>
        </div>
        <p class="guide-text" style="text-align: center; max-width: 900px;">
            The FurnishHome platform was created in 2025 by Sonam Lhamo and Anisha Chhetri, students of Diploma in Computer System and Network at Jigme Namgyel Engineering College. With their skills in design and development, they wanted to make furniture shopping easier and more enjoyable. Their aim was to build a simple and user-friendly platform where people can explore, customize, and buy high-quality furniture. Through FurnishHome, they hoped to help customers transform their homes with style, comfort, and convenience.
        </p>
    </div>

    <div class="section" id="project-guide">
        <h2>Project Guide</h2>
        <div class="guide-content">
            <div class="guide-member">
                <!-- --- UPDATED: Miss. Tashi Yangchen's image --- -->
                <img src="{{ asset('images/guide.jpg') }}" alt="Miss. Tashi Yangchen">
                <h4>Miss. Tashi Yangchen</h4>
            </div>
        </div>
        <div class="guide-text">
            <h3>Guidance and Mentorship:</h3>
            <p>The FurnishHome project was developed under the expert guidance of Miss Tashi Yangchen, a renowned professor at Jigme Namgyel Engineering College. Her deep knowledge of furniture design, e-commerce systems, and user experience design played a key role throughout the project.</p>
            <p>Miss Tashi Yangchen provided valuable oversight, ensuring that the platform's features matched market needs and customer expectations. Her technical expertise helped the team overcome development challenges, kept the project on track, and contributed greatly to its success.</p>
            <p>The FurniHub team is sincerely grateful for her constant support, thoughtful mentorship, and the time she dedicated to guiding the project. Her guidance enriched the learning experience of the developers and made this project possible.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('main-navbar');
            const sections = document.querySelectorAll('.section, .hero-section');
            const navLinks = document.querySelectorAll('.navbar-links a');
            const heroContent = document.getElementById('hero-content'); // Get the hero content container

            // --- Dynamic Feature 4: Hero Text Animation Trigger ---
            // Trigger the hero text animation immediately on load
            heroContent.classList.add('animate');


            // --- Dynamic Feature 2: Scroll Reveal Setup (Intersection Observer) ---
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1 // Trigger when 10% of the section is visible
            };

            const sectionObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    } 
                });
            }, observerOptions);

            sections.forEach(section => {
                // Ensure only the content sections (not the hero) are animated by Intersection Observer
                if (section.id !== 'hero-section') {
                    sectionObserver.observe(section);
                } else {
                    // For the hero section, ensure the 'visible' class is added (it was used as a base class)
                    section.classList.add('visible');
                }
            });


            // --- Dynamic Feature 1 & Active Link Tracking (Scroll Event) ---
            window.addEventListener('scroll', () => {
                const scrollY = window.pageYOffset;

                // 1. Navbar Scrolled Effect
                if (scrollY > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }

                // 2. Active Link Highlighting (Kept from original logic)
                let current = '';
                sections.forEach(section => {
                    // Adjusted calculation: section.offsetTop is relative to the document
                    const sectionTop = section.offsetTop - navbar.offsetHeight - 50; // Add an offset for better link activation
                    const sectionHeight = section.clientHeight;
                    
                    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    // Check if the link's href matches the current section ID
                    if (link.getAttribute('href').substring(1) === current) {
                        link.classList.add('active');
                    }
                });
            });

            // Initial call to set active link and navbar state on page load
            window.dispatchEvent(new Event('scroll'));
        });
    </script>
</body>
</html>