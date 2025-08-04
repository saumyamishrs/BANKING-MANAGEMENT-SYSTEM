<?php 
$conn = new mysqli('localhost', 'root', '', 'testing');

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$father_name = $_POST['father_name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$occupation = $_POST['occupation'];
$pancard = $_POST['pancard'];
$aadhar = $_POST['aadhar'];
$address = $_POST['address'];
$marital_status = $_POST['marital_status'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$money = $_POST['money'];
$timestamp = date("Y-m-d H:i:s");

session_start();
$_SESSION['aname'] = $name;

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert data into `account` table
$query = "INSERT INTO `account` 
          (name, father_name, gender, phone, dob, occupation, pancard, aadhar, address, marital_status, username, password, email, created_at) 
          VALUES 
          ('$name', '$father_name', '$gender', '$phone', '$dob', '$occupation', '$pancard', '$aadhar', '$address', '$marital_status', '$username', '$hashed_password', '$email', '$timestamp')";

$data = mysqli_query($conn, $query);
//logic for getting amount to the user_request table
if ($data) {
    // Retrieve the account number for the newly inserted account
    $account_number = $conn->insert_id;  // Get the last inserted account number

    // Insert amount request into user_requests table if a requested amount is provided
    if (!empty($money) && $money > 0) {
        $query3 = "INSERT INTO user_requests (account_number, request_type, requested_amount) 
                  VALUES ('$account_number', 'amount', '$money')";
        $conn->query($query3);
    }

    // Display a success message
    echo "Welcome " . $_SESSION["aname"] . ", your account has been opened! For further details, go to the <a href=\"login.html\">Login Page</a> page.";
} else {
    echo "Error in inserting into `account`: " . $conn->error;
}

$conn->close();
?>
