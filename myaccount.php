<?php
// Start session
session_start();
//Check if the user is logged in
if ($_SESSION['role'] != 'user') {
    header('Location: login.html'); // Redirect to login page if not logged in
    exit();
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'testing';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $account_number = 1000;
// // Fetch account details
$account_number = $_SESSION['acc_num'];
$sql = "SELECT * FROM account WHERE account_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $account_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "Account not found!";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - IERT Bank</title>
    <style>
        /* General styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #d2c6df, #ccd8eb);
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Header styles */
        h2 {
            text-align: center;
            font-size: 28px;
            color: #444;
            margin-bottom: 20px;
        }

        /* Account details styles */
        .account-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }

        .account-details p {
            font-size: 18px;
            background: #f8f9fa;
            border-left: 5px solid #007bff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        /* Logout button */
        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }

        .logout a:hover {
            background-color: #0056b3;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .account-details {
                grid-template-columns: 1fr;
            }

            .logout a {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <div class="account-details">
            <p><span class="label">Account Number:</span> <?php echo htmlspecialchars($user['account_number']); ?></p>
            <p><span class="label">Father's Name:</span> <?php echo htmlspecialchars($user['father_name']); ?></p>
            <p><span class="label">Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><span class="label">Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
            <p><span class="label">Pancard:</span> <?php echo htmlspecialchars($user['pancard']); ?></p>
            <p><span class="label">Aadhar No:</span> <?php echo htmlspecialchars($user['aadhar']); ?></p>
            <p><span class="label">Address:</span> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><span class="label">Account Balance:</span> ₹<?php echo htmlspecialchars($user['money']); ?></p>
            <p><span class="label">Account Created On:</span> <?php echo htmlspecialchars($user['created_at']); ?></p>
        </div>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>