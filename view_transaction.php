<?php  
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "testing";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transactions
$sql = "SELECT m.id, m.account_number, m.transaction_type, m.amount, m.transaction_date, m.new_balance 
        FROM daybook_table m
        ORDER BY m.transaction_date DESC";
$result = $conn->query($sql);

// Fetch transaction counts for filtering
$transactionCounts = [];
$countQuery = "SELECT account_number, COUNT(*) as transaction_count 
               FROM daybook_table 
               GROUP BY account_number";
$countResult = $conn->query($countQuery);
if ($countResult->num_rows > 0) {
    while ($row = $countResult->fetch_assoc()) {
        $transactionCounts[$row['account_number']] = $row['transaction_count'];
    }
}

// CSS for table styling
echo "
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 20px;
    }

    h1 {
        text-align: center;
        color: #004080;
        margin-bottom: 20px;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    th, td {
        text-align: left;
        padding: 10px;
    }

    th {
        background-color: #004080;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    td {
        border-bottom: 1px solid #ddd;
    }

    caption {
        margin-bottom: 15px;
        font-size: 1.5em;
        color: #333;
    }

    .controls {
        text-align: center;
        margin: 20px;
    }

    .controls input[type='text'], 
    .controls input[type='number'], 
    .controls button {
        padding: 10px;
        margin: 5px;
        font-size: 16px;
    }

    .footer-summary {
        width: 90%;
        margin: 20px auto;
        font-size: 16px;
        text-align: center;
        padding: 10px;
        background-color: #e8f5e9;
        border: 1px solid #004080;
    }
</style>
";

// Header
echo "<h1>Transaction Records</h1>";

// Controls
echo "
<div class='controls'>
    <input type='text' id='accountNumberInput' placeholder='Enter Account Number'>
    <button onclick='filterByAccount()'>Filter by Account</button>
    <button onclick='sortTable(\"day\")'>Sort by Day</button>
    <button onclick='sortTable(\"month\")'>Sort by Month</button>
    <button onclick='sortTable(\"year\")'>Sort by Year</button>
    <input type='number' id='transactionThreshold' placeholder='Transaction Count Threshold'>
    <button onclick='filterByTransactionCount()'>Filter by Transaction Count</button>
    <button onclick='refreshPage()'>Refresh</button>
</div>
";

// Table
if ($result->num_rows > 0) {
    $totalTransactions = 0;
    $totalCredits = 0;
    $totalDebits = 0;

    echo "<table id='transactionTable'>
            <tr>
                <th>ID</th>
                <th>Account Number</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Transaction Date</th>
                <th>Available Balance</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $totalTransactions++;
        if ($row["transaction_type"] === "credit") {
            $totalCredits += $row["amount"];
        } else {
            $totalDebits += $row["amount"];
        }

        echo "<tr data-account='" . $row["account_number"] . "'>
                <td>" . $row["id"] . "</td>
                <td>" . $row["account_number"] . "</td>
                <td>" . ucfirst($row["transaction_type"]) . "</td>
                <td>₹" . number_format($row["amount"], 2) . "</td>
                <td>" . $row["transaction_date"] . "</td>
                <td>₹" . number_format($row["new_balance"], 2) . "</td>
            </tr>";
    }
    echo "</table>";

    // Footer summary
    echo "
    <div class='footer-summary'>
        <p>Total Transactions: $totalTransactions</p>
        <p>Total Credits: ₹" . number_format($totalCredits, 2) . "</p>
        <p>Total Debits: ₹" . number_format($totalDebits, 2) . "</p>
    </div>";
} else {
    echo "<p style='text-align: center; color: #555;'>No transactions found.</p>";
}

$conn->close();
?>

<script>
// JavaScript for sorting and filtering
function sortTable(period) {
    const rows = Array.from(document.querySelectorAll("#transactionTable tr:nth-child(n+2)"));
    rows.sort((a, b) => {
        const dateA = new Date(a.cells[4].innerText);
        const dateB = new Date(b.cells[4].innerText);

        if (period === "day") return dateA.getDate() - dateB.getDate();
        if (period === "month") return dateA.getMonth() - dateB.getMonth();
        if (period === "year") return dateA.getFullYear() - dateB.getFullYear();
        return 0;
    });

    rows.forEach(row => document.querySelector("#transactionTable").appendChild(row));
}

function filterByAccount() {
    const accountNumber = document.getElementById("accountNumberInput").value;
    const rows = document.querySelectorAll("#transactionTable tr:nth-child(n+2)");

    rows.forEach(row => {
        if (row.cells[1].innerText === accountNumber) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function filterByTransactionCount() {
    const threshold = parseInt(document.getElementById("transactionThreshold").value) || 0;
    const rows = document.querySelectorAll("#transactionTable tr:nth-child(n+2)");

    rows.forEach(row => {
        const account = row.getAttribute("data-account");
        const count = transactionCounts[account] || 0;

        if (count > threshold) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}

function refreshPage() {
    window.location.reload();
}

const transactionCounts = <?php echo json_encode($transactionCounts); ?>;
</script>