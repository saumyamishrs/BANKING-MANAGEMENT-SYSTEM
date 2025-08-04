<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit();
}

?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "testing"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$search_result = "";
$account_number = "";

// Handle search request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $account_number = $conn->real_escape_string($_POST['account_number']);
    $sql = "SELECT * FROM account WHERE account_number = '$account_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $search_result = $result->fetch_assoc();
    } else {
        $search_result = "No customer found with Account Number: $account_number";
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $account_number = $conn->real_escape_string($_POST['account_number']);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete dependent rows from master_table
        $delete_daybook_table_sql = "DELETE FROM daybook_table WHERE account_number = '$account_number'";
        $conn->query($delete_daybook_table_sql);

        // Delete the row from account table
        $delete_account_sql = "DELETE FROM account WHERE account_number = '$account_number'";
        $conn->query($delete_account_sql);

        // Commit the transaction
        $conn->commit();

        $search_result = "Customer details successfully deleted.";
    } catch (mysqli_sql_exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        $search_result = "Error deleting record: " . $e->getMessage();
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Delete Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #004080;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            margin: 10px 0 5px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            width: 100%;
        }
        button {
            margin-top: 15px;
            padding: 12px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #003366;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #e7f3fe;
        }
        .error {
            background-color: #fce4e4;
            color: #d93025;
        }
        .success {
            background-color: #e6f4ea;
            color: #2d6a4f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search and Delete Customer</h2>
        <form method="POST" action="search_delete.php">
            <label for="account_number">Enter Account Number:</label>
            <input type="text" id="account_number" name="account_number" placeholder="Enter account number" required>
            <button type="submit" name="search">Search</button>
            <!-- <button type="submit" name="delete">Delete</button> -->
            <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
        </form>

        <?php if ($search_result): ?>
            <div class="result <?= is_array($search_result) ? 'success' : 'error' ?>">
                <?php if (is_array($search_result)): ?>
                    <h3>Customer Details:</h3>
                    <p><strong>Account Number:</strong> <?= htmlspecialchars($search_result['account_number']) ?></p>
                    <p><strong>Name:</strong> <?= htmlspecialchars($search_result['name']) ?></p>
                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($search_result['dob']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($search_result['phone']) ?></p>
                    <p><strong>Balance:</strong> &#8377;<?= htmlspecialchars($search_result['money']) ?></p>

                <?php else: ?>
                    <?= htmlspecialchars($search_result) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

