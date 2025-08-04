<?php
session_start();
$balance = $_SESSION['mybalance'];
if ($_SESSION['role'] != 'user') {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IERT Bank - User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
}

/* Navbar Styles */
.navbar {
    background-color: #0056b3;
    color: white;
    padding: 1rem 0;
}

.navbar .brand {
    font-size: 1.5rem;
    font-weight: bold;
    display: inline-block;
}

.navbar .nav-links {
    float: right;
    list-style: none;
    margin: 0;
}

.navbar .nav-links li {
    display: inline;
    margin: 0 15px;
}

.navbar .nav-links a {
    color: white;
    text-decoration: none;
    font-size: 1rem;
}

.navbar .nav-links a:hover {
    text-decoration: underline;
}

/* ATM Card Section */

.atm-card-section {
    text-align: center;
    margin: 2rem 0;
}

.atm-card {
    background: linear-gradient(135deg, #7f75e3, #ef33ad);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    width: 350px;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.atm-card .bank-logo {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.atm-card .card-details {
    text-align: left;
}

.atm-card .card-number {
    font-size: 1.2rem;
    letter-spacing: 3px;
    margin-bottom: 0.8rem;
}

.atm-card .card-holder,
.atm-card .expiry {
    font-size: 1.0rem;
    margin-bottom: 0.5rem;
}  

/* Dashboard Sections */
.dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
}

.dashboard-section {
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.dashboard-section h2 {
    margin-bottom: 0.5rem;
    color: #0056b3;
}

.dashboard-section p {
    margin-bottom: 1rem;
    font-size: 0.9rem;
    color: #666;
}

.dashboard-section button {
    background-color: #0056b3;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem;
}

.dashboard-section button:hover {
    background-color: #004494;
}

/* Footer Styles */
.footer {
    background-color: #0056b3;
    color: white;
    text-align: center;
    padding: 1rem 0;
}

.footer a {
    color: #47b2ff;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <h1 class="brand">IERT Bank</h1>
            <ul class="nav-links">
                <li><a href="#statement">Credentials Update</a></li>
                <li><a href="#balance">View Balance</a></li>
                <li><a href="passbook.php">View Passbook</a></li>
                <li><a href="#account">My Account</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- ATM Card Section -->
    <section class="atm-card-section">
        <div class="atm-card">
            <div class="bank-logo">IERT Bank</div>
            <div class="card-details">
                <p class="card-number">**** **** **** 7914</p>
                <p class="card-holder"><?php echo $_SESSION['username'];?> </p>
                <p class="expiry">Valid Thru: 12/25</p>
            </div>
        </div>
    </section>

    
    <!-- Dashboard Sections -->
    <div class="dashboard-container">
        <div class="dashboard-section" id="statement">
            <h2>Update</h2>
            <p>Update your credentilas.</p>
            <button onclick="location.href='user_request.php'">Go to the update</button>
        </div>

        <div class="dashboard-section" id="balance">
    <h2>View Balance</h2>
    <p>Check your current account balance.</p>
    <button onclick="showBalanceAlert(<?php echo $balance; ?>)">View Balance</button>
</div>

        <div class="dashboard-section" id="passbook">
            <h2>View Passbook</h2>
            <p>Access your digital passbook for transaction history.</p>
            <button onclick="location.href='passbook.php'">View Passbook</button>
        </div>

        <div class="dashboard-section" id="account">
            <h2>My Account</h2>
            <p>Update your personal information and account settings.</p>
            <button onclick="location.href='myaccount.php'">My Account</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2024 IERT Bank. All Rights Reserved.</p>
        <p><a href="#contact">Contact Us</a> | <a href="#privacy">Privacy Policy</a></p>
    </footer>
</body>
<script>
function showBalanceAlert(balance) {
    alert("Your current balance is: ₹" + balance);
}
</script>
</html>
