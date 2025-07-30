<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user input
$input_username = $_POST['username'];
$input_password = $_POST['password'];

// $input_password = password_hash($hashed_password, PASSWORD_DEFAULT);


// Prepare statements to prevent SQL injection
// Check in 'account' table
$user_stmt = $conn->prepare("SELECT account_number, name, username, password, money FROM account WHERE username = ?");
$user_stmt->bind_param("s", $input_username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

// Check in 'users' table (non-account holders)
$nonuser_stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$nonuser_stmt->bind_param("s", $input_username);
$nonuser_stmt->execute();
$nonuser_result = $nonuser_stmt->get_result();

// Check in 'admin' table
$admin_stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
$admin_stmt->bind_param("s", $input_username);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();

// Validate credentials
if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    if (password_verify($input_password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $user['name'];
        $_SESSION['acc_num'] = $user['account_number'];
        $_SESSION['mybalance'] = $user['money'];
        $_SESSION['role'] = 'user'; // Set role for future use
        header("Location: user_dashboard.php"); // Redirect to user dashboard
        exit();
    }
    else {
        // Invalid credentials
        echo "<script>alert('Invalid password'); window.location.href='login.html';</script>";
    }
}elseif ($admin_result->num_rows > 0) {
    // User found in 'admin' table
    session_start();
    $admin = $admin_result->fetch_assoc();

    // *Caution: Insecure password comparison*
    if ($input_password === $admin['password']) {
        $_SESSION['username'] = $admin['username'];
    
        $_SESSION['role'] = 'admin'; // Set role for future use
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        // Invalid password
        echo "<script>alert('Invalid password'); window.location.href='login.html';</script>";
        exit();
    }
}
    elseif ($nonuser_result->num_rows > 0) {
    $nonuser = $nonuser_result->fetch_assoc();
    if (password_verify($input_password, $nonuser['password'])) {
        session_start();
        $_SESSION['username'] = $nonuser['username'];
        $_SESSION['role'] = 'nonuser'; // Set role for future use
        header("Location: newindex.php"); // Redirect to index
        exit();
    }
    else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
    }
} else {
    // Invalid credentials
    echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
}

// Close statements and connection
$user_stmt->close();
$nonuser_stmt->close();
$admin_stmt->close();
$conn->close();
?>