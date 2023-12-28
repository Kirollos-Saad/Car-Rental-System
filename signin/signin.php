<?php
session_start(); // Start the session
include '../db_connect.php'; // Include the database connection file

// Retrieve email and password from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['signin-email'];
    $password = md5($_POST['signin-password']);

    $sql = "SELECT * FROM Customer WHERE email='$email' AND password_hash='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Store user data in session variables
        $_SESSION['user_id'] = $userData['customer_id'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_name'] = $userData['customer_name'];

        header("Location: ../Account/account.php");
        exit();
    } else {
        header("Location: signin.html?login=failed");
        exit();
    }
}

$conn->close(); // Close the database connection
?>
