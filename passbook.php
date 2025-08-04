<?php
session_start();
$balance = $_SESSION['mybalance'];
if ($_SESSION['role'] != 'user') {
    header("Location: login.html");
    exit();
}
?>
<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the account number from the user input (e.g., from an HTML form)
$account_number = $_SESSION['acc_num']; // Assuming the account number is stored in the session

// Prepare the SQL query with parameterized query to prevent SQL injection
// $sql = "SELECT m.id, m.account_number, m.transaction_type, m.amount, m.transaction_date, m.new_balance
//         FROM daybook_table m
//         WHERE m.account_number = ?
//         ORDER BY m.transaction_date DESC";

$sql = "SELECT transaction_date, amount, transaction_type, new_balance FROM daybook_table WHERE account_number = ? ORDER BY transaction_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $account_number);
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passbook</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .print-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #45a049;
        }

        table {
            border-collapse: collapse;
            margin: 50px auto;
            font-size: 16px;
            min-width: 80%;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr {
            transition: background-color 0.3s;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f9f5;
        }

        caption {
            caption-side: top;
            font-size: 1.5em;
            margin: 10px 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #4CAF50;
        }

        p {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>
    <a href="statement.php" class="print-button">Print Statement</a>
    <h1>Passbook</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
            <caption>Transaction Entries</caption>
            <tr>
                <th>Transaction Date</th>
                <th>Transaction Type</th>
                <th>Transaction Amount</th>
                <th>Current Balance</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["transaction_date"] . "</td>
                <td>" . $row["transaction_type"] . "</td>
                <td>" . $row["amount"] . "</td>
                <td>" . $row["new_balance"] . "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No transactions found for the specified account number.</p>";
    }
    ?>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>