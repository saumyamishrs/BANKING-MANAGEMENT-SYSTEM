<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'testing');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pending Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons a {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            margin: 5px;
            color: #fff;
            transition: background-color 0.3s ease;
        }
        .action-buttons a.approve {
            background-color: #28a745;
        }
        .action-buttons a.approve:hover {
            background-color: #218838;
        }
        .action-buttons a.reject {
            background-color: #dc3545;
        }
        .action-buttons a.reject:hover {
            background-color: #c82333;
        }
        .no-requests {
            text-align: center;
            color: #888;
            font-size: 18px;
            margin-top: 30px;
        }
        .message {
            text-align: center;
            margin: 20px auto;
            font-size: 16px;
            color: #555;
        }
        .refresh-button {
            display: block;
            width: 120px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .refresh-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Admin Panel - Pending Requests</h2>

    <?php
    $result = $conn->query("SELECT * FROM user_requests WHERE status = 'pending'");
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Account Number</th>
                    <th>Request Type</th>
                    <th>New Username</th>
                    <th>Action</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['account_number']}</td>
                    <td>{$row['request_type']}</td>
                    <td>{$row['new_username']}</td>
                    <td class='action-buttons'>
                        <a href='?approve={$row['id']}' class='approve'>Approve</a>
                        <a href='?reject={$row['id']}' class='reject'>Reject</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='no-requests'>No pending requests.</div>";
    }

    if (isset($_GET['approve'])) {
        $id = $_GET['approve'];
        $request = $conn->query("SELECT * FROM user_requests WHERE id = '$id'")->fetch_assoc();

        if ($request) {
            $account_number = $request['account_number'];
            $request_type = $request['request_type'];

            if ($request_type === 'credentials') {
                $new_username = $request['new_username'];
                $new_password = $request['new_password']; // Password should already be hashed
                $conn->query("UPDATE account SET username = '$new_username', password = '$new_password' WHERE account_number = '$account_number'");
            }

            // if ($request_type === 'amount') {
            //     $account_details = $conn->query("SELECT money FROM account WHERE account_number = '$account_number'")->fetch_assoc();
            //     $requested_amount = $request['requested_amount'];
            //     $new_balance = $requested_amount;
            //     $conn->query("UPDATE account SET money = '$new_balance' WHERE account_number = '$account_number'");
            //     $conn->query("INSERT INTO daybook_table (account_number, transaction_type, amount, prev_balance, new_balance) 
            //                   VALUES ('$account_number', 'credit', '$requested_amount', '0', '$new_balance')");
            // }
            if ($request_type === 'amount') {
                $account_details = $conn->query("SELECT money FROM account WHERE account_number = '$account_number'")->fetch_assoc();
                $requested_amount = $request['requested_amount'];
                $new_balance = $requested_amount;
            
                // Update the account balance
                $conn->query("UPDATE account SET money = '$new_balance' WHERE account_number = '$account_number'");
            
                // Check if a similar transaction already exists
                $check_query = "SELECT * FROM daybook_table 
                                WHERE account_number = '$account_number' 
                                AND transaction_type = 'credit' 
                                AND amount = '$requested_amount' 
                                AND prev_balance = '0' 
                                AND new_balance = '$new_balance'";
                $existing_transaction = $conn->query($check_query);
            
                if ($existing_transaction->num_rows === 0) {
                    // Insert the record only if it doesn't exist
                    $conn->query("INSERT INTO daybook_table (account_number, transaction_type, amount, prev_balance, new_balance) 
                                  VALUES ('$account_number', 'credit', '$requested_amount', '0', '$new_balance')");
                } else {
                    echo "<div class='message'>Transaction already exists in the daybook table.</div>";
                }
            }
            

            $conn->query("UPDATE user_requests SET status = 'approved' WHERE id = '$id'");
            echo "<div class='message'>Request approved successfully.</div>";
        }
    }

    if (isset($_GET['reject'])) {
        $id = $_GET['reject'];
        $conn->query("UPDATE user_requests SET status = 'rejected' WHERE id = '$id'");
        echo "<div class='message'>Request rejected successfully.</div>";
    }

    $conn->close();
    ?>

    <a href="" class="refresh-button">Refresh</a>
</body>
</html>