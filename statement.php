<?php
session_start();
$balance = $_SESSION['mybalance'];
if ($_SESSION['role'] != 'user') {
    header("Location: login.html");
    exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "testing";
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$account_number = $_SESSION['acc_num'];
$name = "Unknown";

// Fetch account holder's name
$name_query = "SELECT name FROM account WHERE account_number = ?";
$name_stmt = $conn->prepare($name_query);
$name_stmt->bind_param("s", $account_number);
$name_stmt->execute();
$name_result = $name_stmt->get_result();
if ($name_row = $name_result->fetch_assoc()) {
    $name = $name_row['name'];
}
$name_stmt->close();

// Fetch records from the passbook table
$sql = "SELECT transaction_date, amount, transaction_type, new_balance FROM daybook_table WHERE account_number = ? ORDER BY transaction_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $account_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Start HTML content
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Account Statement</title>";
    echo "<style>
            body {
                font-family: Arial, sans-serif;
                margin: 0 auto;
                padding: 20px;
                color: #333;
                background-color: #f9f9f9;
            }
            .container {
                max-width: 800px;
                margin: auto;
                background: #fff;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 8px;
            }
            h1 {
                text-align: center;
                color: #007bff;
            }
            p {
                font-size: 14px;
                margin: 5px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
                font-size: 14px;
            }
            th {
                background-color: #007bff;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            button {
                display: block;
                width: 200px;
                margin: 20px auto;
                padding: 10px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
            @media print {
                button {
                    display: none;
                }
                .container {
                    border: none;
                    margin: 0;
                    padding: 0;
                }
            }
          </style>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container'>";
    echo "<h1>Account Statement</h1>";
    echo "<p><strong>Account Number:</strong> $account_number</p>";
    echo "<p><strong>Account Holder's Name:</strong> $name</p>";
    echo "<table>";
    echo "<tr><th>Transaction Date</th><th>Transaction Amount</th><th>Transaction Type</th><th>Updated Balance</th></tr>";

    // Loop through and display records
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['transaction_date'] . "</td>";
        echo "<td>" . number_format($row['amount'], 2) . "</td>";
        echo "<td>" . ucfirst($row['transaction_type']) . "</td>";
        echo "<td>" . number_format($row['new_balance'], 2) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<button onclick='window.print()'>Print to PDF</button>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
} else {
    echo "No records found for account number $account_number.";
}

$stmt->close();
$conn->close();
?>