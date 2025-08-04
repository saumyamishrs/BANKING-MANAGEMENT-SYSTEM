<?php
session_start();
$balance = $_SESSION['mybalance'];
if ($_SESSION['role'] != 'user') {
    header("Location: login.html");
    exit();
}
?>
<?php 
$conn = new mysqli('localhost', 'root', '', 'testing');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$account_number = $_SESSION['acc_num'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO user_requests (account_number, request_type, new_username, new_password, status) 
              VALUES ('$account_number', 'credentials', '$new_username', '$new_password', 'pending')";
    if ($conn->query($query) === TRUE) {
        echo "<div class='success-message'>Request submitted successfully. Wait for admin approval.</div>";
    } else {
        echo "<div class='error-message'>Error: " . $conn->error . "</div>";
    }
}

$status_query = "SELECT status,request_type FROM user_requests 
                 WHERE account_number = '$account_number' 
                 ORDER BY id DESC LIMIT 1";
$status_result = $conn->query($status_query);

$status = '';
if ($status_result->num_rows > 0) {
    $row = $status_result->fetch_assoc();
    $status = $row['status'];
    $request_type = $row['request_type'];
} else {
    $status = 'No requests submitted yet.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        form {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
        }
        form input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        form button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #45a049;
        }
        .status-box {
            width: 60%;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .status-box p {
            font-size: 16px;
            color: #333;
            text-align: center;
        }
        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Request Username/Password Update</h2>
    <form action="user_request.php" method="POST">
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" placeholder="Enter new username" required>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit">Submit Request</button>
    </form>

    <div class="status-box">
        <h3>Your Latest Request Status:</h3>
        <p><?php echo htmlspecialchars($request_type); ?></p>
        <p><?php echo htmlspecialchars($status); ?></p>
        
    </div>
</body>
</html>
