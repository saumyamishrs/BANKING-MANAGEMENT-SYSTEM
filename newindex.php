<?php
session_start();
if ($_SESSION['role'] != 'nonuser') {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to IERT Bank</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #003366; /* Deep navy blue */
            color: white;
        }

        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
        }

        .navbar .nav-links a {
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar .nav-links a:hover {
            background-color: #FFD700; /* Gold hover effect */
            color: #003366;
        }

        /* Hero Section */
        .hero {
            background: url('photo2.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 100px 20px;
            position: relative;
            overflow: hidden;
            filter: brightness(1.2); /* Increase brightness by 20% */
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
            z-index: 1;
        }

        .hero h1, .hero p, .hero .btn {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .hero .btn {
            background-color: #FFD700; /* Gold button */
            color: #003366;
            font-size: 1.2em;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        .hero .btn:hover {
            background-color: #FFC107; /* Slightly darker gold */
            transform: scale(1.05);
        }

        /* Features Section */
        .features {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 40px 20px;
            background-color: #ffffff;
        }

        .feature-card {
            background-color: #E6F7FF; /* Light blue */
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            max-width: 300px;
            transition: transform 0.3s;
        }

        .feature-card:nth-child(2) {
            background-color: #FFF9E6; /* Light yellow */
        }

        .feature-card:nth-child(3) {
            background-color: #E6FFE6; /* Light green */
        }

        .feature-card:hover {
            transform: scale(1.05);
        }

        .feature-card h3 {
            color: #003366;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 0.9em;
            color: #555;
        }

        /* Footer */
        .footer {
            background-color: #003366; /* Deep navy blue */
            color: white;
            text-align: center;
            padding: 40px;
            font-size: 1em;
            border-top: 5px solid #002244; /* Slightly darker accent */
        }

        .footer a {
            color: #FFD700; /* Gold links */
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">IERT Bank</div>
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="aboutus.html">About Us</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
            <a href="logout.php">Log Out</a>
            <a href="signuppage.html">Sign Up</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to IERT Bank</h1>
        <h1>Welcome <?php echo "<font color=red>".$_SESSION['username']."</font>"; ?> to IERT Bank</h1>
        <p>Your trusted financial partner. Safe, secure, and reliable banking solutions.</p>
        <button class="btn" onclick="window.location.href='signuppage.html'">Open a Savings Account</button>
    </div>

    <!-- Features Section -->
    <div class="features">
        <div class="feature-card">
            <h3>Personal Banking</h3>
            <p>Customized banking solutions for your personal needs.</p>
        </div>
        <div class="feature-card">
            <h3>Business Banking</h3>
            <p>Empower your business with tailored financial services.</p>
        </div>
        <div class="feature-card">
            <h3>Loans & Mortgages</h3>
            <p>Flexible and competitive loan options to support your goals.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2024 IERT Bank. All Rights Reserved. | <a href="#privacy-policy">Privacy Policy</a>
    </div>
</body>
</html>





