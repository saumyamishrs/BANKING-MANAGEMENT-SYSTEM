<?php
$conn = new mysqli('localhost','root','','testing');
if($conn) {
    echo "connection successful";
} else {
    die("Connection Failed : ". $conn->connect_error);
    // echo "error";
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$timestamp = date("Y-m-d H:i:s");
$hashed_password = password_hash($password,PASSWORD_DEFAULT);

// Check if username is already taken
$check_query = "SELECT * FROM users WHERE username = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("s", $name);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows >0) {
    echo "<script>alert('UserName already exists. Please choose a different one.'); window.location.href='signuppage.html';</script>";
    exit();
} else {
    // Insert new user
    $query = "INSERT INTO users VALUES (NULL,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiss", $name, $email, $phone, $hashed_password,$timestamp);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        ?>
        <script>
            alert("Data Saved Successfully");
        </script>
        <?php
    } else {
        echo "<script>alert('Error saving data.'); window.location.href='signuppage.html';</script>";
    }
}

header("Location: savingAcc.html");
?>