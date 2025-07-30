
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
    <title>Master Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 24px;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px #ccc;
        }
        .header, .nav {
            text-align: center;
            margin-bottom: 20px;
        }
        .header input[type="text"], .nav input[type="number"] {
            padding: 8px;
            margin: 5px;
            width: 20%;
        }
        .header button, .nav button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .header button:hover, .nav button:hover {
            background-color: #45a049;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #333;
        }
        .total-box {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            color: #333;
            background-color: #e8f5e9;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .no-records {
            text-align: center;
            color: red;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Customer Account Details</h1>

    <div class="header">
        <input type="text" id="searchAccountNumber" placeholder="Search by Account Number">
        <input type="text" id="searchName" placeholder="Search by Name">
        <input type="text" id="searchFatherName" placeholder="Search by Father's Name">
        <button onclick="filterTable()">Search</button>
        <button onclick="refreshPage()">Refresh</button>
    </div>

    <div class="nav">
        <button onclick="sortTable()">Sort Alphabetically</button>
        <input type="number" id="topBalanceInput" placeholder="Enter Top N Balances">
        <button onclick="showTopBalances()">Show Top Balances</button>
    </div>

    <?php
        $mycon = mysqli_connect("localhost", "root", "", "testing");

        if (!$mycon) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT * FROM account";
        $result = mysqli_query($mycon, $sql);

        $totalDeposit = 0;

        if (mysqli_num_rows($result) > 0) {
            echo "<table id='accountTable'>";
            echo "<tr>
                    <th>Account Number</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Father's Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>PAN Card Number</th>
                    <th>Aadhar Card</th>
                    <th>Occupation</th>
                    <th>Address</th>
                    <th>Marital Status</th>
                    <th>Balance</th>
                  </tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                $totalDeposit += $row['money'];
                echo "<tr>";
                echo "<td>" . $row['account_number'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['dob'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['father_name'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['pancard'] . "</td>";
                echo "<td>" . $row['aadhar'] . "</td>";
                echo "<td>" . $row['occupation'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['marital_status'] . "</td>";
                echo "<td>" . $row['money'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<div class='total-box'>Total Deposits: ₹" . number_format($totalDeposit, 2) . "</div>";
        } else {
            echo "<div class='no-records'>No records found</div>";
        }

        mysqli_close($mycon);
    ?>

    <script>
        function filterTable() {
            const accountNumber = document.getElementById("searchAccountNumber").value.toLowerCase();
            const name = document.getElementById("searchName").value.toLowerCase();
            const fatherName = document.getElementById("searchFatherName").value.toLowerCase();
            const table = document.getElementById("accountTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                const account = cells[0].innerText.toLowerCase();
                const userName = cells[1].innerText.toLowerCase();
                const father = cells[4].innerText.toLowerCase();

                if (account.includes(accountNumber) &&
                    userName.includes(name) &&
                    father.includes(fatherName)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        function sortTable() {
            const table = document.getElementById("accountTable");
            const rows = Array.from(table.rows).slice(1);

            rows.sort((a, b) => a.cells[1].innerText.localeCompare(b.cells[1].innerText));

            rows.forEach(row => table.appendChild(row));
        }

        function showTopBalances() {
            const input = document.getElementById("topBalanceInput").value;
            const topN = parseInt(input) || 0;

            const table = document.getElementById("accountTable");
            const rows = Array.from(table.rows).slice(1);

            rows.sort((a, b) => parseFloat(b.cells[12].innerText) - parseFloat(a.cells[12].innerText));

            rows.forEach((row, index) => {
                row.style.display = index < topN ? "" : "none";
            });
        }

        function refreshPage() {
            window.location.reload();
        }
    </script>
</body>
</html>