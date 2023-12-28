<?php
include '../db_connect.php'; // Include the database connection file

// Retrieve email and password from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['signin-email'];
    $password = md5($_POST['signin-password']);

    
    $sql = "SELECT * FROM Customer WHERE email='$email' AND password_hash='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {    
        header("Location: ../Account/account.html");
        exit();
    } else {    
        header("Location: signin.html?login=failed");
        exit();
    }
}

$conn->close(); // Close the database connection
?>
