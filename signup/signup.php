<?php
include '../db_connect.php'; // Include the database connection file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Retrieve data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['signup-username'];
    $email = $_POST['signup-email'];
    $phone = $_POST['signup-phone'];
    $country = $_POST['signup-country'];
    $city = $_POST['signup-city'];
    $password = md5($_POST['signup-password']);
    $confirmPassword = md5($_POST['signup-confirm-password']);

    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        return;
    }

    $sql = "INSERT INTO Customer (customer_name, email, phone, country, city, password_hash) VALUES ('$username', '$email', '$phone', '$country', '$city', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "User signed up successfully.";
        header("Location: ../signin/signin.html?signup=success"); // Redirect user to signin.html
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close(); // Close the database connection
?>