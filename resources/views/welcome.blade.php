<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SunPharma | Excellence in Healthcare</title>
    <link rel="icon" href="{{ asset('uploads/logo.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* 
         * SunPharma Modern Design System
         * Primary: #8e24aa (Purple)
         * Secondary: #e91e63 (Pink)
         * Accent: #f3e5f5 (Light Purple)
         * Text: #2d3748
         */
        
        :root {
            --primary: #8e24aa;
            --primary-dark: #6c1a84;
            --secondary: #e91e63;
            --secondary-dark: #c2185b;
            --text-dark: #1a202c;
            --text-gray: #4a5568;
            --bg-light: #f8faff;
            --white: #ffffff;
            --gradient-main: linear-gradient(135deg, #8e24aa 0%, #e91e63 100%);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif; /* Elegant serif for headings */
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: var(--gradient-main);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(142, 36, 170, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            padding: 15px 0;
            transition: padding 0.3s ease;
        }

        .navbar.scrolled {
            padding: 10px 0;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 24px;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 26px;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }

        .logo img {
            height: 45px;
            margin-right: 12px;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-links a {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-gray);
            position: relative;
        }

        .nav-links a:not(.login-trigger):hover {
            color: var(--primary);
        }

        .nav-links a:not(.login-trigger)::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--secondary);
            transition: width 0.3s;
        }

        .nav-links a:not(.login-trigger):hover::after {
            width: 100%;
        }

        /* Dropdown */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            min-width: 200px;
            box-shadow: var(--shadow-lg);
            border-radius: 12px;
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 24px;
            color: var(--text-dark);
            font-weight: 500;
        }

        .dropdown-menu a:hover {
            background: #fdf2f8;
            color: var(--secondary);
        }
        
        .dropdown-menu a::after { display: none; } /* Remove underline for dropdown items */

        .menu-toggle {
            display: none;
            font-size: 24px;
            color: var(--text-dark);
            cursor: pointer;
        }

        .mobile-menu { display: none; }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') center/cover no-repeat fixed;
            margin-top: 0; /* Nav fixed handles this, but usually good to clear */
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.7) 100%);
        }

        .hero-container {
            position: relative;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            z-index: 2;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .hero-content {
            max-width: 650px;
            padding: 40px 0;
        }

        .badge-pill {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(142, 36, 170, 0.1);
            color: var(--primary);
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 24px;
            color: var(--text-dark);
        }
        
        .hero h1 span {
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-gray);
            margin-bottom: 40px;
            max-width: 550px;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            border-top: 1px solid #e2e8f0;
            padding-top: 30px;
        }

        .stat-item h3 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-item p {
            font-size: 0.9rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sections General */
        section {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .section-header .subtitle {
            color: var(--secondary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            display: block;
            margin-bottom: 15px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 60px;
            align-items: center;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }

        .about-shape {
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 200px;
            height: 200px;
            background: rgba(233, 30, 99, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        .feature-list {
            list-style: none;
            margin-top: 30px;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .feature-list i {
            color: var(--primary);
            margin-right: 15px;
            font-size: 1.2rem;
            margin-top: 3px;
        }

        /* Services Cards */
        .services-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s;
            border: 1px solid #f0f0f0;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-color: rgba(142, 36, 170, 0.1);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient-main);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: #fdf2f8;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 28px;
            margin-bottom: 25px;
            transition: all 0.3s;
        }

        .service-card:hover .icon-wrapper {
            background: var(--gradient-main);
            color: white;
            box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Counter/Stats */
        .stats-section {
            background: var(--gradient-main);
            color: white;
            background-attachment: fixed;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stats-item h2 {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 10px;
        }

        .stats-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Contact Section */
        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 50px;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .contact-info-box {
            background: var(--gradient-main);
            padding: 50px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .contact-details .item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .contact-details i {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-form-box {
            padding: 50px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 15px 0;
            border: none;
            border-bottom: 2px solid #e2e8f0;
            background: transparent;
            outline: none;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group label {
            position: absolute;
            top: 15px;
            left: 0;
            color: #a0aec0;
            pointer-events: none;
            transition: all 0.3s;
        }

        .form-group input:focus, .form-group textarea:focus,
        .form-group input:valid, .form-group textarea:valid {
            border-bottom-color: var(--primary);
        }

        .form-group input:focus ~ label, .form-group textarea:focus ~ label,
        .form-group input:valid ~ label, .form-group textarea:valid ~ label {
            top: -10px;
            font-size: 0.85rem;
            color: var(--primary);
        }

        /* Accordion */
        .accordion-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 15px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .accordion-header {
            padding: 20px 25px;
            background: transparent;
            width: 100%;
            text-align: left;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            color: var(--text-dark);
            transition: background 0.3s;
        }

        .accordion-header:hover {
            background-color: #f8faff;
        }

        .accordion-header.active {
            color: var(--primary);
            background-color: #fdf2f8;
        }

        .accordion-header i {
            transition: transform 0.3s;
        }

        .accordion-header.active i {
            transform: rotate(180deg);
        }

        .accordion-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background: white;
        }

        .accordion-body p {
            padding: 0 25px 25px;
            color: var(--text-gray);
        }

        /* Footer */
        .footer {
            background: #1a202c;
            color: #cbd5e0;
            padding: 80px 0 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-logo {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            display: block;
            font-family: 'Playfair Display', serif;
        }

        .footer h4 {
            color: white;
            margin-bottom: 25px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        .footer ul {
            list-style: none;
        }

        .footer ul li {
            margin-bottom: 12px;
        }

        .footer ul li a {
            color: #a0aec0;
            transition: color 0.3s;
        }

        .footer ul li a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: background 0.3s;
        }

        .social-link:hover {
            background: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .hero h1 { font-size: 2.8rem; }
            .about-grid { grid-template-columns: 1fr; gap: 40px; }
            .about-image { order: -1; }
            .contact-container { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            html, body {
                scroll-snap-type: none; /* Disable scroll snap on mobile to prevent clipping */
                height: auto;
                overflow-y: auto;
            }
            
            .nav-links { display: none !important; }
            .menu-toggle { display: block; }
            
            section { padding: 40px 0; }

            .hero { 
                background-attachment: scroll; 
                height: auto;
                min-height: 100vh;
                padding-top: 100px; /* More space for navbar */
                padding-bottom: 40px;
                display: block; /* Remove flex centering context to allow natural flow if needed */
            }
            
            .hero-container {
                display: block; /* Stack content naturally */
            }
            
            .hero-content {
                padding: 0;
                text-align: center;
                margin: 0 auto;
            }

            .hero h1 { 
                font-size: 2.5rem; 
                line-height: 1.2;
            }
            
            .hero-buttons {
                display: flex;
                flex-direction: column;
                gap: 15px;
                margin-bottom: 40px;
            }
            
            .hero-buttons .btn {
                margin-left: 0 !important;
                width: 100%;
            }

            .stats-section { background-attachment: scroll; }
            
            .hero-stats { 
                flex-direction: row; 
                flex-wrap: wrap; 
                justify-content: center; 
                gap: 20px; 
                border-top: 1px solid #e2e8f0;
                padding-top: 30px;
                margin-top: 30px;
            }
            
            .stat-item {
                flex: 1 1 40%; /* 2 items per row approx */
                min-width: 120px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .mobile-menu {
                position: fixed;
                top: 75px;
                left: 0;
                width: 100%;
                background: white;
                padding: 15px 20px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.05);
                display: flex;
                flex-direction: column;
                gap: 5px;
                transform: translateY(-20px);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: all 0.3s ease-in-out;
                border-top: 1px solid #f0f0f0;
                z-index: 999;
            }

            .mobile-menu.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            .mobile-menu a:not(.mobile-btn) {
                padding: 10px;
                border-bottom: 1px solid #f9f9f9;
                text-align: center;
                color: var(--text-dark);
                font-weight: 500;
            }

            .mobile-login-buttons {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-top: 5px;
                padding-top: 5px;
                border-top: 0;
            }

            .mobile-btn {
                display: block;
                padding: 10px;
                text-align: center;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                font-size: 14px;
            }

            .mobile-btn.primary {
                background: var(--primary);
                color: white;
            }

            .mobile-btn.outline {
                border: 1px solid var(--primary);
                color: var(--primary);
            }
            
            /* Section Responsiveness Fixes */
            .services-wrapper, .footer-grid {
                grid-template-columns: 1fr;
            }
            /* Stats grid remains 2 columns from previous rule */
            
            .contact-container {
                display: flex;
                flex-direction: column;
            }

            .contact-info-box, .contact-form-box { padding: 25px; }
        }

        @media (max-width: 480px) {
            .hero h1 { font-size: 2rem; }
            .badge-pill { font-size: 12px; }
            .logo { font-size: 20px; }
            .logo img { height: 35px; }
        }

        /* Modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
        }
        
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 40px;
            border-radius: 15px;
            width: 90%;
            max-width: 700px;
            position: relative;
            box-shadow: var(--shadow-lg);
            animation: modalSlide 0.4s ease;
        }

        @keyframes modalSlide {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 25px;
            transition: color 0.3s;
        }
        
        .close-modal:hover { color: var(--primary); }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <img src="{{ asset('uploads/logo.png') }}" alt="SunPharma Logo" onerror="this.onerror=null; this.src='https://via.placeholder.com/50';">
                <span>SunPharma</span>
            </a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#stats">Impact</a>
                <a href="#contact">Contact</a>
                <div class="dropdown">
                    <a href="#" class="btn btn-primary login-trigger" style="color: white !important;">
                        Portal Login <i class="fas fa-chevron-down ml-2"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ url('/rclogin') }}"><i class="fas fa-user-nurse mr-2"></i> RC Login</a>
                        <a href="{{ url('/login') }}"><i class="fas fa-users mr-2"></i> General Login</a>
                    </div>
                </div>
            </div>
            <div class="menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#home" onclick="toggleMenu()">Home</a>
        <a href="#about" onclick="toggleMenu()">About</a>
        <a href="#services" onclick="toggleMenu()">Services</a>
        <a href="#contact" onclick="toggleMenu()">Contact</a>
        <div class="mobile-login-buttons">
            <a href="{{ url('/rclogin') }}" class="mobile-btn primary">RC Login</a>
            <a href="{{ url('/login') }}" class="mobile-btn outline">General Login</a>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <span class="badge-pill">#1 Healthcare Management System</span>
                <h1>Empowering Healthcare with <span>Innovation</span></h1>
                <p>Streamline patient care, manage medical records, and connect with top-tier specialists on one unified platform. Experience the future of medical management.</p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary">Explore Services</a>
                    <a href="#contact" class="btn btn-outline" style="margin-left: 15px;">Contact Support</a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <h3>10k+</h3>
                        <p>Patients Served</p>
                    </div>
                    <div class="stat-item">
                        <h3>500+</h3>
                        <p>Specialists</p>
                    </div>
                    <div class="stat-item">
                        <h3>24/7</h3>
                        <p>Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-info">
                    <div class="section-header" style="text-align: left; margin-bottom: 30px;">
                        <span class="subtitle">Who We Are</span>
                        <h2>Dedicated to Your Health & Well-being</h2>
                    </div>
                    <p style="color: var(--text-gray); margin-bottom: 20px;">
                        SunPharma is a pioneering healthcare platform designed to bridge the gap between patients and quality medical care. We leverage cutting-edge technology to simplify hospital management and enhance the patient experience.
                    </p>
                    <p style="color: var(--text-gray);">
                        Our mission is to create a seamless ecosystem where medical records, appointments, and consultations are effortlessly managed, allowing doctors to focus on what matters most—saving lives.
                    </p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check-circle"></i> Comprehensive Patient Management</li>
                        <li><i class="fas fa-check-circle"></i> Secure Digital Health Records</li>
                        <li><i class="fas fa-check-circle"></i> Real-time Analytics & Reporting</li>
                    </ul>
                    <a href="#contact" class="btn btn-outline" style="margin-top: 30px;">Learn More</a>
                </div>
                <div class="about-image">
                    <div class="about-shape"></div>
                    <img src="https://images.unsplash.com/photo-1516549655169-df83a0674f66?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Medical Team">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" style="background-color: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <span class="subtitle">What We Do</span>
                <h2>Our Premium Services</h2>
                <p style="color: var(--text-gray);">We offer a wide range of medical management solutions tailored to hospitals, clinics, and individual practitioners.</p>
            </div>

            <div class="services-wrapper">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h3>Expert Consultation</h3>
                    <p style="color: var(--text-gray);">Connect with leading medical professionals for online and offline consultations. Get second opinions from the best in the field.</p>
                </div>

                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-file-medical-alt"></i>
                    </div>
                    <h3>Electronic Records</h3>
                    <p style="color: var(--text-gray);">Securely store and access patient history, prescriptions, and lab reports from anywhere. HIPAA compliant security.</p>
                </div>

                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-pills"></i>
                    </div>
                    <h3>Pharmacy Management</h3>
                    <p style="color: var(--text-gray);">Integrated inventory tracking for pharmacies, automated restocking alerts, and seamless billing systems.</p>
                </div>

                <div class="service-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Smart Scheduling</h3>
                    <p style="color: var(--text-gray);">AI-powered appointment scheduling that reduces wait times and optimizes doctor availability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stats-item">
                    <h2>50+</h2>
                    <p>Partner Hospitals</p>
                </div>
                <div class="stats-item">
                    <h2>120k</h2>
                    <p>Monthly Visitors</p>
                </div>
                <div class="stats-item">
                    <h2>98%</h2>
                    <p>Patient Satisfaction</p>
                </div>
                <div class="stats-item">
                    <h2>15+</h2>
                    <p>Years Experience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="section-header">
                <span class="subtitle">Get In Touch</span>
                <h2>We're Here to Help</h2>
            </div>
            
            <div class="contact-container">
                <div class="contact-info-box">
                    <div>
                        <h3 style="color: white; font-size: 1.8rem; margin-bottom: 20px;">Contact Information</h3>
                        <p style="opacity: 0.8; margin-bottom: 40px;">Have questions? Reach out to our 24/7 support team for assistance.</p>
                        
                        <div class="contact-details">
                            <div class="item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Sun House, CTS No. 201 B/1, Western Express Highway, Goregaon (E), Mumbai 400063</span>
                            </div>
                            <div class="item">
                                <i class="fas fa-envelope"></i>
                                <span>support@sunpharma.com</span>
                            </div>
                            <div class="item">
                                <i class="fas fa-phone-alt"></i>
                                <span>+91 22 4324 4324</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links" style="margin-top: 30px;">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="contact-form-box">
                    <form>
                        <div class="form-group">
                            <input type="text" id="name" required>
                            <label for="name">Your Name</label>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" required>
                            <label for="email">Your Email</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" required>
                            <label for="subject">Subject</label>
                        </div>
                        <div class="form-group">
                            <textarea id="message" rows="4" required></textarea>
                            <label for="message">Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" style="background-color: var(--bg-light);">
        <div class="container" style="max-width: 800px;">
            <div class="section-header">
                <span class="subtitle">FAQ</span>
                <h2>Frequently Asked Questions</h2>
            </div>
            
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header">
                        How can I register as a patient?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-body">
                        <p>Registration is currently invite-only or managed by our partner hospitals. Please contact your local clinic administrator for access details.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header">
                        Is my medical data secure?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-body">
                        <p>Absolutely. We use enterprise-grade encryption and comply with all major healthcare data protection regulations including HIPAA and GDPR.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header">
                        Can I book appointments online?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-body">
                        <p>Yes, once logged in, you can view doctor availability and book appointments instantly through your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="#" class="footer-logo">SunPharma</a>
                    <p style="margin-bottom: 20px; font-size: 0.9rem;">
                        Transforming healthcare via innovation. Committed to extending and enhancing human life.
                    </p>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#" onclick="openModal('privacy'); return false;">Privacy Policy</a></li>
                        <li><a href="#" onclick="openModal('terms'); return false;">Terms of Service</a></li>
                        <li><a href="#" onclick="openModal('refund'); return false;">Refund Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Subscribe</h4>
                    <form style="display: flex; gap: 10px;">
                        <input type="email" placeholder="Email Address" style="padding: 10px; border-radius: 5px; border: none; width: 100%;">
                        <button type="button" class="btn btn-primary" style="padding: 10px 20px;"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} SunPharma. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <div id="modal-privacy" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('privacy')">&times;</span>
            <h2>Privacy Policy</h2>
            <div style="margin-top: 20px; color: var(--text-gray);">
                <p>At SunPharma, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your information.</p>
                <br>
                <h4>1. Information Collection</h4>
                <p>We collect information necessary to provide our healthcare services, including personal details and medical history.</p>
                <br>
                <h4>2. Data Usage</h4>
                <p>Your data is used solely for improving your healthcare experience and is never sold to third parties.</p>
            </div>
        </div>
    </div>

    <div id="modal-terms" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('terms')">&times;</span>
            <h2>Terms & Conditions</h2>
            <div style="margin-top: 20px; color: var(--text-gray);">
                <p>By using our services, you agree to the following terms.</p>
                <br>
                <h4>1. Usage</h4>
                <p>You agree to use this platform responsibly and for lawful healthcare-related purposes only.</p>
            </div>
        </div>
    </div>

    <div id="modal-refund" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('refund')">&times;</span>
            <h2>Refund Policy</h2>
            <div style="margin-top: 20px; color: var(--text-gray);">
                <p>Refunds are processed on a case-by-case basis for cancelled appointments within 24 hours.</p>
            </div>
        </div>
    </div>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                navbar.style.boxShadow = 'var(--shadow-md)';
            } else {
                navbar.classList.remove('scrolled');
                navbar.style.boxShadow = 'var(--shadow-sm)';
            }
        });

        // Mobile Menu Toggle
        function toggleMenu() {
            var menu = document.getElementById('mobileMenu');
            var icon = document.querySelector('.menu-toggle i');
            
            menu.classList.toggle('active');
            
            if (menu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }

        // Accordion
        var acc = document.getElementsByClassName("accordion-header");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }

        // Modals
        function openModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</body>
</html>
