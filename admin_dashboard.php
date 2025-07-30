<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IERT Banking Management System - Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f8fb;
            line-height: 1.6;
        }

        h2 {
            color: #00457c;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #00457c;
        }

        button {
            padding: 12px 25px;
            background-color: #00457c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #0066cc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        input {
            padding: 12px 15px;
            width: 100%;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        form {
            margin: 20px 0;
        }

        .delete-btn {
            background-color: #cc0000;
        }

        .delete-btn:hover {
            background-color: #ff3333;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #00457c;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .navbar ul li {
            display: inline;
        }

        .navbar ul li a {
            color: #fff;
            padding: 10px 15px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 5px;
        }

        .navbar ul li a:hover {
            background-color: #0066cc;
        }

        /* Sections */
        .section {
            padding: 40px;
            margin: 20px auto;
            max-width: 900px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section h2 {
            font-size: 26px;
        }

        .section p {
            font-size: 16px;
        }

        .transaction {
            background-color: #fff; /* Matches other sections */
           
        }
        /* Footer */
        footer {
            text-align: center;
            padding: 30px;
            background-color: #75b4e6;;
            color: #fff;
            font-size: 16px;
            margin-top: 20px;
            position: relative;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.2);
        }

        footer p {
            margin: 0;
            font-size: 18px;
        }

        footer a {
            color: #f4c60e;
            font-weight: bold;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="logo">IERT Banking Admin</div>
        <nav>
            <ul>
                <li><a href="#masterTable">Master Table</a></li> 
                <li><a href="#daybookTable">Daybook Table</a></li>
                <li><a href="#transaction">Transaction</a></li>
                <li><a href="#updateDetails">Update Details</a></li> 
                <li><a href="#closeAccount">Close Account</a></li>
                <li><a href="logout.php">Logout</a></li>

            </ul>
        </nav>
    </header>

    <main>

    <?php 
    echo '
    <div style="text-align: center; margin-top: 20px; font-family: Arial, sans-serif;">
        <div style="display: inline-flex; align-items: center; background: #f4f4f4; padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Admin Icon" style="width: 40px; height: 40px; margin-right: 15px;">
            <span style="font-size: 24px; color: #333;">Welcome, ' . $_SESSION['username'] . '! You are logged in as an Admin.</span>
        </div>
    </div>';
?>

         <!-- Master Table Section -->
          <section id="masterTable" class="section">
            <h2>Master Table</h2>
            <p>View all the details of all customer in the system.</p>
            <button onclick="location.href='fetch.php'">View Master Table</button>
        </section> 

        <!-- <section id="masterTable" class="section" style="text-align: center; margin: 20px; font-family: Arial, sans-serif;">
    <div style="display: inline-flex; align-items: center; justify-content: space-between; background: #f4f4f4; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 600px; margin: auto;">
        <div style="text-align: left;">
            <h2 style="margin: 0; color: #333;">Master Table</h2>
            <p style="margin: 10px 0; color: #555;">View all the details of all customers in the system.</p>
            <button onclick="location.href='fetch.php'" style="padding: 10px 20px; background: #007BFF; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                View Master Table
            </button>
        </div>
        <div style="margin-left: 20px;">
            <img src="https://cdn-icons-png.flaticon.com/512/753/753317.png" alt="Table Icon" style="width: 60px; height: 60px;">
        </div>
    </div>
</section>  -->

        <!-- Daybook Table Section -->
        <section id="daybookTable" class="section">
            <h2>Daybook Table</h2>
            <p>View and manage all transactions in the system.</p>
            <button onclick="location.href='view_transaction.php'">View Daybook Table</button>
        </section>
         <!-- Transaction Section -->
         <section id="transaction" class="section">
            <h2>Transaction Form</h2>
            <p>Manage all transactions in the account.</p>
            <button onclick="location.href='process_form_transaction.php'">View Transaction Form</button>
        </section>

        <!-- Update Details Section -->
         <section id="updateDetails" class="section">
            <h2>Update Details</h2>
            <p>Enter the account number to update for account details.</p>
             <form action="update.php" method="post"> 
                <button type="submit">Update</button>
            </form>
        </section> 

        <!-- Close Account Section -->
        <section id="closeAccount" class="section">
            <h2>Close Account</h2>
            <p>Enter the account number to close the account from the system.</p>
            <form action="search_delete.php" method="post">
                <button type="submit" class="delete-btn">Close</button>
            </form>
        </section>
        <!-- Approving and diaaproving request -->
        <section id="request" class="section">
            <h2>Approve or disapprove request</h2>
            <p>Approve or disapprove the user money  and credentials update request.</p>
            <form action="admin_request.php" method="post">
                <button type="submit">Approve or Disapprove</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 IERT Banking Management System. All Rights Reserved.</p>
        <p>Visit our <a href="index.html">Homepage</a> for more features!</p>
    </footer>
</body>
</html>