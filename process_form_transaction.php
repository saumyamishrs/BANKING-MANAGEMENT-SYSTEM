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
    <title>Bank Transactions</title>
    <style>
        /* Styling */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 180vh;
            padding: 20px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
        }
        h1 { text-align: center; margin-bottom: 20px; font-size: 1.8em; color: #333; font-weight: bold; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: bold; color: #555; margin-bottom: 5px; }
        input, select, button {
            padding: 12px; font-size: 1em; border: 1px solid #ccc; border-radius: 5px; width: 100%; transition: all 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #4a90e2; box-shadow: 0 0 5px rgba(74, 144, 226, 0.5); outline: none;
        }
        button {
            background-color: #4a90e2; color: white; font-weight: bold; cursor: pointer; border: none;
        }
        button:hover { background-color: #357abd; }
        button:active { transform: scale(0.98); }
        .message { padding: 10px; text-align: center; margin-bottom: 15px; border-radius: 5px; font-size: 0.9em; }
        .error { color: #e74c3c; background-color: #f8d7da; border: 1px solid #f5c2c7; }
        .success { color: #27ae60; background-color: #d4edda; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Transaction Form</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "testing";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $error_message = $success_message = "";
    $name = $father_name = $aadhar = $pancard = $money = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $account_number = trim($_POST['account_number']);

        if (isset($_POST['fetch_details'])) {
            if (!empty($account_number)) {
                $sql = "SELECT name, father_name, aadhar, pancard, money FROM account WHERE account_number = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $account_number);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $name = $row['name'];
                    $father_name = $row['father_name'];
                    $aadhar = $row['aadhar'];
                    $pancard = $row['pancard'];
                    $money = $row['money'];
                } else {
                    $error_message = "Account number does not exist. Please enter the valid amount number.";
                    

                }
            } else {
                $error_message = "Account number is required.";
            }
        }

        if (isset($_POST['submit_transaction'])) {
            $name = $_POST['hidden_name'];
            $father_name = $_POST['hidden_father_name'];
            $aadhar = $_POST['hidden_aadhar'];
            $pancard = $_POST['hidden_pancard'];
            $money = $_POST['hidden_money'];
            $transaction_type = $_POST['transaction_type'];
            $amount = $_POST['amount'];

            if (!empty($account_number) && !empty($name)) {
                $sql = "SELECT money FROM account WHERE account_number = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $account_number);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $current_balance = $row['money'];

                    // Check if the transaction type is valid
                    if (!in_array(strtoupper($transaction_type), ['CREDIT', 'DEBIT'])) {
                    die("Invalid transaction type. Please select 'Credit' or 'Debit'.");
                        }

                    if (is_numeric($amount) && $amount > 0) {
                        if ($transaction_type === "credit") {
                            $new_balance = $current_balance + $amount;
                        } elseif ($transaction_type === "debit") {
                            if ($current_balance >= $amount) {
                                $new_balance = $current_balance - $amount;
                            } else {
                                $error_message = "Insufficient balance for debit transaction.";
                            }
                        }

                        if (empty($error_message)) {
                            $update_sql = "UPDATE account SET money = ? WHERE account_number = ?";
                            $update_stmt = $conn->prepare($update_sql);
                            $update_stmt->bind_param("ds", $new_balance, $account_number);
                            $update_stmt->execute();

                            $daybook_sql = "INSERT INTO daybook_table (account_number, transaction_type, amount,prev_balance,new_balance) VALUES (?, ?, ?,?,?)";
                            $daybook_stmt = $conn->prepare($daybook_sql);
                            $daybook_stmt->bind_param("ssiii", $account_number, $transaction_type, $amount,$current_balance,$new_balance);
                            $daybook_stmt->execute();

                            $success_message = "Transaction successful. Previous balance: $current_balance Updated balance: $new_balance.";
                            $money = $new_balance;
            
                    
                        }
                    } else {
                        $error_message = "Invalid amount entered.";
                    }
                } else {
                    $error_message = "Account number does not exist.";
                }
            } else {
                $error_message = "Accout doesnt exist .";
            }
        }
    }

    $conn->close();
    ?>

    <?php if ($error_message): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    

    <form method="post">
        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number" placeholder="Enter account number"
               value="<?php echo htmlspecialchars($account_number ?? ''); ?>"
               <?php echo isset($name) && !empty($name) ? 'readonly' : ''; ?> required>
        <button type="submit" name="fetch_details">Fetch Details</button>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
        <input type="hidden" name="hidden_name" value="<?php echo htmlspecialchars($name); ?>">

        <label for="father_name">Father's Name:</label>
        <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($father_name); ?>" readonly>
        <input type="hidden" name="hidden_father_name" value="<?php echo htmlspecialchars($father_name); ?>">

        <label for="aadhar">Aadhar:</label>
        <input type="text" id="aadhar" name="aadhar" value="<?php echo htmlspecialchars($aadhar); ?>" readonly>
        <input type="hidden" name="hidden_aadhar" value="<?php echo htmlspecialchars($aadhar); ?>">

        <label for="pancard">PAN Card:</label>
        <input type="text" id="pancard" name="pancard" value="<?php echo htmlspecialchars($pancard); ?>" readonly>
        <input type="hidden" name="hidden_pancard" value="<?php echo htmlspecialchars($pancard); ?>">

        <label for="money">Balance:</label>
        <input type="text" id="money" name="money" value="<?php echo htmlspecialchars($money); ?>" readonly>
        <input type="hidden" name="hidden_money" value="<?php echo htmlspecialchars($money); ?>">

        <label for="transaction_type">Transaction Type:</label>
        <select id="transaction_type" name="transaction_type" >
            <option value="">Select </option>
            <option value="credit">Credit</option>
            <option value="debit">Debit</option>
        </select>
        <!-- if (isset($_POST['submit_transaction'])) {
    $transaction_type = $_POST['transaction_type'];

    if (empty($transaction_type)) {
        $error_message = "Transaction type is required.";
    } else {
        // Proceed with transaction processing
    }
} -->

        <!-- if user does not enter transaction type -->
<!-- <script>
    // Attach event listener to the form's submit event
    document.querySelector('form').addEventListener('submit', function (e) {
        // Get the transaction type value
        const transactionType = document.getElementById('transaction_type').value;

        // Check if no valid option is selected
        if (transactionType === "") {
            // Prevent form submission
            e.preventDefault();

            // Show an alert message
            alert("Please select a transaction type.");
        }
    });
</script> -->



        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" placeholder="Enter amount" >

        <button type="submit" name="submit_transaction">Submit Transaction</button>
    </form>
     
</div>
</body>
</html>
